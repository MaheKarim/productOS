<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\YouTube\YouTubeService;
use App\Services\YouTube\TranscriptApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessYouTubeVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutes for transcript fetching
    public $tries = 3; // Maximum 3 attempts
    public $backoff = [60, 300, 900]; // Exponential backoff: 1min, 5min, 15min

    public function __construct(public Video $video)
    {
        $this->onQueue('youtube-processing');
    }

    public function handle(YouTubeService $youTubeService, TranscriptApiService $transcriptService): void
    {
        $videoId = $this->video->video_id_str;

        Log::info("Starting video processing", [
            'video_id' => $videoId,
            'video_db_id' => $this->video->id,
            'attempt' => $this->attempts(),
        ]);

        try {
            $this->video->update(['processing_status' => 'processing']);

            // 1. Fetch Transcript if not present
            if (empty($this->video->transcript)) {
                // Increment fetch attempts
                $this->video->increment('transcript_fetch_attempts');

                try {
                    Log::info("Fetching transcript", [
                        'video_id' => $videoId,
                        'attempt' => $this->attempts()
                    ]);

                    $transcript = $transcriptService->getTranscript($videoId);

                    if (empty($transcript)) {
                        throw new Exception("Transcript is empty after processing");
                    }

                    $this->video->update([
                        'transcript' => $transcript,
                        'transcript_fetch_error' => null,
                        'transcript_fetched_at' => now(),
                    ]);

                    Log::info("Transcript fetched successfully", [
                        'video_id' => $videoId,
                        'length' => strlen($transcript)
                    ]);

                } catch (Exception $e) {
                    // Transcript fetch failed
                    $errorMessage = $e->getMessage();

                    Log::warning("Transcript fetch failed", [
                        'video_id' => $videoId,
                        'error' => $errorMessage,
                        'attempt' => $this->attempts()
                    ]);

                    // Check if this is a permanent error (don't retry)
                    if ($this->isPermanentError($e)) {
                        Log::info("Permanent error detected, marking video as failed", [
                            'video_id' => $videoId,
                            'error' => $errorMessage
                        ]);

                        $this->video->update([
                            'transcript' => null,
                            'transcript_fetch_error' => $errorMessage,
                            'processing_status' => 'failed',
                        ]);

                        return; // Exit without retrying
                    }

                    // Set transcript to null and record error, but allow retry
                    $this->video->update([
                        'transcript' => null,
                        'transcript_fetch_error' => $errorMessage,
                    ]);

                    // Re-throw to trigger retry
                    throw $e;
                }
            } else {
                Log::info("Transcript already exists, skipping fetch", [
                    'video_id' => $videoId
                ]);
            }

            // 2. Refresh metadata if needed (optional, can be enabled later)
            // $this->refreshMetadata($youTubeService);

            // 3. Dispatch AI Analysis only if transcript exists
            if (!empty($this->video->transcript)) {
                GenerateAiAnalysis::dispatch($this->video);

                Log::info("AI Analysis dispatched", [
                    'video_id' => $videoId
                ]);
            } else {
                // Mark video as completed without AI analysis
                $this->video->update(['processing_status' => 'completed']);

                Log::info("Video marked as completed without AI analysis", [
                    'video_id' => $videoId,
                    'reason' => 'no transcript available'
                ]);
            }

        } catch (Exception $e) {
            Log::error("Video processing failed", [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'attempt' => $this->attempts()
            ]);

            $this->video->update(['processing_status' => 'failed']);

            // Re-throw to let Laravel handle the retry logic
            throw $e;
        }
    }

    /**
     * Determine if an error is permanent (should not retry).
     *
     * @param Exception $e
     * @return bool
     */
    protected function isPermanentError(Exception $e): bool
    {
        $message = $e->getMessage();

        // Don't retry for these errors
        $permanentErrors = [
            'Invalid YouTube URL',
            'Video not found',
            'Authentication failed',
            'Access forbidden',
            'API key is not configured',
            'private video',
            'video is not available',
        ];

        foreach ($permanentErrors as $error) {
            if (str_contains(strtolower($message), strtolower($error))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Optional: Refresh video metadata from YouTube API.
     *
     * @param YouTubeService $youTubeService
     * @return void
     */
    protected function refreshMetadata(YouTubeService $youTubeService): void
    {
        try {
            $metadata = $youTubeService->fetchMetadata($this->video->video_id_str);

            $this->video->update([
                'title' => $metadata['title'] ?? $this->video->title,
                'channel_name' => $metadata['channel_name'] ?? $this->video->channel_name,
                'channel_id' => $metadata['channel_id'] ?? $this->video->channel_id,
                'thumbnail_url' => $metadata['thumbnail_url'] ?? $this->video->thumbnail_url,
                'upload_date' => $metadata['upload_date'] ?? $this->video->upload_date,
                'duration' => $metadata['duration'] ?? $this->video->duration,
                'view_count' => $metadata['view_count'] ?? $this->video->view_count,
            ]);

            Log::info("Video metadata refreshed", [
                'video_id' => $this->video->video_id_str
            ]);

        } catch (Exception $e) {
            Log::warning("Failed to refresh video metadata", [
                'video_id' => $this->video->video_id_str,
                'error' => $e->getMessage()
            ]);
            // Don't fail the entire process if metadata refresh fails
        }
    }

    /**
     * Handle job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::error("Video processing job failed permanently", [
            'video_id' => $this->video->video_id_str,
            'attempts' => $this->attempts(),
            'error' => $exception->getMessage(),
        ]);

        $this->video->update([
            'processing_status' => 'failed',
            'transcript_fetch_error' => $exception->getMessage(),
        ]);
    }
}
