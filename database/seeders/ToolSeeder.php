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
                'PMF' => 'PMF Score',
                'CareerCompass' => 'PM Career Compass'
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
                $customUrl = $toolName === 'PM Career Compass' ? '/tools/career-compass' : null;

                Tool::create([
                    'name' => $toolName,
                    'slug' => \Str::slug($toolName),
                    'category_id' => $category->id,
                    'custom_url' => $customUrl,
                    'description' => $this->getDescriptionFor($toolName),
                    'difficulty' => $this->getDifficultyFor($toolName),
                    'time_estimate' => $this->getTimeFor($toolName),
                    'is_active' => true,
                    'calculator_config' => [],
                    'content' => "## Context & Usage\n\nThis tool helps you calculate **{$toolName}** to make data-driven decisions.\n\n### When to use\nUse this when you need to validate assumptions about...",
                    'problem_solved' => 'Helps quantify important metrics for decision making.',
                    'when_to_use' => 'When you need data-backed validation.',
                    'when_not_to_use' => 'When you have no initial data.',
                    'data_required' => 'Basic input metrics.',
                    'outcome' => 'Clear actionable insights.',
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
            'PM Career Compass' => 'Comprehensive PM career assessment tool that evaluates your environment, skills, and provides personalized recommendations.',
        ];
        return $descriptions[$name] ?? "Calculate and analyze {$name} for your product.";
    }

    private function getDifficultyFor($name)
    {
        return match ($name) {
            'TAM / SAM / SOM', 'LTV', 'Weighted Scoring', 'PM Career Compass' => 'Advanced',
            'RICE', 'ICE', 'CAC' => 'Medium',
            default => 'Easy'
        };
    }

    private function getTimeFor($name)
    {
        return match ($name) {
            'TAM / SAM / SOM', 'Weighted Scoring', 'PM Career Compass' => '15 mins',
            'LTV', 'ROI Calculator' => '10 mins',
            default => '5 mins'
        };
    }
}
