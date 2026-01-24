<?php

namespace Database\Seeders;

use App\Models\PromptCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromptCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Strategy & Planning',
                'slug' => 'strategy-planning',
                'icon' => 'target',
                'description' => 'Prompts for strategic planning, roadmaps, and OKRs',
                'order' => 1,
            ],
            [
                'name' => 'Product Execution',
                'slug' => 'product-execution',
                'icon' => 'rocket',
                'description' => 'PRDs, user stories, and feature specifications',
                'order' => 2,
            ],
            [
                'name' => 'User Research',
                'slug' => 'user-research',
                'icon' => 'users',
                'description' => 'Interview scripts, surveys, and user analysis',
                'order' => 3,
            ],
            [
                'name' => 'Analytics & Metrics',
                'slug' => 'analytics-metrics',
                'icon' => 'bar-chart-2',
                'description' => 'KPIs, dashboards, and data analysis',
                'order' => 4,
            ],
            [
                'name' => 'Stakeholder Management',
                'slug' => 'stakeholder-management',
                'icon' => 'message-square',
                'description' => 'Communication templates and alignment prompts',
                'order' => 5,
            ],
            [
                'name' => 'Documentation',
                'slug' => 'documentation',
                'icon' => 'file-text',
                'description' => 'Technical specs, release notes, and docs',
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            PromptCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
