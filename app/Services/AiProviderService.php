<?php

namespace App\Services;

use App\Models\AiProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiProviderService
{
    /**
     * Test connection to an AI provider.
     *
     * @param AiProvider $provider
     * @return array{success: bool, message: string, data?: array}
     */
    public function testConnection(AiProvider $provider): array
    {
        try {
            $apiKey = $provider->api_key;

            if (!$apiKey) {
                return [
                    'success' => false,
                    'message' => 'API key is not configured or could not be decrypted.',
                ];
            }

            return match ($provider->slug) {
                'openrouter' => $this->testOpenRouter($provider, $apiKey),
                'groq' => $this->testGroq($provider, $apiKey),
                'zai' => $this->testZai($provider, $apiKey),
                'gemini' => $this->testGemini($provider, $apiKey),
                default => [
                    'success' => false,
                    'message' => 'Unknown provider: ' . $provider->slug,
                ],
            };
        } catch (\Exception $e) {
            Log::error('AI Provider connection test failed', [
                'provider' => $provider->slug,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Test OpenRouter API connection.
     */
    protected function testOpenRouter(AiProvider $provider, string $apiKey): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models');

        if ($response->successful()) {
            $models = $response->json('data', []);
            return [
                'success' => true,
                'message' => 'Connection successful! Found ' . count($models) . ' available models.',
                'data' => [
                    'models_count' => count($models),
                ],
            ];
        }

        return [
            'success' => false,
            'message' => 'API returned error: ' . ($response->json('error.message') ?? $response->status()),
        ];
    }

    /**
     * Test Groq API connection.
     */
    protected function testGroq(AiProvider $provider, string $apiKey): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models');

        if ($response->successful()) {
            $models = $response->json('data', []);
            return [
                'success' => true,
                'message' => 'Connection successful! Found ' . count($models) . ' available models.',
                'data' => [
                    'models_count' => count($models),
                ],
            ];
        }

        return [
            'success' => false,
            'message' => 'API returned error: ' . ($response->json('error.message') ?? $response->status()),
        ];
    }

    /**
     * Test Z.AI API connection.
     */
    protected function testZai(AiProvider $provider, string $apiKey): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models');

        if ($response->successful()) {
            $models = $response->json('data', []);
            return [
                'success' => true,
                'message' => 'Connection successful! Found ' . count($models) . ' available models.',
                'data' => [
                    'models_count' => count($models),
                ],
            ];
        }

        return [
            'success' => false,
            'message' => 'API returned error: ' . ($response->json('error.message') ?? $response->status()),
        ];
    }

    /**
     * Test Gemini/Google AI Studio API connection.
     */
    protected function testGemini(AiProvider $provider, string $apiKey): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models', ['key' => $apiKey]);

        if ($response->successful()) {
            $models = $response->json('models', []);
            return [
                'success' => true,
                'message' => 'Connection successful! Found ' . count($models) . ' available models.',
                'data' => [
                    'models_count' => count($models),
                ],
            ];
        }

        return [
            'success' => false,
            'message' => 'API returned error: ' . ($response->json('error.message') ?? $response->status()),
        ];
    }

    /**
     * Get the default provider or fallback.
     */
    public function getActiveProvider(): ?AiProvider
    {
        $provider = AiProvider::getDefault();

        if (!$provider) {
            $provider = AiProvider::getFallback();
        }

        return $provider;
    }

    /**
     * Make a completion request to a provider.
     */
    public function makeCompletionRequest(
        AiProvider $provider,
        string $model,
        array $messages,
        array $options = []
    ): array {
        $apiKey = $provider->api_key;

        if (!$apiKey) {
            throw new \Exception('API key not configured for provider: ' . $provider->name);
        }

        $payload = [
            'model' => $model,
            'messages' => $messages,
            'max_tokens' => $options['max_tokens'] ?? $provider->max_tokens ?? 1024,
        ];

        if (isset($options['temperature'])) {
            $payload['temperature'] = $options['temperature'];
        }

        // Start timing the request
        $startTime = microtime(true);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->post($provider->base_url . '/chat/completions', $payload);

        // Calculate response time in milliseconds
        $responseTimeMs = (int) ((microtime(true) - $startTime) * 1000);

        if ($response->successful()) {
            $data = $response->json();

            // Extract token usage from response
            $inputTokens = $data['usage']['prompt_tokens'] ?? null;
            $outputTokens = $data['usage']['completion_tokens'] ?? null;

            // Calculate cost (basic estimation - can be refined per model)
            $cost = $this->calculateCost($provider, $model, $inputTokens, $outputTokens);

            // Log successful request
            \App\Models\AiRequestLog::logSuccess(
                $provider->id,
                $model,
                $responseTimeMs,
                $inputTokens,
                $outputTokens,
                $cost,
                '/chat/completions'
            );

            return [
                'success' => true,
                'data' => $data,
            ];
        }

        $errorMessage = $response->json('error.message') ?? 'Unknown error';

        // Log failed request
        \App\Models\AiRequestLog::logError(
            $provider->id,
            $model,
            $responseTimeMs,
            $errorMessage,
            '/chat/completions'
        );

        return [
            'success' => false,
            'error' => $errorMessage,
            'status' => $response->status(),
        ];
    }

    /**
     * Calculate cost based on token usage.
     * Default rates - can be overridden per provider/model.
     */
    protected function calculateCost(AiProvider $provider, string $model, ?int $inputTokens, ?int $outputTokens): float
    {
        if (!$inputTokens && !$outputTokens) {
            return 0;
        }

        // Check if there's a model-specific rate
        $providerModel = $provider->models()->where('model_name', $model)->first();

        if ($providerModel && $providerModel->cost_per_1k_input && $providerModel->cost_per_1k_output) {
            $inputCost = (($inputTokens ?? 0) / 1000) * $providerModel->cost_per_1k_input;
            $outputCost = (($outputTokens ?? 0) / 1000) * $providerModel->cost_per_1k_output;
            return $inputCost + $outputCost;
        }

        // Default rates (approximate for GPT-4 class models)
        $defaultInputRate = 0.01;  // $0.01 per 1K tokens
        $defaultOutputRate = 0.03; // $0.03 per 1K tokens

        $inputCost = (($inputTokens ?? 0) / 1000) * $defaultInputRate;
        $outputCost = (($outputTokens ?? 0) / 1000) * $defaultOutputRate;

        return $inputCost + $outputCost;
    }

    /**
     * Discover available models from a provider and save them to the database.
     *
     * @param AiProvider $provider
     * @return array{success: bool, message: string, models_count: int, saved_count: int}
     */
    public function discoverAndSaveModels(AiProvider $provider): array
    {
        try {
            $apiKey = $provider->api_key;

            if (!$apiKey) {
                return [
                    'success' => false,
                    'message' => 'API key is not configured.',
                    'models_count' => 0,
                    'saved_count' => 0,
                ];
            }

            $models = $this->fetchModelsFromProvider($provider, $apiKey);

            if (empty($models)) {
                return [
                    'success' => true,
                    'message' => 'No models returned from provider.',
                    'models_count' => 0,
                    'saved_count' => 0,
                ];
            }

            $savedCount = $this->saveDiscoveredModels($provider, $models);

            return [
                'success' => true,
                'message' => "Discovered {$savedCount} new models.",
                'models_count' => count($models),
                'saved_count' => $savedCount,
            ];
        } catch (\Exception $e) {
            Log::error('Model discovery failed', [
                'provider' => $provider->slug,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Discovery failed: ' . $e->getMessage(),
                'models_count' => 0,
                'saved_count' => 0,
            ];
        }
    }

    /**
     * Fetch models from a provider's API.
     */
    protected function fetchModelsFromProvider(AiProvider $provider, string $apiKey): array
    {
        // Different providers have different API structures
        if ($provider->slug === 'gemini') {
            return $this->fetchGeminiModels($provider, $apiKey);
        }

        // Standard OpenAI-compatible API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models');

        if ($response->successful()) {
            return $response->json('data', []);
        }

        return [];
    }

    /**
     * Fetch models from Gemini API (different structure).
     */
    protected function fetchGeminiModels(AiProvider $provider, string $apiKey): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->get($provider->base_url . '/models', ['key' => $apiKey]);

        if ($response->successful()) {
            $geminiModels = $response->json('models', []);
            // Transform to standard format
            return array_map(function ($model) {
                return [
                    'id' => str_replace('models/', '', $model['name'] ?? ''),
                    'name' => $model['displayName'] ?? $model['name'] ?? '',
                ];
            }, $geminiModels);
        }

        return [];
    }

    /**
     * Save discovered models to the database.
     */
    protected function saveDiscoveredModels(AiProvider $provider, array $models): int
    {
        $savedCount = 0;

        foreach ($models as $model) {
            $modelId = $model['id'] ?? $model['name'] ?? null;
            $displayName = $model['name'] ?? $model['id'] ?? $modelId;

            if (!$modelId) {
                continue;
            }

            // Check if model already exists
            $exists = $provider->models()->where('model_name', $modelId)->exists();

            if (!$exists) {
                $provider->models()->create([
                    'model_name' => $modelId,
                    'display_name' => is_string($displayName) ? $displayName : $modelId,
                    'is_active' => true,
                ]);
                $savedCount++;
            }
        }

        return $savedCount;
    }

    /**
     * Make a completion request with automatic failover on rate limit.
     *
     * @param AiProvider|null $provider Provider to use (null = use default)
     * @param string $model Model to use
     * @param array $messages Messages to send
     * @param array $options Additional options
     * @param int $maxRetries Maximum number of retries on rate limit
     * @return array
     */
    public function makeCompletionRequestWithFailover(
        ?AiProvider $provider,
        string $model,
        array $messages,
        array $options = [],
        int $maxRetries = 2
    ): array {
        $provider = $provider ?? $this->getActiveProvider();

        if (!$provider) {
            return [
                'success' => false,
                'error' => 'No active AI provider configured.',
            ];
        }

        $attemptedProviders = [];
        $currentProvider = $provider;
        $retries = 0;

        while ($retries <= $maxRetries) {
            $attemptedProviders[] = $currentProvider->id;

            $result = $this->makeCompletionRequest($currentProvider, $model, $messages, $options);

            // Success - return result
            if ($result['success']) {
                return $result;
            }

            // Check if it's a rate limit error (HTTP 429)
            if (isset($result['status']) && $result['status'] === 429) {
                Log::warning('AI Provider rate limit hit, attempting failover', [
                    'provider' => $currentProvider->name,
                    'model' => $model,
                ]);

                // Try to get next available provider
                $nextProvider = $this->getNextAvailableProvider($attemptedProviders);

                if ($nextProvider) {
                    Log::info('Failing over to alternate provider', [
                        'from' => $currentProvider->name,
                        'to' => $nextProvider->name,
                    ]);
                    $currentProvider = $nextProvider;

                    // Try to use equivalent model on new provider, or use default
                    $model = $nextProvider->default_model ?? $model;
                    $retries++;
                    continue;
                }
            }

            // Not a rate limit error, or no more providers - return the error
            return $result;
        }

        return [
            'success' => false,
            'error' => 'All providers exhausted after rate limit errors.',
        ];
    }

    /**
     * Get the next available provider that hasn't been tried yet.
     *
     * @param array $excludeIds Provider IDs to exclude
     * @return AiProvider|null
     */
    public function getNextAvailableProvider(array $excludeIds = []): ?AiProvider
    {
        return AiProvider::active()
            ->whereNotIn('id', $excludeIds)
            ->orderBy('is_default', 'desc') // Prefer default first
            ->first();
    }
}
