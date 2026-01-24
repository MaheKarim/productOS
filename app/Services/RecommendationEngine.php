<?php

namespace App\Services;

use App\Models\CareerAssessment;

class RecommendationEngine
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('career-compass');
    }

    /**
     * Generate prioritized recommendations for an assessment
     */
    public function generate(CareerAssessment $assessment): array
    {
        $recommendations = [];

        // Priority 1: Critical issues (< 0.75)
        $recommendations = array_merge(
            $recommendations,
            $this->getCriticalActions($assessment)
        );

        // Priority 2: Below average (0.75 - 1.0)
        $recommendations = array_merge(
            $recommendations,
            $this->getBelowAverageActions($assessment)
        );

        // Priority 3: Improvement opportunities (1.0 - 1.5)
        $recommendations = array_merge(
            $recommendations,
            $this->getImprovementActions($assessment)
        );

        // Sort by priority and return top 3-5
        usort($recommendations, fn($a, $b) => $a['priority'] <=> $b['priority']);

        return array_slice($recommendations, 0, 5);
    }

    /**
     * Get critical actions for scores < 0.75
     */
    protected function getCriticalActions(CareerAssessment $assessment): array
    {
        $actions = [];
        $allScores = $this->getAllScoresWithLabels($assessment);

        foreach ($allScores as $key => $data) {
            if ($data['score'] < 0.75) {
                $recommendation = $this->getRecommendation($key, 'critical');
                if ($recommendation) {
                    $actions[] = [
                        'priority' => 1,
                        'severity' => 'critical',
                        'variable' => $key,
                        'label' => $data['label'],
                        'score' => $data['score'],
                        'title' => $recommendation['title'] ?? "Address {$data['label']}",
                        'actions' => $recommendation['actions'] ?? [],
                        'timeline' => $recommendation['timeline'] ?? '1-2 months',
                        'resources' => $recommendation['resources'] ?? [],
                    ];
                }
            }
        }

        return $actions;
    }

    /**
     * Get actions for scores 0.75 - 1.0
     */
    protected function getBelowAverageActions(CareerAssessment $assessment): array
    {
        $actions = [];
        $allScores = $this->getAllScoresWithLabels($assessment);

        foreach ($allScores as $key => $data) {
            if ($data['score'] >= 0.75 && $data['score'] < 1.0) {
                $recommendation = $this->getRecommendation($key, 'critical')
                    ?? $this->getRecommendation($key, 'improvement');
                if ($recommendation) {
                    $actions[] = [
                        'priority' => 2,
                        'severity' => 'warning',
                        'variable' => $key,
                        'label' => $data['label'],
                        'score' => $data['score'],
                        'title' => $recommendation['title'] ?? "Improve {$data['label']}",
                        'actions' => $recommendation['actions'] ?? [],
                        'timeline' => $recommendation['timeline'] ?? '2-3 months',
                        'resources' => $recommendation['resources'] ?? [],
                    ];
                }
            }
        }

        return $actions;
    }

    /**
     * Get improvement actions for scores 1.0 - 1.5
     */
    protected function getImprovementActions(CareerAssessment $assessment): array
    {
        $actions = [];
        $allScores = $this->getAllScoresWithLabels($assessment);

        foreach ($allScores as $key => $data) {
            if ($data['score'] >= 1.0 && $data['score'] < 1.5) {
                $recommendation = $this->getRecommendation($key, 'improvement');
                if ($recommendation) {
                    $actions[] = [
                        'priority' => 3,
                        'severity' => 'info',
                        'variable' => $key,
                        'label' => $data['label'],
                        'score' => $data['score'],
                        'title' => $recommendation['title'] ?? "Optimize {$data['label']}",
                        'actions' => $recommendation['actions'] ?? [],
                        'timeline' => $recommendation['timeline'] ?? '3-6 months',
                        'resources' => $recommendation['resources'] ?? [],
                    ];
                }
            }
        }

        return $actions;
    }

    /**
     * Get strengths (scores >= 1.75)
     */
    public function getStrengths(CareerAssessment $assessment): array
    {
        $strengths = [];
        $allScores = $this->getAllScoresWithLabels($assessment);

        foreach ($allScores as $key => $data) {
            if ($data['score'] >= 1.75) {
                $strengths[] = [
                    'variable' => $key,
                    'label' => $data['label'],
                    'score' => $data['score'],
                    'level' => 'excellent',
                ];
            } elseif ($data['score'] >= 1.5) {
                $strengths[] = [
                    'variable' => $key,
                    'label' => $data['label'],
                    'score' => $data['score'],
                    'level' => 'good',
                ];
            }
        }

        // Sort by score descending
        usort($strengths, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($strengths, 0, 3);
    }

    /**
     * Get all scores with labels
     */
    protected function getAllScoresWithLabels(CareerAssessment $assessment): array
    {
        $envConfig = $this->config['environment_variables'] ?? [];
        $skillsConfig = $this->config['skills_variables'] ?? [];

        return [
            'manager' => [
                'score' => (float) $assessment->manager_score,
                'label' => $envConfig['manager']['label'] ?? 'Manager',
                'type' => 'environment',
            ],
            'resources' => [
                'score' => (float) $assessment->resources_score,
                'label' => $envConfig['resources']['label'] ?? 'Resources',
                'type' => 'environment',
            ],
            'team' => [
                'score' => (float) $assessment->team_score,
                'label' => $envConfig['team']['label'] ?? 'Team',
                'type' => 'environment',
            ],
            'scope' => [
                'score' => (float) $assessment->scope_score,
                'label' => $envConfig['scope']['label'] ?? 'Scope',
                'type' => 'environment',
            ],
            'compensation' => [
                'score' => (float) $assessment->compensation_score,
                'label' => $envConfig['compensation']['label'] ?? 'Compensation',
                'type' => 'environment',
            ],
            'culture' => [
                'score' => (float) $assessment->culture_score,
                'label' => $envConfig['culture']['label'] ?? 'Culture',
                'type' => 'environment',
            ],
            'communication' => [
                'score' => (float) $assessment->communication_score,
                'label' => $skillsConfig['communication']['label'] ?? 'Communication',
                'type' => 'skills',
            ],
            'leadership' => [
                'score' => (float) $assessment->leadership_score,
                'label' => $skillsConfig['leadership']['label'] ?? 'Leadership',
                'type' => 'skills',
            ],
            'strategy' => [
                'score' => (float) $assessment->strategy_score,
                'label' => $skillsConfig['strategy']['label'] ?? 'Strategy',
                'type' => 'skills',
            ],
            'execution' => [
                'score' => (float) $assessment->execution_score,
                'label' => $skillsConfig['execution']['label'] ?? 'Execution',
                'type' => 'skills',
            ],
        ];
    }

    /**
     * Get recommendation config for a variable and type
     */
    protected function getRecommendation(string $variable, string $type): ?array
    {
        return $this->config['recommendations'][$variable][$type] ?? null;
    }
}
