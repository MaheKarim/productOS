<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'name' => 'Interview Prep',
                'slug' => 'interview-prep',
                'route_name' => 'interview-prep.landing',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 1,
                'seo' => [
                    'title' => 'Ace Your PM Interview | Interview Prep - ProductOS',
                    'description' => 'Practice with real PM interview questions and get AI-powered feedback to land your dream product manager role. 500+ questions across 12 categories.',
                    'keywords' => 'PM interview preparation, product manager interview, interview questions, AI feedback, practice questions',
                    'focus_keyword' => 'PM interview preparation',
                    'canonical_url' => url('/interview-prep'),
                ],
            ],
            [
                'name' => 'Prompts',
                'slug' => 'prompts',
                'route_name' => 'prompts.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 2,
                'seo' => [
                    'title' => 'AI Prompts for Product Managers | PromptHub - ProductOS',
                    'description' => 'Curated collection of proven AI prompts for product managers. Save time with ready-to-use prompts for strategy, roadmaps, user stories, and more.',
                    'keywords' => 'AI prompts, product management prompts, ChatGPT prompts, PM tools, productivity',
                    'focus_keyword' => 'AI prompts for product managers',
                    'canonical_url' => url('/prompts'),
                ],
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'route_name' => 'books.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 3,
                'seo' => [
                    'title' => 'PM Book Library | Essential Reading - ProductOS',
                    'description' => 'Comprehensive library of must-read books for product managers. Discover frameworks, case studies, and insights from industry leaders.',
                    'keywords' => 'product management books, PM reading list, product strategy books, management books',
                    'focus_keyword' => 'product management books',
                    'canonical_url' => url('/books'),
                ],
            ],
            [
                'name' => 'Tools',
                'slug' => 'tools',
                'route_name' => 'tools.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 4,
                'seo' => [
                    'title' => 'PM Toolkit | Essential Tools for Product Managers - ProductOS',
                    'description' => 'Discover essential tools and frameworks for product managers. From roadmapping to analytics, find everything you need to succeed as a PM.',
                    'keywords' => 'product management tools, PM toolkit, roadmap tools, analytics tools, PM frameworks',
                    'focus_keyword' => 'product management tools',
                    'canonical_url' => url('/tools'),
                ],
            ],
            [
                'name' => 'Roadmap',
                'slug' => 'roadmap',
                'route_name' => 'roadmap.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 5,
                'seo' => [
                    'title' => 'PM Career Roadmap | Path to Success - ProductOS',
                    'description' => 'Interactive product management career roadmap. Track your progress from Associate PM to Chief Product Officer with personalized guidance.',
                    'keywords' => 'PM career path, product manager roadmap, career progression, PM skills, professional development',
                    'focus_keyword' => 'product manager career roadmap',
                    'canonical_url' => url('/roadmap'),
                ],
            ],
            [
                'name' => 'About',
                'slug' => 'about',
                'route_name' => 'about',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 6,
                'seo' => [
                    'title' => 'About ProductOS | Your PM Success Platform',
                    'description' => 'Learn about ProductOS, the comprehensive platform helping product managers accelerate their careers with AI-powered tools and resources.',
                    'keywords' => 'about ProductOS, product management platform, PM tools, career development',
                    'focus_keyword' => 'ProductOS platform',
                    'canonical_url' => url('/about'),
                ],
            ],
            [
                'name' => 'Directory',
                'slug' => 'directory',
                'route_name' => 'directory.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 7,
                'seo' => [
                    'title' => 'PM Resource Directory | Curated Tools & Resources - ProductOS',
                    'description' => 'Discover essential product management resources. Curated directory of tools, communities, courses, and frameworks trusted by PMs worldwide.',
                    'keywords' => 'PM resources, product management directory, PM tools directory, PM communities, PM courses',
                    'focus_keyword' => 'product management resources',
                    'canonical_url' => url('/directory'),
                ],
            ],
            [
                'name' => 'YouTube Summarize',
                'slug' => 'youtube-summarize',
                'route_name' => 'yt-summarize.index',
                'is_active' => true,
                'show_in_navigation' => false, // Hidden for now
                'menu_order' => 8,
                'seo' => [
                    'title' => 'YouTube Video Summarizer | AI-Powered - ProductOS',
                    'description' => 'Instantly summarize YouTube videos with AI. Save time by getting key insights from PM talks, tutorials, and conferences in seconds.',
                    'keywords' => 'YouTube summarizer, video summary, AI summarizer, video transcript, time saver',
                    'focus_keyword' => 'YouTube video summarizer',
                    'canonical_url' => url('/youtube-summarize'),
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $seoData = $pageData['seo'];
            unset($pageData['seo']);

            $page = Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );

            $page->seoMetadata()->updateOrCreate(
                ['page_id' => $page->id],
                $seoData
            );

            // Calculate initial SEO score
            $page->seoMetadata->calculateSeoScore();
        }
    }
}
