<?php

namespace App\Jobs;

use App\Models\Video;
use App\Models\AiOutput;
use App\Services\AI\AiProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GenerateAiAnalysis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // 10 minutes for AI generation

    public function __construct(public Video $video)
    {
    }

    public function handle(AiProcessingService $aiService): void
    {
        try {
            $provider = $this->video->aiProvider;

            if (!$provider) {
                throw new \Exception("No AI Provider assigned to video.");
            }

            // check if transcript exists
            if (empty($this->video->transcript)) {
                throw new \Exception("No transcript available for analysis. Video ID: {$this->video->video_id_str}. The video may not have captions or they may be region-locked.");
            }

            // Call AI Service
            $results = $aiService->process($this->video, $provider);

            DB::transaction(function () use ($results) {
                // Save Outputs
                AiOutput::updateOrCreate(
                    ['video_id' => $this->video->id],
                    [
                        'summary_english' => $results['summary_english'] ?? null,
                        'summary_bangla' => $results['summary_bangla'] ?? null,
                        'actionable_skills' => $results['actionable_skills'] ?? null,
                        'faqs' => $results['faqs'] ?? null,
                        'key_insights' => $results['key_insights'] ?? null,
                        'read_reason' => $results['read_reason'] ?? null,
                        'generated_at' => now(),
                    ]
                );

                // Update Status
                $this->video->update(['processing_status' => 'completed']);

                // Auto-classify topics if returned
                if (!empty($results['topics'])) {
                    ClassifyVideoJob::dispatch($this->video, $results['topics']);
                }

                Log::info("AI Analysis completed successfully for video {$this->video->id}");
            });

        } catch (\Exception $e) {
            Log::error("AI Analysis Failed: {$this->video->id} - " . $e->getMessage(), [
                'video_id_str' => $this->video->video_id_str,
                'has_transcript' => !empty($this->video->transcript),
                'transcript_length' => $this->video->transcript ? strlen($this->video->transcript) : 0,
            ]);
            $this->video->update(['processing_status' => 'failed']);
        }
    }
}
