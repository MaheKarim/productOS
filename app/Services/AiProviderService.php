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
}
