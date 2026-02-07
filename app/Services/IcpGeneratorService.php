<?php

namespace App\Services;

use App\Models\Icp;
use Illuminate\Support\Facades\Log;

class IcpGeneratorService
{
    protected AiProviderService $aiService;

    public function __construct(AiProviderService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate an ICP (Ideal Customer Profile) based on user input.
     */
    public function generate(array $inputData): array
    {
        $provider = $this->aiService->getActiveProvider();

        if (!$provider) {
            throw new \Exception('No AI provider available.');
        }

        // Increase timeout for complex generation
        set_time_limit(120);

        try {
            $prompt = $this->buildPrompt($inputData);

            $response = $this->aiService->makeCompletionRequestWithFailover(
                $provider,
                $provider->default_model,
                [['role' => 'user', 'content' => $prompt]],
                ['max_tokens' => 4096, 'temperature' => 0.7]
            );

            if (!$response['success']) {
                throw new \Exception('AI Request Failed: ' . ($response['error'] ?? 'Unknown error'));
            }

            $content = $response['data']['choices'][0]['message']['content'];
            return $this->parseResponse($content);

        } catch (\Exception $e) {
            Log::error('ICP Generation Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Build the AI prompt using the Master Prompt structure.
     */
    protected function buildPrompt(array $input): string
    {
        // Extract inputs with fallbacks
        $description = $input['product_description'] ?? 'Not provided';
        $type = $input['product_type'] ?? 'Unknown';
        $market = $input['target_market'] ?? 'Unknown';
        $stage = $input['company_stage'] ?? 'Unknown';
        $pricing = $input['pricing_model'] ?? 'Unknown';
        $dealSize = $input['deal_size'] ?? 'Unknown';
        $goal = $input['primary_goal'] ?? 'Unknown';

        return <<<PROMPT
You are a senior B2B Product Marketing Strategist and Go-To-Market expert.
You specialize in building Ideal Customer Profiles (ICP) for SaaS, AI tools,
Agencies, Marketplaces, and Tech-enabled businesses.

Your task is to generate a clear, actionable, and sales-ready ICP based on the input below.
Avoid generic advice. Be specific, realistic, and practical.

INPUT DATA:
- Product Description: {$description}
- Product Type: {$type}
- Target Market: {$market}
- Company Stage: {$stage}
- Pricing Model: {$pricing}
- Average Deal Size: {$dealSize}
- Primary Goal: {$goal}

INSTRUCTIONS:
- Think like a revenue-focused PM and GTM strategist
- Optimize for high LTV, low churn, and fast sales cycles
- Clearly separate facts vs assumptions
- Do NOT use buzzwords
- Output must be structured and actionable

OUTPUT FORMAT:
Return ONLY valid JSON (no markdown, no code blocks) with this exact schema:

{
  "icp_summary": {
    "one_liner": "A concise summary of the ideal customer",
    "confidence_score": 85
  },
  "firmographics": {
    "industry": ["Industry 1", "Industry 2"],
    "company_size": "e.g., 50-200 employees",
    "revenue_range": "e.g., $10M-$50M ARR",
    "geography": ["Region 1", "Region 2"]
  },
  "buyer_personas": [
    {
      "role": "e.g., Economic Buyer",
      "job_titles": ["Title 1", "Title 2"],
      "seniority": "e.g., VP/C-Level",
      "decision_power": "High/Medium/Low"
    }
  ],
  "pain_points": ["Pain point 1", "Pain point 2"],
  "jobs_to_be_done": ["Job 1", "Job 2"],
  "buying_triggers": ["Trigger 1", "Trigger 2"],
  "budget_expectation": "e.g., $10k-$50k / year",
  "sales_cycle_estimate": "e.g., 3-6 months",
  "key_objections": ["Objection 1", "Objection 2"],
  "negative_icp": {
    "avoid_industries": [],
    "avoid_company_types": [],
    "why_to_avoid": []
  },
  "fit_scoring_logic": {
    "good_fit_criteria": [],
    "bad_fit_criteria": []
  },
  "gtm_recommendation": {
    "best_channels": [],
    "sales_motion": "",
    "messaging_angle": ""
  },
  "assumptions": ["Assumption 1", "Assumption 2"]
}
PROMPT;
    }

    /**
     * Parse AI response into array.
     */
    protected function parseResponse(string $content): array
    {
        // Clean markdown if present
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $content, $matches)) {
            $json = $matches[1];
        } else {
            $json = $content;
        }

        // Attempt to clean up common JSON errors
        $json = trim($json);

        // Try decoding
        $decoded = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Log raw response for debugging
            Log::warning('ICP JSON Parse Error: ' . json_last_error_msg());
            Log::warning('Raw Content: ' . substr($content, 0, 500) . '...');

            // Return raw content in a wrapper if parsing fails (fallback)
            throw new \Exception('Failed to parse AI response. Please try again.');
        }

        return $decoded;
    }
}
