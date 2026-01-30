<?php

namespace App\Services;

use App\Models\RoadmapSession;
use App\Models\RoadmapOutput;
use App\Models\User;
use App\Models\AdminRoadmapInsight;
use Illuminate\Support\Str;

class StrategicRoadmapService
{
    protected AiProviderService $aiService;
    protected RoadmapPromptBuilder $promptBuilder;

    public function __construct(AiProviderService $aiService, RoadmapPromptBuilder $promptBuilder)
    {
        $this->aiService = $aiService;
        $this->promptBuilder = $promptBuilder;
    }

    /**
     * Start a new roadmap session.
     */
    public function startSession(?User $user, string $level): RoadmapSession
    {
        return RoadmapSession::create([
            'user_id' => $user?->id,
            'session_uuid' => Str::uuid()->toString(),
            'user_level' => $level,
            'complexity_level' => RoadmapSession::getComplexityForLevel($level),
            'status' => 'draft',
        ]);
    }

    /**
     * Save quick input (Junior PM path).
     */
    public function saveQuickInput(RoadmapSession $session, array $data): void
    {
        $session->update([
            'product_type' => $data['product_type'] ?? null,
            'product_stage' => $data['time_working'] ?? null,
            'challenges' => $data['challenges'] ?? [],
            'input_context' => array_merge(
                $session->input_context ?? [],
                [
                    'quick_input' => $data,
                    'user_intent' => $data['user_intent'] ?? null
                ]
            ),
        ]);
    }

    /**
     * Save advanced input (Senior PM path).
     */
    public function saveAdvancedInput(RoadmapSession $session, array $data): void
    {
        $session->update([
            'product_type' => $data['product_type'] ?? null,
            'product_stage' => $data['product_stage'] ?? null,
            'team_size' => $data['team_size'] ?? null,
            'funding_stage' => $data['funding_stage'] ?? null,
            'mrr_range' => $data['mrr_range'] ?? null,
            'challenges' => $data['challenges'] ?? [],
            'priorities' => $data['priorities'] ?? [],
            'current_metrics' => $data['current_metrics'] ?? [],
            'input_context' => array_merge(
                $session->input_context ?? [],
                [
                    'advanced_input' => $data,
                    'user_intent' => $data['user_intent'] ?? null
                ]
            ),
        ]);
    }

    /**
     * Generate roadmap using AI.
     */
    public function generateRoadmap(RoadmapSession $session): RoadmapOutput
    {
        $session->update(['status' => 'generating']);
        $startTime = microtime(true);

        try {
            // Check for provider override in settings
            $providerId = \App\Models\Setting::where('group', 'strategic_roadmap')
                ->where('key', 'provider_id')
                ->value('value');

            $provider = null;
            if ($providerId) {
                $provider = \App\Models\AiProvider::find($providerId);
            }

            if (!$provider) {
                $provider = $this->aiService->getActiveProvider();
            }

            if (!$provider) {
                throw new \Exception('No active AI provider configured.');
            }

            // Build prompts based on user level
            $systemPrompt = $this->promptBuilder->buildSystemPrompt($session->user_level, [
                'product_type' => $session->product_type,
                'product_stage' => $session->product_stage,
                'team_size' => $session->team_size,
                'funding_stage' => $session->funding_stage,
                'challenges' => $session->challenges,
                'priorities' => $session->priorities,
            ]);

            $userPrompt = $this->promptBuilder->buildUserPrompt($session);

            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ];

            // Get AI options based on user level
            $options = $this->promptBuilder->getAiOptionsForLevel($session->user_level);

            $result = $this->aiService->makeCompletionRequestWithFailover(
                $provider,
                $provider->default_model ?? 'llama-3.3-70b-versatile',
                $messages,
                $options
            );

            if (!$result['success']) {
                throw new \Exception($result['error'] ?? 'AI generation failed');
            }

            $content = $result['data']['choices'][0]['message']['content'] ?? '';
            $parsedOutput = $this->parseAiResponse($content, $session->user_level);

            $generationTimeMs = (int) ((microtime(true) - $startTime) * 1000);
            $tokenCount = ($result['data']['usage']['total_tokens'] ?? 0);

            // Create output record
            $output = RoadmapOutput::create([
                'session_id' => $session->id,
                'simplified_version' => $session->user_level === 'junior' ? $parsedOutput : null,
                'detailed_version' => $session->user_level === 'mid' ? $parsedOutput : null,
                'strategic_version' => $session->user_level === 'senior' ? $parsedOutput : null,
                'metric_framework' => $parsedOutput['metric_matrix'] ?? $this->promptBuilder->getFrameworkForLevel($session->user_level, $session->product_type),
                'benchmarks' => isset($parsedOutput['benchmarks']) ? ['industry' => $parsedOutput['benchmarks'], 'source' => 'AI Generated'] : $this->getBenchmarksForContext($session),
                'generation_time_ms' => $generationTimeMs,
                'token_count' => $tokenCount,
            ]);

            $session->update([
                'status' => 'completed',
                'ai_model_used' => $provider->default_model ?? 'unknown',
            ]);

            // Record analytics
            AdminRoadmapInsight::recordSuccess('roadmap_generated', 1, $session->user_level);

            return $output;

        } catch (\Exception $e) {
            $session->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            AdminRoadmapInsight::recordFailure('roadmap_generation_failed', 1, $session->user_level);

            throw $e;
        }
    }

    /**
     * Parse AI response into structured format.
     */
    protected function parseAiResponse(string $content, string $level): array
    {
        // Try to extract JSON from the response
        if (preg_match('/```json\s*([\s\S]*?)\s*```/', $content, $matches)) {
            $jsonContent = $matches[1];
        } elseif (preg_match('/\{[\s\S]*\}/', $content, $matches)) {
            $jsonContent = $matches[0];
        } else {
            // If no JSON found, create a structured response from the text
            return $this->createStructuredFromText($content, $level);
        }

        $parsed = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->createStructuredFromText($content, $level);
        }

        return $parsed;
    }

    /**
     * Create structured output from plain text response.
     */
    protected function createStructuredFromText(string $content, string $level): array
    {
        $lines = explode("\n", $content);
        $phases = [];
        $currentPhase = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line))
                continue;

            // Detect phase headers
            if (preg_match('/^(#{1,3}|Month|Phase|Quarter|Q\d)/i', $line)) {
                if ($currentPhase) {
                    $phases[] = $currentPhase;
                }
                $currentPhase = [
                    'id' => Str::uuid()->toString(),
                    'title' => preg_replace('/^[#\s]+/', '', $line),
                    'checkpoints' => [],
                    'metrics' => [],
                ];
            } elseif ($currentPhase && preg_match('/^[-*✓•]\s*(.+)/', $line, $matches)) {
                $currentPhase['checkpoints'][] = [
                    'id' => Str::uuid()->toString(),
                    'text' => $matches[1],
                    'completed' => false,
                ];
            }
        }

        if ($currentPhase) {
            $phases[] = $currentPhase;
        }

        // If no phases detected, create a single phase with the content
        if (empty($phases)) {
            $phases[] = [
                'id' => Str::uuid()->toString(),
                'title' => match ($level) {
                    'junior' => '90-Day Action Plan',
                    'mid' => 'Quarterly Roadmap',
                    'senior' => 'Strategic Framework',
                    default => 'Roadmap',
                },
                'content' => $content,
                'checkpoints' => [],
            ];
        }

        return [
            'title' => match ($level) {
                'junior' => 'Your 90-Day Action Plan',
                'mid' => 'Quarterly Strategic Roadmap',
                'senior' => 'Annual Strategic Framework',
                default => 'Strategic Roadmap',
            },
            'phases' => $phases,
            'generated_at' => now()->toISOString(),
        ];
    }

    /**
     * Get benchmarks based on session context.
     */
    protected function getBenchmarksForContext(RoadmapSession $session): array
    {
        $benchmarks = [];

        // Industry benchmarks based on product type
        $productBenchmarks = [
            'saas' => [
                'monthly_churn' => ['good' => '< 5%', 'average' => '5-10%', 'poor' => '> 10%'],
                'nps' => ['good' => '> 50', 'average' => '30-50', 'poor' => '< 30'],
                'activation_rate' => ['good' => '> 40%', 'average' => '20-40%', 'poor' => '< 20%'],
            ],
            'marketplace' => [
                'take_rate' => ['good' => '> 15%', 'average' => '10-15%', 'poor' => '< 10%'],
                'gmv_growth' => ['good' => '> 100% YoY', 'average' => '50-100% YoY', 'poor' => '< 50% YoY'],
                'liquidity' => ['good' => '> 70%', 'average' => '50-70%', 'poor' => '< 50%'],
            ],
            'ecommerce' => [
                'conversion_rate' => ['good' => '> 3%', 'average' => '1-3%', 'poor' => '< 1%'],
                'cart_abandonment' => ['good' => '< 60%', 'average' => '60-75%', 'poor' => '> 75%'],
                'repeat_purchase' => ['good' => '> 30%', 'average' => '15-30%', 'poor' => '< 15%'],
            ],
            'mobile_app' => [
                'd1_retention' => ['good' => '> 40%', 'average' => '25-40%', 'poor' => '< 25%'],
                'd30_retention' => ['good' => '> 15%', 'average' => '8-15%', 'poor' => '< 8%'],
                'session_length' => ['good' => '> 5min', 'average' => '2-5min', 'poor' => '< 2min'],
            ],
        ];

        $benchmarks['industry'] = $productBenchmarks[$session->product_type] ?? $productBenchmarks['saas'];
        $benchmarks['source'] = 'Industry averages (2024)';

        return $benchmarks;
    }

    /**
     * Get session by UUID.
     */
    public function getSessionByUuid(string $uuid): ?RoadmapSession
    {
        return RoadmapSession::where('session_uuid', $uuid)->first();
    }

    /**
     * Get user's roadmap history.
     */
    public function getUserHistory(User $user, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return RoadmapSession::forUser($user->id)
            ->completed()
            ->with('output')
            ->recent($limit)
            ->get();
    }
}
