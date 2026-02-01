<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'key' => 'interview_prep',
                'name' => 'Interview Prep',
                'description' => 'Practice interview questions with AI feedback',
                'is_active' => true,
                'credit_cost' => 10,
                'route_name' => 'user.interview-prep.index',
                'icon' => 'fa-solid fa-clipboard-question',
            ],
            [
                'key' => 'resume_builder',
                'name' => 'Resume Builder',
                'description' => 'Build professional ATS-friendly resumes',
                'is_active' => true,
                'credit_cost' => 15,
                'route_name' => 'resume-builder.index',
                'icon' => 'fa-solid fa-file-contract',
            ],
            [
                'key' => 'strategic_roadmap',
                'name' => 'Strategic Roadmap',
                'description' => 'Plan your career path with strategic insights',
                'is_active' => true,
                'credit_cost' => 5,
                'route_name' => 'user.strategic-roadmap.index',
                'icon' => 'fa-solid fa-map-location-dot',
            ],
        ];

        foreach ($features as $feature) {
            Feature::updateOrCreate(
                ['key' => $feature['key']],
                $feature
            );
        }
    }
}
