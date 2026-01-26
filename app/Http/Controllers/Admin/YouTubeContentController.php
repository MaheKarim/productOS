<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\YouTube\TranscriptApiService;
use App\Services\AI\AiProcessingService;
use App\Models\AiProvider;
use App\Models\Video;
use App\Models\AiOutput;
use App\Models\AiRequestLog;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class YouTubeContentController extends Controller
{
    protected $transcriptService;
    protected $aiService;

    public function __construct(TranscriptApiService $transcriptService, AiProcessingService $aiService)
    {
        $this->transcriptService = $transcriptService;
        $this->aiService = $aiService;
    }

    /**
     * Generate AI content from a YouTube video transcript.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request)
    {
        $request->validate([
            'url_or_id' => 'required|string',
            'system_prompt' => 'nullable|string',
            'provider_id' => 'nullable|exists:ai_providers,id',
        ]);

        $startTime = microtime(true);
        $urlOrId = $request->input('url_or_id');
        $videoId = $this->extractVideoId($urlOrId);

        Log::info('Starting YouTube content generation', [
            'video_id' => $videoId,
            'url_or_id' => $urlOrId,
            'user_id' => auth()->id(),
        ]);

        try {
            // Step 1: Fetch Transcript
            Log::info('Fetching transcript', ['video_id' => $videoId]);
            $transcript = $this->transcriptService->getTranscript($urlOrId);

            if (empty($transcript)) {
                throw new Exception('Transcript is empty after processing');
            }

            Log::info('Transcript fetched successfully', [
                'video_id' => $videoId,
                'transcript_length' => strlen($transcript)
            ]);

            // Step 2: Determine AI Provider
            $provider = $this->getAiProvider($request);

            Log::info('AI Provider selected', [
                'provider_id' => $provider->id,
                'provider_name' => $provider->name
            ]);

            // Step 3: Prepare System Prompt
            $systemPrompt = $this->getSystemPrompt($request);

            // Step 4: Generate Content
            Log::info('Starting AI processing', [
                'video_id' => $videoId,
                'provider_id' => $provider->id
            ]);

            $aiContent = $this->aiService->processText($transcript, $systemPrompt, $provider);

            $duration = microtime(true) - $startTime;

            // Step 5: Store results in database
            $this->storeResults($videoId, $transcript, $aiContent, $provider, $duration, $systemPrompt);

            Log::info('Content generation completed successfully', [
                'video_id' => $videoId,
                'duration' => round($duration, 2),
                'provider_used' => $provider->name
            ]);

            return response()->json([
                'success' => true,
                'data' => $aiContent,
                'metadata' => [
                    'source_video' => $urlOrId,
                    'video_id' => $videoId,
                    'processing_time_seconds' => round($duration, 2),
                    'provider_used' => $provider->name,
                    'transcript_length' => strlen($transcript),
                    'timestamp' => Carbon::now()->toISOString(),
                ]
            ]);

        } catch (Exception $e) {
            $duration = microtime(true) - $startTime;

            // Log the error with context
            Log::error('YouTube Content Generation Failed', [
                'video_id' => $videoId,
                'url_or_id' => $urlOrId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => round($duration, 2),
                'user_id' => auth()->id(),
            ]);

            // Log AI request failure
            $this->logAiRequestFailure($videoId, $e->getMessage(), $duration);

            // Determine appropriate HTTP status code
            $statusCode = $this->determineStatusCode($e);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'metadata' => [
                    'video_id' => $videoId,
                    'processing_time_seconds' => round($duration, 2),
                    'timestamp' => Carbon::now()->toISOString(),
                ]
            ], $statusCode);
        }
    }

    /**
     * Get or create video record and store results.
     *
     * @param string $videoId
     * @param string $transcript
     * @param array $aiContent
     * @param AiProvider $provider
     * @param float $duration
     * @param string $systemPrompt
     * @return void
     */
    protected function storeResults(string $videoId, string $transcript, array $aiContent, AiProvider $provider, float $duration, string $systemPrompt): void
    {
        try {
            DB::beginTransaction();

            // Find or create video record
            $video = Video::firstOrCreate(
                ['video_id_str' => $videoId],
                [
                    'youtube_url' => "https://www.youtube.com/watch?v={$videoId}",
                    'transcript' => $transcript,
                    'transcript_fetched_at' => now(),
                    'processing_status' => 'completed',
                    'ai_provider_id' => $provider->id,
                    'system_prompt' => $systemPrompt,
                ]
            );

            // Update if video already exists
            if (!$video->wasRecentlyCreated) {
                $video->update([
                    'transcript' => $transcript,
                    'transcript_fetched_at' => now(),
                    'processing_status' => 'completed',
                    'ai_provider_id' => $provider->id,
                    'system_prompt' => $systemPrompt,
                ]);
            }

            // Store AI output - map to correct table fields
            AiOutput::updateOrCreate(
                ['video_id' => $video->id],
                [
                    'summary_english' => $aiContent['summary'] ?? null,
                    'summary_bangla' => $aiContent['summary_bangla'] ?? null,
                    'key_insights' => $aiContent['key_points'] ?? [],
                    'actionable_skills' => $aiContent['action_items'] ?? [],
                    'faqs' => $aiContent['faqs'] ?? [],
                    'read_reason' => $aiContent['read_reason'] ?? ($aiContent['target_audience'] ?? null),
                    'generated_at' => now(),
                ]
            );

            // Log successful AI request - use correct field names
            AiRequestLog::create([
                'ai_provider_id' => $provider->id,
                'model' => $provider->default_model,
                'status' => 'success',
                'response_time_ms' => (int) ($duration * 1000),
                'input_tokens' => $aiContent['usage']['input_tokens'] ?? null,
                'output_tokens' => $aiContent['usage']['output_tokens'] ?? null,
                'cost' => $aiContent['cost'] ?? 0,
                'endpoint' => '/chat/completions',
                'metadata' => [
                    'video_id' => $videoId,
                    'transcript_length' => strlen($transcript),
                ],
            ]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to store results', [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
            ]);
            // Don't throw here - we already have the content to return
        }
    }

    /**
     * Log AI request failure.
     *
     * @param string $videoId
     * @param string $errorMessage
     * @param float $duration
     * @return void
     */
    protected function logAiRequestFailure(string $videoId, string $errorMessage, float $duration): void
    {
        try {
            $video = Video::where('video_id_str', $videoId)->first();

            if ($video) {
                AiRequestLog::create([
                    'video_id' => $video->id,
                    'provider_id' => null,
                    'prompt' => null,
                    'response' => null,
                    'tokens_used' => null,
                    'cost' => null,
                    'status' => 'failed',
                    'error_message' => $errorMessage,
                    'processing_time' => $duration,
                ]);
            }
        } catch (Exception $e) {
            Log::error('Failed to log AI request failure', [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get AI provider from request or default.
     *
     * @param Request $request
     * @return AiProvider
     * @throws Exception
     */
    protected function getAiProvider(Request $request): AiProvider
    {
        if ($request->has('provider_id')) {
            $provider = AiProvider::find($request->input('provider_id'));
        } else {
            $provider = AiProvider::where('is_default', true)->first()
                ?? AiProvider::where('is_active', true)->first();
        }

        if (!$provider) {
            throw new Exception('No active AI Provider found. Please configure an AI provider first.');
        }

        return $provider;
    }

    /**
     * Get system prompt from request or default.
     *
     * @param Request $request
     * @return string
     */
    protected function getSystemPrompt(Request $request): string
    {
        return $request->input('system_prompt') ?? $this->getDefaultPrompt();
    }

    /**
     * Extract video ID from URL or ID.
     *
     * @param string $urlOrId
     * @return string
     */
    protected function extractVideoId(string $urlOrId): string
    {
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $urlOrId)) {
            return $urlOrId;
        }

        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $urlOrId, $matches)) {
            return $matches[1];
        }

        return $urlOrId; // Return as-is if can't extract
    }

    /**
     * Determine appropriate HTTP status code based on exception.
     *
     * @param Exception $e
     * @return int
     */
    protected function determineStatusCode(Exception $e): int
    {
        $message = $e->getMessage();

        if (str_contains($message, 'Invalid YouTube URL')) {
            return 400;
        }

        if (str_contains($message, 'Authentication failed') || str_contains($message, 'API key')) {
            return 401;
        }

        if (str_contains($message, 'Video not found') || str_contains($message, 'Transcript not available')) {
            return 404;
        }

        if (str_contains($message, 'Rate limit')) {
            return 429;
        }

        if (str_contains($message, 'No active AI Provider')) {
            return 400;
        }

        return 500;
    }

    /**
     * Get default system prompt.
     *
     * @return string
     */
    protected function getDefaultPrompt(): string
    {
        return <<<EOT
You are an expert content analyst. Analyze the following YouTube video transcript and provide a comprehensive analysis.

Transcript:
{transcript}

---

Generate the following analysis in valid JSON format (without markdown formatting):
{
    "summary": "A concise 2-3 sentence summary of the video's main topic and key message.",
    "key_points": [
        "First key point or insight from the video",
        "Second key point or insight",
        "Third key point or insight",
        "Fourth key point or insight"
    ],
    "action_items": [
        "Specific action item 1 that viewers can take",
        "Specific action item 2 that viewers can take"
    ],
    "tone": "The overall tone of the video (e.g., Educational, Inspirational, Technical, Humorous, Serious)",
    "sentiment": "The emotional tone (Positive, Neutral, or Negative)",
    "target_audience": "Who would benefit most from this video (e.g., beginners, professionals, students)",
    "difficulty_level": "The complexity level (Beginner, Intermediate, or Advanced)"
}

Important guidelines:
- Ensure the JSON is valid and can be parsed
- Keep the summary concise but informative
- Extract only the most important points (4-5 max)
- Action items should be practical and actionable
- Be objective and accurate in your analysis
EOT;
    }
}
