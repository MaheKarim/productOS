<?php

namespace App\Services;

use App\Models\RoadmapSession;

class RoadmapPromptBuilder
{
    /**
     * Build system prompt based on user level.
     */
    /**
     * Build system prompt based on user level.
     */
    public function buildSystemPrompt(string $level, array $context): string
    {
        // Check for custom prompt in settings
        $settingKey = 'prompt_id_' . $level;
        $customPromptId = \App\Models\Setting::where('group', 'strategic_roadmap')
            ->where('key', $settingKey)
            ->value('value');

        if ($customPromptId) {
            $customPrompt = \App\Models\SystemPrompt::find($customPromptId);
            if ($customPrompt) {
                // Use custom prompt content
                $levelSpecificPrompt = $customPrompt->content;
            } else {
                // Fallback if ID invalid
                $levelSpecificPrompt = match ($level) {
                    'junior' => $this->getJuniorSystemPrompt($context),
                    'mid' => $this->getMidSystemPrompt($context),
                    'senior' => $this->getSeniorSystemPrompt($context),
                    default => $this->getJuniorSystemPrompt($context),
                };
            }
        } else {
            // Default logic if no setting found
            $levelSpecificPrompt = match ($level) {
                'junior' => $this->getJuniorSystemPrompt($context),
                'mid' => $this->getMidSystemPrompt($context),
                'senior' => $this->getSeniorSystemPrompt($context),
                default => $this->getJuniorSystemPrompt($context),
            };
        }

        // Apply variable replacement for new templates
        $levelSpecificPrompt = $this->replacePlaceholders($levelSpecificPrompt, $level, $context);

        $basePrompt = "You are a Senior Product Strategy Consultant with 15+ years of experience helping product managers create strategic roadmaps. You specialize in " . ($context['product_type'] ?? 'SaaS') . " products.";

        // If template already includes "ROLE: ...", don't prepend basePrompt to avoid duplication if user desires complete control
        if (str_contains($levelSpecificPrompt, 'ROLE:')) {
            $basePrompt = ""; // New template handles the role
        }

        $outputFormat = $this->getOutputFormatInstructions($level);

        return $basePrompt . ($basePrompt ? "\n\n" : "") . $levelSpecificPrompt . "\n\n" . $outputFormat;
    }

    /**
     * Replace placeholders in prompt template.
     */
    protected function replacePlaceholders(string $content, string $level, array $context): string
    {
        $challenges = isset($context['challenges']) && is_array($context['challenges'])
            ? implode(', ', $context['challenges'])
            : ($context['challenges'] ?? 'None specified');

        $replacements = [
            '{product_type}' => $context['product_type'] ?? 'Software',
            '{product_stage}' => $context['product_stage'] ?? 'Growth',
            '{team_size}' => $context['team_size'] ?? 'Unknown',
            '{market}' => 'Target Market', // Default as we don't have explicit input yet
            '{user_experience_level}' => match ($level) {
                'junior' => 'Junior Product Manager (0-2 years)',
                'mid' => 'Mid-Level Product Manager (2-5 years)',
                'senior' => 'Senior Product Manager / CPO (5+ years)',
                default => 'Product Manager'
            },
            '{challenges_list}' => $challenges,
            '{user_goal}' => $context['user_intent'] ?? 'Not specified',
            '{roadmap_type}' => match ($level) {
                'junior' => 'Operational / Action-Oriented',
                'mid' => 'Strategic & Tactical',
                'senior' => 'High-Level Strategic Vision',
                default => 'Strategic'
            },
            '{framework_type}' => match ($level) {
                'junior' => 'AARRR / Basic',
                'mid' => 'HEART / OKR',
                'senior' => 'North Star / Financial',
                default => 'Standard'
            },
            '{timeline}' => match ($level) {
                'junior' => '90-Day',
                'mid' => 'Quarterly (Q1-Q4)',
                'senior' => 'Multi-Year / Annual',
                default => 'Quarterly'
            },
            '{complexity_level}' => match ($level) {
                'junior' => 'Basic (Low Complexity)',
                'mid' => 'Intermediate (Medium Complexity)',
                'senior' => 'Advanced (High Complexity)',
                default => 'Medium'
            },
            '{communication_style}' => match ($level) {
                'junior' => 'Instructive, Encouraging, Educational',
                'mid' => 'Professional, Structured, Collaborative',
                'senior' => 'Executive, Concise, Strategic',
                default => 'Professional'
            },
            '{ui_component}' => 'Interactive Roadmap Visualization',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Build user prompt from session data.
     */
    public function buildUserPrompt(RoadmapSession $session): string
    {
        $context = [
            'Product Type' => $session->product_type_label,
            'Stage' => $session->product_stage ?? 'Not specified',
            'Team Size' => $session->team_size ?? 'Not specified',
            'Funding' => $session->funding_stage ?? 'Not specified',
            'MRR Range' => $session->mrr_range ?? 'Not specified',
            'Challenges' => is_array($session->challenges) ? implode(', ', $session->challenges) : ($session->challenges ?? 'Not specified'),
            'Priorities' => is_array($session->priorities) ? implode(', ', $session->priorities) : ($session->priorities ?? 'Not specified'),
        ];

        $prompt = "Create a strategic roadmap for the following product:\n\n";

        foreach ($context as $key => $value) {
            if ($value && $value !== 'Not specified') {
                $prompt .= "**{$key}:** {$value}\n";
            }
        }

        $additionalContext = $session->input_context ?? [];
        if (!empty($additionalContext)) {
            $prompt .= "\n**Additional Context:**\n";
            foreach ($additionalContext as $key => $value) {
                if ($key === 'user_intent')
                    continue;
                if (is_array($value)) {
                    $prompt .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": " . json_encode($value) . "\n";
                } else {
                    $prompt .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
                }
            }
        }

        if (isset($session->input_context['user_intent'])) {
            $prompt .= "\n**Specific Goal:**\n" . $session->input_context['user_intent'] . "\n";
        }

        $prompt .= "\nGenerate a comprehensive, actionable roadmap based on this context.";

        return $prompt;
    }

    /**
     * Get Junior PM system prompt.
     */
    protected function getJuniorSystemPrompt(array $context): string
    {
        return <<<PROMPT
You are helping a Junior Product Manager who is new to the field. They need:
- Simple, clear, step-by-step guidance
- Educational context for why each step matters
- Basic metrics they should track
- Achievable 90-day action plan

Focus on:
1. Foundational activities (analytics setup, user personas, basic funnels)
2. Simple A/B testing and user interviews
3. Weekly metric reviews
4. Building PM fundamentals

Keep language accessible and avoid jargon. Explain concepts when introducing them.
PROMPT;
    }

    /**
     * Get Mid-level PM system prompt.
     */
    protected function getMidSystemPrompt(array $context): string
    {
        return <<<PROMPT
You are helping a Mid-Level Product Manager with 2-5 years of experience. They need:
- Balanced strategic and tactical guidance
- OKR-based quarterly planning
- Trade-off analysis and prioritization frameworks
- Stakeholder management strategies

Focus on:
1. Quarterly objectives with measurable key results
2. Feature prioritization (RICE, WSJF frameworks)
3. Cross-functional alignment
4. Growth initiatives with clear success metrics

Use industry-standard PM terminology. Balance strategy with execution details.
PROMPT;
    }

    /**
     * Get Senior PM / Founder system prompt.
     */
    protected function getSeniorSystemPrompt(array $context): string
    {
        $teamSize = $context['team_size'] ?? 'unknown';
        $funding = $context['funding_stage'] ?? 'unknown';

        return <<<PROMPT
You are advising a Senior Product Manager or Founder with significant experience. They need:
- High-level strategic vision with 1-3 year outlook
- Organizational design and team scaling guidance
- Financial projections and investment planning
- Market positioning and competitive strategy

Context: Team size is {$teamSize}, funding stage is {$funding}.

Focus on:
1. Annual strategic framework with quarterly milestones
2. Metrics portfolio (North Star, Growth, Health, Efficiency)
3. Organizational structure evolution
4. Resource allocation and hiring plans
5. Board-level communication frameworks

Use executive-level language. Focus on strategic impact and market dynamics.
PROMPT;
    }

    /**
     * Get output format instructions.
     */
    protected function getOutputFormatInstructions(string $level): string
    {
        $common = "IMPORTANT: Return your response as valid JSON that can be parsed. Do not include any text before or after the JSON.";

        return match ($level) {
            'junior' => $common . "\n\n" . $this->getJuniorOutputFormat(),
            'mid' => $common . "\n\n" . $this->getMidOutputFormat(),
            'senior' => $common . "\n\n" . $this->getSeniorOutputFormat(),
            default => $common . "\n\n" . $this->getJuniorOutputFormat(),
        };
    }

    /**
     * Get Junior output format.
     */
    protected function getJuniorOutputFormat(): string
    {
        return <<<'FORMAT'
Return a JSON object with this structure:
{
    "title": "Your 90-Day Action Plan",
    "phases": [
        {
            "id": "month-1",
            "title": "MONTH 1: Foundation",
            "checkpoints": [
                {"text": "Set up basic analytics (Google Analytics)", "completed": false},
                {"text": "Define 3 key user personas", "completed": false},
                {"text": "Create basic AARRR funnel", "completed": false}
            ],
            "metrics": ["DAU", "Activation Rate", "Support Tickets"]
        },
        {
            "id": "month-2",
            "title": "MONTH 2: Optimization",
            "checkpoints": [
                {"text": "Run 2 A/B tests on onboarding", "completed": false},
                {"text": "Interview 5 users for feedback", "completed": false},
                {"text": "Set up weekly metrics review", "completed": false}
            ],
            "metrics": ["Retention (D7, D30)", "NPS", "Feature Usage"]
        }
    ],
    "metric_matrix": {
        "primary_framework": "AARRR",
        "alternative_framework": "HEART",
        "acquisition": ["CAC", "Sign-ups", "Traffic Sources"],
        "activation": ["Time-to-Value", "Setup Success", "Core Action Completion"],
        "retention": ["D30 Retention", "MAU/DAU Ratio", "NPS/CSAT"],
        "revenue": ["MRR/ARR", "LTV", "Gross Margin"],
        "referral": ["Viral Coefficient", "Invites Sent", "Share Rate"],
        "operational": ["Team Velocity", "Bug Rate", "Release Frequency"]
    }
    "benchmarks": {
        "monthly_churn": {"good": "< 5%", "average": "5-10%", "poor": "> 10%"},
        "nps": {"good": "> 50", "average": "30-50", "poor": "< 30"},
        "activation_rate": {"good": "> 40%", "average": "20-40%", "poor": "< 20%"}
    },
    "best_practices": [
        "Focus on 1-2 key metrics per week",
        "Talk to at least 5 users before shipping"
    ]
}
FORMAT;
    }

    /**
     * Get Mid-level output format.
     */
    protected function getMidOutputFormat(): string
    {
        return <<<'FORMAT'
Return a JSON object with this structure:
{
    "title": "Quarterly Strategic Roadmap",
    "phases": [
        {
            "id": "q1",
            "title": "Q1: GROWTH INITIATION",
            "objectives": ["Increase activation by 25%"],
            "metrics": {
                "nsm": "Weekly Learning Users",
                "input": ["Onboarding Completion", "Feature Adoption"]
            },
            "initiatives": [
                {
                    "title": "Redesign onboarding flow",
                    "impact": "High",
                    "effort": "Medium"
                },
                {
                    "title": "Implement product tours",
                    "impact": "Medium",
                    "effort": "Low"
                }
            ],
            "stakeholders": {"Eng": 5, "Design": 2, "Marketing": 1},
            "risks": ["Technical debt may delay release"]
        }
    ],
    "metric_matrix": {
        "primary_framework": "OKR",
        "alternative_framework": "RICE",
        "acquisition": ["CAC", "Sign-ups", "Traffic Sources"],
        "activation": ["Time-to-Value", "Setup Success", "Core Action Completion"],
        "retention": ["D30 Retention", "MAU/DAU Ratio", "NPS/CSAT"],
        "revenue": ["MRR/ARR", "LTV", "Gross Margin"],
        "referral": ["Viral Coefficient", "Invites Sent", "Share Rate"],
        "operational": ["Team Velocity", "Bug Rate", "Release Frequency"]
    }
    "benchmarks": {
        "monthly_churn": {"good": "< 5%", "average": "5-10%", "poor": "> 10%"},
        "nps": {"good": "> 50", "average": "30-50", "poor": "< 30"},
        "activation_rate": {"good": "> 40%", "average": "20-40%", "poor": "< 20%"}
    },
    "best_practices": [
        "Use RICE score to defend roadmap",
        "Ensure initiatives link to OKRs"
    ]
}
FORMAT;
    }

    /**
     * Get Senior output format.
     */
    protected function getSeniorOutputFormat(): string
    {
        return <<<'FORMAT'
Return a JSON object with this structure:
{
    "title": "Annual Strategic Framework",
    "vision": "Become #1 {solution} in {market} by {year}",
    "metrics_portfolio": {
        "north_star": "Market Share (%)",
        "growth": ["YoY Revenue Growth", "Customer Count"],
        "health": ["NPS", "Employee Satisfaction", "Churn Rate"],
        "efficiency": ["CAC", "LTV", "R&D ROI"]
    },
    "phases": [
        {
            "id": "h1",
            "title": "Q1-Q2: Market Leadership",
            "goal": "Acquire > 30% market share"
        },
        {
            "id": "h2",
            "title": "Q3-Q4: Platform Expansion",
            "goal": "Launch 3 new verticals"
        }
    ],
    "org_design": [
        "Team structure evolution (current → target)",
        "Hiring plan by quarter",
        "Leadership development roadmap"
    ],
    "financial_projections": [
        "Revenue forecast by product line",
        "Investment requirements timeline",
        "Profitability milestones"
    ],
    "metric_matrix": {
        "primary_framework": "North Star",
        "alternative_framework": "Balanced Scorecard",
        "acquisition": ["CAC", "Sign-ups", "Traffic Sources"],
        "activation": ["Time-to-Value", "Setup Success", "Core Action Completion"],
        "retention": ["D30 Retention", "MAU/DAU Ratio", "NPS/CSAT"],
        "revenue": ["MRR/ARR", "LTV", "Gross Margin"],
        "referral": ["Viral Coefficient", "Invites Sent", "Share Rate"],
        "operational": ["Team Velocity", "Bug Rate", "Release Frequency"]
    }
    "benchmarks": {
        "monthly_churn": {"good": "< 5%", "average": "5-10%", "poor": "> 10%"},
        "nps": {"good": "> 50", "average": "30-50", "poor": "< 30"},
        "activation_rate": {"good": "> 40%", "average": "20-40%", "poor": "< 20%"}
    },
    "best_practices": [
        "Delegate execution details",
        "Align roadmap with financial goals"
    ]
}
FORMAT;
    }

    /**
     * Get AI options based on user level.
     */
    public function getAiOptionsForLevel(string $level): array
    {
        return match ($level) {
            'junior' => [
                'temperature' => 0.3,
                'max_tokens' => 2000,
            ],
            'mid' => [
                'temperature' => 0.5,
                'max_tokens' => 3000,
            ],
            'senior' => [
                'temperature' => 0.7,
                'max_tokens' => 4000,
            ],
            default => [
                'temperature' => 0.3,
                'max_tokens' => 2000,
            ],
        };
    }

    /**
     * Get metric framework based on level and product type.
     */
    public function getFrameworkForLevel(string $level, ?string $productType): array
    {
        $frameworks = [
            'aarrr' => [
                'type' => 'AARRR',
                'name' => 'Pirate Metrics',
                'categories' => [
                    'acquisition' => ['CAC', 'Sign-ups', 'Traffic Sources'],
                    'activation' => ['Time-to-Value', 'Setup Success', 'Core Action Completion'],
                    'retention' => ['D30 Retention', 'MAU/DAU Ratio', 'NPS', 'Churn Rate'],
                    'revenue' => ['MRR/ARR', 'LTV', 'Gross Margin'],
                    'referral' => ['Viral Coefficient', 'NPS > 9 Promoters', 'Invites Sent'],
                ],
            ],
            'heart' => [
                'type' => 'HEART',
                'name' => 'Google HEART Framework',
                'categories' => [
                    'happiness' => ['NPS', 'CSAT', 'User Satisfaction'],
                    'engagement' => ['DAU/MAU', 'Session Duration', 'Actions per Session'],
                    'adoption' => ['New User Growth', 'Feature Adoption', 'Upgrade Rate'],
                    'retention' => ['D1/D7/D30 Retention', 'Churn Rate'],
                    'task_success' => ['Task Completion Rate', 'Error Rate', 'Time on Task'],
                ],
            ],
            'north_star' => [
                'type' => 'North Star',
                'name' => 'North Star Framework',
                'categories' => [
                    'north_star' => ['Primary value metric'],
                    'input_metrics' => ['Feature usage', 'Engagement depth', 'Breadth'],
                    'output_metrics' => ['Revenue', 'Retention', 'Referrals'],
                ],
            ],
        ];

        // Select framework based on level and product type
        $selectedFramework = match ($level) {
            'junior' => 'aarrr', // Simple, well-known
            'mid' => 'aarrr',   // Industry standard
            'senior' => 'north_star', // Strategic focus
            default => 'aarrr',
        };

        // Override for mobile apps
        if ($productType === 'mobile_app') {
            $selectedFramework = 'heart';
        }

        return $frameworks[$selectedFramework];
    }

    /**
     * Get empty/default benchmarks structure for fallback.
     */
    public function getDefaultBenchmarks(): array
    {
        return [
            'monthly_churn' => ['good' => '< 5%', 'average' => '5-10%', 'poor' => '> 10%'],
            'nps' => ['good' => '> 50', 'average' => '30-50', 'poor' => '< 30%'],
            'activation_rate' => ['good' => '> 40%', 'average' => '20-40%', 'poor' => '< 20%']
        ];
    }
}
