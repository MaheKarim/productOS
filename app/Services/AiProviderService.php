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

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($provider->timeout ?? 30)
            ->post($provider->base_url . '/chat/completions', $payload);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        }

        return [
            'success' => false,
            'error' => $response->json('error.message') ?? 'Unknown error',
            'status' => $response->status(),
        ];
    }
}
