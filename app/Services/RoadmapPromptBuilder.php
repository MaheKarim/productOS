<?php

namespace App\Services;

use App\Models\RoadmapSession;

class RoadmapPromptBuilder
{
    /**
     * Build system prompt based on user level.
     */
    public function buildSystemPrompt(string $level, array $context): string
    {
        $basePrompt = "You are a Senior Product Strategy Consultant with 15+ years of experience helping product managers create strategic roadmaps. You specialize in " . ($context['product_type'] ?? 'SaaS') . " products.";

        $levelSpecificPrompt = match ($level) {
            'junior' => $this->getJuniorSystemPrompt($context),
            'mid' => $this->getMidSystemPrompt($context),
            'senior' => $this->getSeniorSystemPrompt($context),
            default => $this->getJuniorSystemPrompt($context),
        };

        $outputFormat = $this->getOutputFormatInstructions($level);

        return $basePrompt . "\n\n" . $levelSpecificPrompt . "\n\n" . $outputFormat;
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
                if (is_array($value)) {
                    $prompt .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": " . json_encode($value) . "\n";
                } else {
                    $prompt .= "- " . ucfirst(str_replace('_', ' ', $key)) . ": {$value}\n";
                }
            }
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
        return <<<FORMAT
Return a JSON object with this structure:
{
    "title": "Your 90-Day Action Plan",
    "summary": "Brief overview of what this plan will help achieve",
    "phases": [
        {
            "id": "month-1",
            "title": "Month 1: Foundation",
            "description": "What this phase focuses on",
            "checkpoints": [
                {"id": "1-1", "text": "Set up basic analytics (Google Analytics)", "category": "analytics"},
                {"id": "1-2", "text": "Define 3 key user personas", "category": "research"}
            ],
            "metrics": ["DAU", "Activation Rate", "Support Tickets"]
        }
    ],
    "key_metrics": {
        "primary": ["Daily Active Users", "Activation Rate"],
        "secondary": ["Support Tickets", "Feature Usage"]
    },
    "next_steps": ["First action to take", "Second action"]
}
FORMAT;
    }

    /**
     * Get Mid-level output format.
     */
    protected function getMidOutputFormat(): string
    {
        return <<<FORMAT
Return a JSON object with this structure:
{
    "title": "Quarterly Strategic Roadmap",
    "vision": "90-day vision statement",
    "phases": [
        {
            "id": "q1",
            "title": "Q1: Growth Initiation",
            "objective": "Primary objective for this quarter",
            "key_results": [
                {"id": "kr-1", "text": "Increase activation by 25%", "baseline": "20%", "target": "25%"},
                {"id": "kr-2", "text": "Reduce churn to 5%", "baseline": "8%", "target": "5%"}
            ],
            "initiatives": [
                {
                    "id": "init-1",
                    "title": "Redesign onboarding flow",
                    "impact": "high",
                    "effort": "medium",
                    "owner": "Product + Design"
                }
            ],
            "risks": ["Technical debt may delay release"],
            "dependencies": ["Engineering capacity"]
        }
    ],
    "nsm": {
        "metric": "Weekly Active Learners",
        "rationale": "Why this is the North Star"
    },
    "stakeholder_map": {
        "engineering": {"involvement": "high", "concerns": ["Technical feasibility"]},
        "marketing": {"involvement": "medium", "concerns": ["Launch timing"]}
    }
}
FORMAT;
    }

    /**
     * Get Senior output format.
     */
    protected function getSeniorOutputFormat(): string
    {
        return <<<FORMAT
Return a JSON object with this structure:
{
    "title": "Annual Strategic Framework",
    "vision": "3-year vision statement",
    "annual_theme": "Theme for the year",
    "phases": [
        {
            "id": "h1",
            "title": "H1: Market Leadership",
            "strategic_goal": "Acquire 30% market share",
            "quarters": [
                {
                    "id": "q1",
                    "focus": "Customer acquisition",
                    "key_initiatives": ["Launch enterprise tier", "Expand to EU market"]
                }
            ]
        }
    ],
    "metrics_portfolio": {
        "north_star": {"metric": "Market Share", "current": "15%", "target": "30%"},
        "growth": ["YoY Revenue Growth", "Customer Count", "NRR"],
        "health": ["NPS", "Employee Satisfaction", "Churn Rate"],
        "efficiency": ["CAC", "LTV", "LTV:CAC Ratio"]
    },
    "org_evolution": {
        "current_structure": "Description of current org",
        "target_structure": "Where org needs to be",
        "key_hires": ["VP Engineering", "Head of Growth"]
    },
    "financial_outlook": {
        "revenue_target": "$X ARR",
        "investment_areas": ["Product", "GTM", "Infrastructure"],
        "profitability_milestone": "Q4 breakeven"
    },
    "risks_and_mitigations": [
        {"risk": "Market downturn", "mitigation": "Diversify customer base", "likelihood": "medium"}
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
}
