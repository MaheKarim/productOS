<?php

namespace Database\Seeders;

use App\Models\RoadmapCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Foundational Skills' => [
                'color' => 'text-blue-500',
                'topics' => [
                    'Product Strategy & Vision',
                    'Market Research & User Research',
                    'Product Discovery & Validation',
                    'Roadmapping & Prioritization',
                ],
            ],
            'Product Development Lifecycle' => [
                'color' => 'text-green-500',
                'topics' => [
                    'Idea Generation & Opportunity Assessment',
                    'Requirements Gathering & Documentation',
                    'Design Collaboration & User Experience',
                    'Agile/Scrum Methodologies',
                    'Development Collaboration',
                    'Testing & Quality Assurance',
                    'Product Launch & Go-to-Market',
                ],
            ],
            'Data & Analytics' => [
                'color' => 'text-purple-500',
                'topics' => [
                    'Product Metrics & KPIs',
                    'A/B Testing & Experimentation',
                    'User Behavior Analysis',
                    'Data-Driven Decision Making',
                ],
            ],
            'Business & Strategy' => [
                'color' => 'text-orange-500',
                'topics' => [
                    'Business Model Canvas',
                    'Competitive Analysis',
                    'Pricing & Monetization',
                    'Stakeholder Management',
                    'P&L Understanding',
                ],
            ],
            'Communication & Leadership' => [
                'color' => 'text-yellow-500',
                'topics' => [
                    'Cross-functional Collaboration',
                    'Presentation Skills',
                    'Influence Without Authority',
                    'Customer Communication',
                    'Team Leadership',
                ],
            ],
            'Technical Knowledge' => [
                'color' => 'text-red-500',
                'topics' => [
                    'APIs & System Architecture',
                    'SQL Basics',
                    'Technical Documentation',
                    'Platform/Technology Trends',
                ],
            ],
            'Specialized Tracks' => [
                'color' => 'text-indigo-500',
                'topics' => [
                    'B2B Product Management',
                    'B2C Product Management',
                    'Platform Products',
                    'AI/ML Products',
                    'Mobile Products',
                    'SaaS Products',
                ],
            ],
        ];

        $order = 1;

        foreach ($categories as $catName => $data) {
            $category = RoadmapCategory::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'order' => $order++,
                'color' => $data['color'],
            ]);

            foreach ($data['topics'] as $topicName) {
                $category->topics()->create([
                    'name' => $topicName,
                    'slug' => Str::slug($topicName),
                    'description' => "Learn about $topicName",
                    'difficulty_level' => 1,
                    'resources' => [],
                ]);
            }
        }
    }
}
