<?php

namespace Database\Seeders;

use App\Models\DirectoryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DirectoryItemSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // TOOLS
        // ---------------------------------------------------------
        $tools = [
            [
                'name' => 'Jira Software',
                'category' => 'Project Management',
                'tagline' => 'The #1 software development tool used by agile teams.',
                'description' => 'Jira Software is built for every member of your software team to plan, track, and release great software.',
                'website_url' => 'https://www.atlassian.com/software/jira',
                'pricing_model' => 'freemium',
                'key_features' => ['Scrum boards', 'Kanban boards', 'Roadmaps', 'Agile reporting'],
            ],
            [
                'name' => 'Asana',
                'category' => 'Project Management',
                'tagline' => 'Work management platform for teams.',
                'description' => 'Asana helps teams orchestrate their work, from small projects to strategic initiatives.',
                'website_url' => 'https://asana.com/',
                'pricing_model' => 'freemium',
                'key_features' => ['Timeline', 'Boards', 'Calendar', 'Portfolios'],
            ],
            [
                'name' => 'Figma',
                'category' => 'Design & Prototyping',
                'tagline' => 'The collaborative interface design tool.',
                'description' => 'Figma connects everyone in the design process so teams can deliver better products, faster.',
                'website_url' => 'https://www.figma.com/',
                'pricing_model' => 'freemium',
                'key_features' => ['Real-time collaboration', 'Vector networks', 'Prototyping', 'Dev Mode'],
            ],
            [
                'name' => 'Miro',
                'category' => 'Collaboration',
                'tagline' => 'The visual collaboration platform for every team.',
                'description' => 'Scalable, secure, cross-device and enterprise-ready team collaboration whiteboard for distributed teams.',
                'website_url' => 'https://miro.com/',
                'pricing_model' => 'freemium',
                'key_features' => ['Online whiteboard', 'Templates', 'Integrations', 'Infinite canvas'],
            ],
            [
                'name' => 'Amplitude',
                'category' => 'Analytics & Data',
                'tagline' => '#1 Product Analytics Software.',
                'description' => 'Amplitude is the Digital Optimization System. It empowers teams to build better products.',
                'website_url' => 'https://amplitude.com/',
                'pricing_model' => 'freemium',
                'key_features' => ['Behavioral analytics', 'User segmentation', 'Retention analysis', 'Funnel analysis'],
            ],
        ];

        foreach ($tools as $tool) {
            $slug = Str::slug($tool['name']);
            DirectoryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($tool, [
                    'type' => 'tools',
                    'uuid' => Str::uuid(),
                    'slug' => $slug,
                    'is_active' => true,
                    'is_featured' => rand(0, 1),
                    'verification_status' => 'verified',
                ])
            );
        }

        // ---------------------------------------------------------
        // LEARNING
        // ---------------------------------------------------------
        $learningRefs = [
            [
                'name' => 'Product Management 101',
                'category' => 'PM Fundamentals',
                'content_type' => 'course',
                'tagline' => 'The complete guide to becoming a Product Manager.',
                'instructor' => 'Product School',
                'platform' => 'Udemy',
                'language' => 'english',
                'difficulty_level' => 'beginner',
            ],
            [
                'name' => 'Inspired: How to Create Tech Products Customers Love',
                'category' => 'Product Strategy',
                'content_type' => 'book',
                'tagline' => 'The Bible of Product Management.',
                'instructor' => 'Marty Cagan',
                'language' => 'english',
                'difficulty_level' => 'intermediate',
            ],
        ];

        foreach ($learningRefs as $item) {
            $slug = Str::slug($item['name']);
            DirectoryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, [
                    'type' => 'learning',
                    'uuid' => Str::uuid(),
                    'slug' => $slug,
                    'is_active' => true,
                    'verification_status' => 'verified',
                ])
            );
        }

        // ---------------------------------------------------------
        // COMPANIES
        // ---------------------------------------------------------
        $companies = [
            [
                'name' => 'bKash',
                'category' => 'FinTech',
                'tagline' => 'Bangladesh\'s largest MFS provider.',
                'is_hiring' => true,
                'location' => 'Dhaka',
                'company_size' => '500+',
                'remote_policy' => 'hybrid',
            ],
            [
                'name' => 'Pathao',
                'category' => 'Ride Sharing & Logistics',
                'tagline' => 'Moving Bangladesh forward.',
                'is_hiring' => true,
                'location' => 'Dhaka',
                'company_size' => '500+',
                'remote_policy' => 'onsite',
            ],
            [
                'name' => 'Chaldal',
                'category' => 'E-commerce',
                'tagline' => 'Best online grocery shop in Bangladesh.',
                'is_hiring' => false,
                'location' => 'Dhaka',
                'company_size' => '201-500',
                'remote_policy' => 'onsite',
            ],
        ];

        foreach ($companies as $item) {
            $slug = Str::slug($item['name']);
            DirectoryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, [
                    'type' => 'companies',
                    'uuid' => Str::uuid(),
                    'slug' => $slug,
                    'is_active' => true,
                    'verification_status' => 'verified',
                ])
            );
        }

        // ---------------------------------------------------------
        // COMMUNITIES
        // ---------------------------------------------------------
        $communities = [
            [
                'name' => 'Product Management BD',
                'category' => 'Online Groups',
                'tagline' => 'Largest community of PMs in Bangladesh.',
                'platform' => 'Facebook',
                'member_count' => '15K+',
                'activity_level' => 'very_active',
                'join_url' => '#',
            ],
        ];
        foreach ($communities as $item) {
            $slug = Str::slug($item['name']);
            DirectoryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, [
                    'type' => 'communities',
                    'uuid' => Str::uuid(),
                    'slug' => $slug,
                    'is_active' => true,
                    'verification_status' => 'verified',
                ])
            );
        }

        // ---------------------------------------------------------
        // TEMPLATES
        // ---------------------------------------------------------
        $templates = [
            [
                'name' => 'Standard PRD Template',
                'category' => 'Documentation',
                'tagline' => 'A comprehensive Product Requirements Document template.',
                'template_type' => 'prd',
                'file_format' => 'Google Docs',
                'download_url' => '#',
            ],
        ];

        foreach ($templates as $item) {
            $slug = Str::slug($item['name']);
            DirectoryItem::updateOrCreate(
                ['slug' => $slug],
                array_merge($item, [
                    'type' => 'templates',
                    'uuid' => Str::uuid(),
                    'slug' => $slug,
                    'is_active' => true,
                    'verification_status' => 'verified',
                ])
            );
        }
    }
}
