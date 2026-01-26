<?php

namespace App\Services\YouTube;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;

class TranscriptApiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $maxRetries = 3;
    protected $retryDelay = 1000; // milliseconds

    public function __construct()
    {
        $this->apiKey = config('services.transcript_api.key');
        $this->baseUrl = config('services.transcript_api.base_url');

        if (empty($this->apiKey)) {
            Log::error('Transcript API key is not configured');
            throw new Exception('Transcript API key is not configured. Please set TRANSCRIPT_API_KEY in your .env file.');
        }
    }

    /**
     * Fetch and process transcript for a given YouTube video with retry logic.
     *
     * @param string $urlOrId
     * @return string
     * @throws Exception
     */
    public function getTranscript(string $urlOrId): string
    {
        $videoId = $this->extractVideoId($urlOrId);

        if (!$videoId) {
            throw new Exception("Invalid YouTube URL or Video ID provided.");
        }

        Log::info("Starting transcript fetch for video", ['video_id' => $videoId]);

        $lastError = null;
        $attempts = [];

        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                $result = $this->attemptFetch($videoId, $attempt);

                if (!empty($result)) {
                    Log::info("Transcript fetched successfully", [
                        'video_id' => $videoId,
                        'attempt' => $attempt,
                        'length' => strlen($result)
                    ]);
                    return $result;
                }

                $attempts[] = "Attempt {$attempt}: Transcript track exists but returned no content (possibly region-locked or corrupted)";

            } catch (Exception $e) {
                $lastError = $e;
                $attempts[] = "Attempt {$attempt}: " . $e->getMessage();

                Log::warning("Transcript fetch attempt failed", [
                    'video_id' => $videoId,
                    'attempt' => $attempt,
                    'error' => $e->getMessage()
                ]);

                // Don't retry on client errors (4xx)
                if ($this->isClientError($e)) {
                    break;
                }

                // Exponential backoff for retries
                if ($attempt < $this->maxRetries) {
                    $delay = $this->retryDelay * pow(2, $attempt - 1);
                    usleep($delay * 1000); // Convert to microseconds
                }
            }
        }

        // All attempts failed
        $errorMessage = "Failed to fetch transcript after trying multiple strategies. Attempts: " . implode(" | ", $attempts);

        Log::error("Transcript fetch failed completely", [
            'video_id' => $videoId,
            'total_attempts' => $this->maxRetries,
            'error_details' => $attempts
        ]);

        throw new Exception($errorMessage, 0, $lastError);
    }

    /**
     * Attempt to fetch transcript from the API.
     *
     * @param string $videoId
     * @param int $attempt
     * @return string
     * @throws Exception
     */
    protected function attemptFetch(string $videoId, int $attempt): string
    {
        $authHeader = $this->prepareAuthHeader();

        Log::debug("Making API request", [
            'video_id' => $videoId,
            'attempt' => $attempt,
            'endpoint' => "{$this->baseUrl}/youtube/transcript"
        ]);

        $response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->get("{$this->baseUrl}/youtube/transcript", [
                    'video_url' => $videoId, // The API accepts video_url or ID, but field name is video_url
                    'format' => 'json',
                    'include_timestamp' => true,
                ]);

        Log::debug("API response received", [
            'video_id' => $videoId,
            'attempt' => $attempt,
            'status' => $response->status(),
            'success' => $response->successful()
        ]);

        if ($response->failed()) {
            $this->handleFailedResponse($response, $videoId);
        }

        $data = $response->json();

        if (empty($data)) {
            throw new Exception("API returned empty response");
        }

        // Check for API-level errors
        if (isset($data['error'])) {
            throw new Exception("API Error: " . $data['error']);
        }

        if (isset($data['message']) && isset($data['code'])) {
            throw new Exception("API Error ({$data['code']}): " . $data['message']);
        }

        $transcript = $this->cleanTranscript($data);

        if (empty($transcript)) {
            throw new Exception("Transcript is empty after processing");
        }

        return $transcript;
    }

    /**
     * Prepare the authorization header.
     *
     * @return string
     */
    protected function prepareAuthHeader(): string
    {
        // The API key starts with 'sk_', which typically indicates a Bearer token
        if (str_starts_with($this->apiKey, 'Bearer ')) {
            return $this->apiKey;
        }
        return 'Bearer ' . $this->apiKey;
    }

    /**
     * Handle failed HTTP responses.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param string $videoId
     * @throws Exception
     */
    protected function handleFailedResponse($response, string $videoId): void
    {
        $status = $response->status();
        $body = $response->body();

        Log::error("Transcript API HTTP Error", [
            'video_id' => $videoId,
            'status' => $status,
            'body' => $body
        ]);

        $errorMessage = "HTTP {$status}: " . $response->reason();

        // Provide more specific error messages
        switch ($status) {
            case 401:
                throw new Exception("Authentication failed. Please check your API key.");
            case 403:
                throw new Exception("Access forbidden. Your API key may not have permission to access this resource.");
            case 404:
                throw new Exception("Video not found or transcript not available.");
            case 429:
                throw new Exception("Rate limit exceeded. Please try again later.");
            case 500:
            case 502:
            case 503:
            case 504:
                throw new Exception("Server error. Please try again later.");
            default:
                throw new Exception($errorMessage);
        }
    }

    /**
     * Check if an exception is a client error (4xx).
     *
     * @param Exception $e
     * @return bool
     */
    protected function isClientError(Exception $e): bool
    {
        $message = $e->getMessage();
        return str_contains($message, 'HTTP 4') ||
            str_contains($message, 'Authentication failed') ||
            str_contains($message, 'Access forbidden') ||
            str_contains($message, 'Video not found');
    }

    /**
     * Extract video ID from URL or return if already an ID.
     *
     * @param string $url
     * @return string|null
     */
    protected function extractVideoId(string $url): ?string
    {
        // Check if it's already a valid video ID (11 characters)
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        // Extract from various YouTube URL formats
        $patterns = [
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
            '/youtube\.com\/shorts\/([^"&?\/\s]{11})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Clean and normalize transcript data.
     *
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function cleanTranscript(array $data): string
    {
        // Try different possible response structures
        $raw = $data['transcript'] ?? $data['text'] ?? $data;

        if (is_string($raw)) {
            return $this->normalizeText($raw);
        }

        if (is_array($raw)) {
            $textParts = [];

            foreach ($raw as $segment) {
                if (is_string($segment)) {
                    $textParts[] = $segment;
                } elseif (is_array($segment) && isset($segment['text'])) {
                    $textParts[] = $segment['text'];
                } elseif (is_array($segment) && isset($segment['content'])) {
                    $textParts[] = $segment['content'];
                }
            }

            if (empty($textParts)) {
                throw new Exception("No transcript segments found in response");
            }

            return $this->normalizeText(implode(" ", $textParts));
        }

        throw new Exception("Unexpected transcript format. Expected string or array, got: " . gettype($raw));
    }

    /**
     * Normalize text by removing timestamps, extra whitespace, etc.
     *
     * @param string $text
     * @return string
     */
    protected function normalizeText(string $text): string
    {
        // Remove timestamps in various formats (e.g., [00:00:00], 00:00:00, etc.)
        $text = preg_replace('/\[\d{1,2}:\d{2}(:\d{2})?\]/', '', $text);
        $text = preg_replace('/\d{1,2}:\d{2}(:\d{2})?\s*-\s*\d{1,2}:\d{2}(:\d{2})?/', '', $text);

        // Remove speaker labels if present (e.g., [Speaker 1:], Speaker 1:)
        $text = preg_replace('/\[Speaker\s*\d+\s*:\s*\]/i', '', $text);
        $text = preg_replace('/Speaker\s*\d+\s*:\s*/i', '', $text);

        // Remove music tags and sound effects
        $text = preg_replace('/\[(music|applause|laughter|sound effect)\]/i', '', $text);

        // Normalize whitespace
        $text = preg_replace('/\s+/', ' ', $text);

        // Remove leading/trailing whitespace and punctuation
        $text = trim($text);

        // Remove multiple consecutive punctuation
        $text = preg_replace('/([.!?])\1+/', '$1', $text);

        return $text;
    }

    /**
     * Validate if a video ID is valid.
     *
     * @param string $videoId
     * @return bool
     */
    public function isValidVideoId(string $videoId): bool
    {
        return preg_match('/^[a-zA-Z0-9_-]{11}$/', $videoId) === 1;
    }
}
