<?php

namespace App\Jobs;

use App\Models\Topic;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ClassifyVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Video $video,
        public array $topics
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("ClassifyVideoJob started for Video ID: {$this->video->id} with " . count($this->topics) . " topics.");

        if (empty($this->topics)) {
            return;
        }

        $validTopicIds = [];

        foreach ($this->topics as $topicItem) {
            $name = null;
            $confidence = null;

            // Handle both string array and associative array with scores
            if (is_string($topicItem)) {
                $name = $topicItem;
            } elseif (is_array($topicItem) && isset($topicItem['name'])) {
                $name = $topicItem['name'];
                $confidence = $topicItem['confidence'] ?? null; // e.g., 0.95
            }

            if (empty($name)) {
                continue;
            }

            // Normalize
            $name = trim($name);

            // Create or Find Topic
            $topic = Topic::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );

            // Prepare pivot data
            $pivotData = [];
            if ($confidence !== null) {
                // Assuming confidence_score is usually 0-1 or 0-100?
                // I'll assume strict value passed from AI.
                $pivotData['confidence_score'] = $confidence;
            }

            // We collect IDs for sync, but if we have pivot data differing per ID, sync accepts [id => pivotData]
            $validTopicIds[$topic->id] = $pivotData;
        }

        if (!empty($validTopicIds)) {
            $this->video->topics()->sync($validTopicIds);
            Log::info("ClassifyVideoJob synced " . count($validTopicIds) . " topics for Video ID: {$this->video->id}");
        }
    }
}
