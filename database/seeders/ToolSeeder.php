<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToolCategory;
use App\Models\Tool;

class ToolSeeder extends Seeder
{
    public function run()
    {
        // Clear existing tools to ensure clean state
        Tool::truncate();
        ToolCategory::truncate();

        $categories = [
            'Strategy & Validation' => [
                'NAM' => 'TAM / SAM / SOM', // NAM key for uniqueness if needed, using value as name
                'ROI' => 'ROI Calculator'
            ],
            'SaaS Metrics' => [
                'MRR' => 'MRR',
                'ARR' => 'ARR',
                'LTV' => 'LTV',
                'CAC' => 'CAC',
                'Retention' => 'Retention',
                'Churn' => 'Churn Rate'
            ],
            'Prioritization' => [
                'RICE' => 'RICE',
                'ICE' => 'ICE',
                'Weighted' => 'Weighted Scoring',
                'Kano' => 'Kano Model',
                'Impact' => 'Impact / Effort Matrix'
            ],
            'Validation & Research' => [
                'AB' => 'A/B Test',
                'Sample' => 'Sample Size',
                'NPS' => 'NPS',
                'PMF' => 'PMF Score'
            ],
            'Execution & Delivery' => [
                'Velocity' => 'Velocity',
                'Cycle' => 'Cycle Time'
            ],
            'Growth & Engagement' => [
                'Conversion' => 'Conversion Rate',
                'DAU' => 'DAU / MAU'
            ],
        ];

        foreach ($categories as $catName => $tools) {
            $category = ToolCategory::create([
                'name' => $catName,
                'slug' => \Str::slug($catName),
                'icon' => 'folder'
            ]);

            foreach ($tools as $key => $toolName) {
                Tool::create([
                    'name' => $toolName,
                    'slug' => \Str::slug($toolName),
                    'category_id' => $category->id,
                    'description' => $this->getDescriptionFor($toolName),
                    'difficulty' => $this->getDifficultyFor($toolName),
                    'time_estimate' => $this->getTimeFor($toolName),
                    'is_active' => true,
                    'calculator_config' => [],
                    'content' => "## Context & Usage\n\nThis tool helps you calculate **{$toolName}** to make data-driven decisions.\n\n### When to use\nUse this when you need to validate assumptions about...",
                ]);
            }
        }
    }

    private function getDescriptionFor($name)
    {
        $descriptions = [
            'TAM / SAM / SOM' => 'Estimate your total addressable market size.',
            'ROI Calculator' => 'Calculate the return on investment for a feature.',
            'CAC' => 'Calculate Customer Acquisition Cost accurately.',
            'LTV' => 'Estimate Customer Lifetime Value.',
            'RICE' => 'Prioritize features using Reach, Impact, Confidence, and Effort.',
        ];
        return $descriptions[$name] ?? "Calculate and analyze {$name} for your product.";
    }

    private function getDifficultyFor($name)
    {
        return match ($name) {
            'TAM / SAM / SOM', 'LTV', 'Weighted Scoring' => 'Advanced',
            'RICE', 'ICE', 'CAC' => 'Medium',
            default => 'Easy'
        };
    }

    private function getTimeFor($name)
    {
        return match ($name) {
            'TAM / SAM / SOM', 'Weighted Scoring' => '15 mins',
            'LTV', 'ROI Calculator' => '10 mins',
            default => '5 mins'
        };
    }
}
