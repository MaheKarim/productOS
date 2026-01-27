<?php

namespace App\Services\AI;

use App\Models\AiProvider;
use App\Models\AiRequestLog;
use App\Models\Video;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AiProcessingService
{
    protected $timeout = 120;
    protected $maxRetries = 2;
    protected $retryDelay = 1000; // milliseconds

    /**
     * Process a video with AI analysis.
     *
     * @param Video $video
     * @param AiProvider $provider
     * @return array
     * @throws Exception
     */
    public function process(Video $video, AiProvider $provider): array
    {
        Log::info("Starting AI processing for video", [
            'video_id' => $video->id,
            'video_str_id' => $video->video_id_str,
            'provider_id' => $provider->id,
            'provider_name' => $provider->name,
        ]);

        // 1. Construct the prompt
        $prompt = $this->buildPrompt($video);

        // 2. Call the API with retry logic
        $response = $this->callApiWithRetry($provider, $prompt);

        // 3. Parse the JSON response
        $result = $this->parseResponse($response);

        Log::info("AI processing completed successfully", [
            'video_id' => $video->id,
            'provider_id' => $provider->id,
        ]);

        return $result;
    }

    /**
     * Process raw transcript text with a system prompt.
     *
     * @param string $transcript
     * @param string $systemPrompt
     * @param AiProvider $provider
     * @return array
     * @throws Exception
     */
    public function processText(string $transcript, string $systemPrompt, AiProvider $provider): array
    {
        Log::info("Starting AI text processing", [
            'provider_id' => $provider->id,
            'provider_name' => $provider->name,
            'transcript_length' => strlen($transcript),
        ]);

        // Replace placeholder or append
        if (str_contains($systemPrompt, '{transcript}')) {
            $prompt = str_replace('{transcript}', $transcript, $systemPrompt);
        } else {
            $prompt = $systemPrompt . "\n\nTranscript:\n" . $transcript;
        }

        $response = $this->callApiWithRetry($provider, $prompt);
        $result = $this->parseResponse($response);

        Log::info("AI text processing completed successfully", [
            'provider_id' => $provider->id,
        ]);

        return $result;
    }

    /**
     * Build prompt from video data.
     *
     * @param Video $video
     * @return string
     */
    protected function buildPrompt(Video $video): string
    {
        $transcript = $video->transcript;

        // Truncate if necessary to avoid exceeding token limits
        $maxTranscriptLength = 50000; // Adjust based on model context window
        if (strlen($transcript) > $maxTranscriptLength) {
            Log::warning("Transcript truncated for processing", [
                'video_id' => $video->id,
                'original_length' => strlen($transcript),
                'truncated_length' => $maxTranscriptLength,
            ]);
            $transcript = substr($transcript, 0, $maxTranscriptLength) . "... [transcript truncated]";
        }

        if (!empty($video->system_prompt)) {
            return str_replace(
                ['{title}', '{channel}', '{transcript}'],
                [$video->title, $video->channel_name, $transcript],
                $video->system_prompt
            );
        }

        return <<<EOT
You are an expert content analyst with Bengali/Bangla translation capabilities.
Analyze the following YouTube video transcript and provided metadata.
Output MUST be valid JSON only, without markdown formatting.

Video Title: {$video->title}
Channel: {$video->channel_name}

Transcript:
{$transcript}

---

Generate the following analysis in JSON format:
{
    "summary_english": "3-5 paragraph executive summary, no fluff.",
    "summary_bangla": "MANDATORY BENGALI TRANSLATION - Translate the entire summary_english into Bengali script. Example: 'This video discusses AI' becomes 'এই ভিডিওটি এআই নিয়ে আলোচনা করে'. You MUST provide a complete Bengali translation. NULL IS NOT ACCEPTABLE.",
    "actionable_skills": [
        {"skill": "Skill Name", "context": "Brief context"}
    ],
    "faqs": [
        {"question": "Q?", "answer": "A", "timestamp": "00:00"}
    ],
    "key_insights": [
        {"insight": "Insight text", "timestamp": "00:00", "type": "quote|stat|example"}
    ],
    "read_reason": "Why read/watch this? Target audience & outcomes.",
    "topics": ["topic1", "topic2"]
}

CRITICAL REQUIREMENT: 
- summary_bangla MUST contain a Bengali translation of summary_english
- Use Bengali script (বাংলা লিপি) 
- If you cannot translate, use a translation service
- Returning null for summary_bangla is FORBIDDEN
EOT;
    }

    /**
     * Call AI API with retry logic.
     *
     * @param AiProvider $provider
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    protected function callApiWithRetry(AiProvider $provider, string $prompt): string
    {
        $lastError = null;

        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            try {
                $response = $this->callApi($provider, $prompt);
                return $response;
            } catch (Exception $e) {
                $lastError = $e;

                Log::warning("AI API call attempt failed", [
                    'provider_id' => $provider->id,
                    'attempt' => $attempt,
                    'error' => $e->getMessage(),
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

        throw $lastError;
    }

    /**
     * Call AI API.
     *
     * @param AiProvider $provider
     * @param string $prompt
     * @return string
     * @throws Exception
     */
    protected function callApi(AiProvider $provider, string $prompt): string
    {
        $startTime = microtime(true);
        $apiKey = $provider->api_key;
        $baseUrl = $provider->base_url;
        $model = $provider->default_model;

        if (empty($apiKey)) {
            throw new Exception("API key is not configured for provider: {$provider->name}");
        }

        if (empty($baseUrl)) {
            throw new Exception("Base URL is not configured for provider: {$provider->name}");
        }

        if (empty($model)) {
            throw new Exception("Default model is not configured for provider: {$provider->name}");
        }

        // Normalize URL (remove trailing slash)
        $baseUrl = rtrim($baseUrl, '/');

        // Determine endpoint and request format based on provider
        $isGemini = stripos($provider->name, 'gemini') !== false || stripos($provider->slug ?? '', 'gemini') !== false;

        if ($isGemini) {
            // Gemini API format
            $endpoint = "$baseUrl/models/$model:generateContent?key=$apiKey";

            Log::debug("Making AI API request", [
                'provider' => $provider->name,
                'model' => $model,
                'endpoint' => str_replace($apiKey, '***', $endpoint),
                'prompt_length' => strlen($prompt),
                'api_type' => 'gemini'
            ]);

            $response = Http::timeout($this->timeout)
                ->post($endpoint, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'maxOutputTokens' => $provider->max_tokens ?? 4096,
                        'responseMimeType' => 'application/json'
                    ]
                ]);
        } else {
            // OpenAI-compatible format
            $endpoint = "$baseUrl/chat/completions";

            Log::debug("Making AI API request", [
                'provider' => $provider->name,
                'model' => $model,
                'endpoint' => $endpoint,
                'prompt_length' => strlen($prompt),
                'api_type' => 'openai'
            ]);

            $response = Http::withToken($apiKey)
                ->timeout($this->timeout)
                ->post($endpoint, [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful AI assistant that provides accurate, well-structured responses in valid JSON format. Be concise.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => $provider->max_tokens ?? 4096,
                    'response_format' => ['type' => 'json_object']
                ]);
        }

        if (!$response->successful()) {
            $this->handleFailedResponse($response, $provider, $startTime, $model);
        }

        $data = $response->json();

        // Parse response based on provider type
        if ($isGemini) {
            // Gemini response format
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::error("Unexpected Gemini API response structure", [
                    'provider' => $provider->name,
                    'response' => $data,
                ]);
                throw new Exception("Unexpected response structure from Gemini API");
            }

            $content = $data['candidates'][0]['content']['parts'][0]['text'];
            $tokensUsed = ($data['usageMetadata']['totalTokenCount'] ?? null);
        } else {
            // OpenAI-compatible response format
            if (!isset($data['choices'][0]['message']['content'])) {
                Log::error("Unexpected AI API response structure", [
                    'provider' => $provider->name,
                    'response' => $data,
                ]);
                throw new Exception("Unexpected response structure from AI API");
            }

            $content = $data['choices'][0]['message']['content'];
            $tokensUsed = $data['usage']['total_tokens'] ?? null;
        }

        // Calculate response time
        $responseTimeMs = (int) ((microtime(true) - $startTime) * 1000);

        // Extract token usage for logging
        $inputTokens = null;
        $outputTokens = null;
        if ($isGemini) {
            $inputTokens = $data['usageMetadata']['promptTokenCount'] ?? null;
            $outputTokens = $data['usageMetadata']['candidatesTokenCount'] ?? null;
        } else {
            $inputTokens = $data['usage']['prompt_tokens'] ?? null;
            $outputTokens = $data['usage']['completion_tokens'] ?? null;
        }

        // Log successful request to database
        AiRequestLog::logSuccess(
            $provider->id,
            $model,
            $responseTimeMs,
            $inputTokens,
            $outputTokens,
            0, // Cost calculation can be added later
            $isGemini ? '/models/' . $model . ':generateContent' : '/chat/completions'
        );

        Log::info("AI API request successful", [
            'provider' => $provider->name,
            'tokens_used' => $tokensUsed,
            'response_time_ms' => $responseTimeMs,
            'response_length' => strlen($content),
        ]);

        return $content;
    }

    /**
     * Handle failed AI API responses.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @param AiProvider $provider
     * @param float $startTime
     * @param string $model
     * @throws Exception
     */
    protected function handleFailedResponse($response, AiProvider $provider, float $startTime = 0, string $model = ''): void
    {
        $status = $response->status();
        $body = $response->body();
        $responseTimeMs = $startTime > 0 ? (int) ((microtime(true) - $startTime) * 1000) : 0;

        Log::error("AI API HTTP Error", [
            'provider' => $provider->name,
            'status' => $status,
            'body' => $body,
        ]);

        $errorMessage = "HTTP {$status}: " . $response->reason();

        // Log failed request to database
        if ($provider->id && $model) {
            AiRequestLog::logError(
                $provider->id,
                $model,
                $responseTimeMs,
                $errorMessage,
                '/chat/completions'
            );
        }

        // Provide more specific error messages
        switch ($status) {
            case 401:
                throw new Exception("Authentication failed for AI provider '{$provider->name}'. Please check your API key.");
            case 403:
                throw new Exception("Access forbidden for AI provider '{$provider->name}'. Your API key may not have permission.");
            case 429:
            case 413:
                throw new Exception("Rate limit exceeded for AI provider '{$provider->name}'. Please try again later.");
            case 500:
            case 502:
            case 503:
            case 504:
                throw new Exception("Server error from AI provider '{$provider->name}'. Please try again later.");
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
            str_contains($message, 'Access forbidden');
    }

    /**
     * Parse AI response and validate JSON.
     *
     * @param string $rawContent
     * @return array
     * @throws Exception
     */
    protected function parseResponse(string $rawContent): array
    {
        // Clean up the response if it contains markdown code blocks
        $rawContent = preg_replace('/```json\s*/', '', $rawContent);
        $rawContent = preg_replace('/```\s*/', '', $rawContent);
        $rawContent = trim($rawContent);

        $data = json_decode($rawContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Failed to parse AI response as JSON", [
                'error' => json_last_error_msg(),
                'content_preview' => substr($rawContent, 0, 500),
            ]);
            throw new Exception("Invalid JSON from AI: " . json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new Exception("AI response is not a valid JSON object");
        }

        return $data;
    }
}
