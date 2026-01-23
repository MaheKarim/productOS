<?php

namespace Database\Seeders;

use App\Models\DirectoryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DirectoryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Tools Categories
            [
                'type' => 'tools',
                'name' => 'Project Management',
                'description' => 'Tools for planning, executing, and tracking projects.',
                'icon' => 'fa-solid fa-list-check',
                'color_class' => 'bg-blue-500',
            ],
            [
                'type' => 'tools',
                'name' => 'Design & Prototyping',
                'description' => 'Create beautiful user interfaces and experiences.',
                'icon' => 'fa-solid fa-pen-nib',
                'color_class' => 'bg-purple-500',
            ],
            [
                'type' => 'tools',
                'name' => 'Analytics & Data',
                'description' => 'Measure product performance and user behavior.',
                'icon' => 'fa-solid fa-chart-line',
                'color_class' => 'bg-green-500',
            ],
            [
                'type' => 'tools',
                'name' => 'Collaboration',
                'description' => 'Work together seamlessly with your team.',
                'icon' => 'fa-solid fa-users',
                'color_class' => 'bg-yellow-500',
            ],
            [
                'type' => 'tools',
                'name' => 'Roadmapping',
                'description' => 'Visualize your product strategy and timeline.',
                'icon' => 'fa-solid fa-map',
                'color_class' => 'bg-red-500',
            ],

            // Learning Categories
            [
                'type' => 'learning',
                'name' => 'PM Fundamentals',
                'description' => 'Core concepts every Product Manager should know.',
                'icon' => 'fa-solid fa-graduation-cap',
                'color_class' => 'bg-indigo-500',
            ],
            [
                'type' => 'learning',
                'name' => 'Agile & Scrum',
                'description' => 'Master the most popular development methodologies.',
                'icon' => 'fa-solid fa-rotate',
                'color_class' => 'bg-orange-500',
            ],
            [
                'type' => 'learning',
                'name' => 'Product Strategy',
                'description' => 'Learn how to build products that win in the market.',
                'icon' => 'fa-solid fa-chess',
                'color_class' => 'bg-teal-500',
            ],

            // Companies Categories (Industries)
            [
                'type' => 'companies',
                'name' => 'FinTech',
                'description' => 'Financial technology companies innovating money.',
                'icon' => 'fa-solid fa-wallet',
                'color_class' => 'bg-cyan-500',
            ],
            [
                'type' => 'companies',
                'name' => 'E-commerce',
                'description' => 'Online retail and marketplace platforms.',
                'icon' => 'fa-solid fa-cart-shopping',
                'color_class' => 'bg-pink-500',
            ],
            [
                'type' => 'companies',
                'name' => 'SaaS',
                'description' => 'Software as a Service providers.',
                'icon' => 'fa-solid fa-cloud',
                'color_class' => 'bg-sky-500',
            ],
            [
                'type' => 'companies',
                'name' => 'Ride Sharing & Logistics',
                'description' => 'Moving people and goods efficiently.',
                'icon' => 'fa-solid fa-car',
                'color_class' => 'bg-slate-500',
            ],

            // Communities Categories
            [
                'type' => 'communities',
                'name' => 'Online Groups',
                'description' => 'Facebook, LinkedIn, and Discord communities.',
                'icon' => 'fa-solid fa-globe',
                'color_class' => 'bg-blue-600',
            ],
            [
                'type' => 'communities',
                'name' => 'Meetups & Events',
                'description' => 'In-person and virtual gatherings.',
                'icon' => 'fa-solid fa-ticket',
                'color_class' => 'bg-red-600',
            ],

            // Templates Categories
            [
                'type' => 'templates',
                'name' => 'Documentation',
                'description' => 'PRDs, One-pagers, and specs.',
                'icon' => 'fa-solid fa-file-lines',
                'color_class' => 'bg-emerald-500',
            ],
            [
                'type' => 'templates',
                'name' => 'Strategy Frameworks',
                'description' => 'Canvases and strategic models.',
                'icon' => 'fa-solid fa-layer-group',
                'color_class' => 'bg-violet-500',
            ],
        ];

        foreach ($categories as $index => $category) {
            DirectoryCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                array_merge($category, ['display_order' => $index])
            );
        }
    }
}
