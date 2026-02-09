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
                'name' => 'Resume Analyzer',
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
            [
                'key' => 'icp_builder',
                'name' => 'AI ICP Builder',
                'description' => 'Build ideal customer profiles with AI assistance',
                'is_active' => true,
                'credit_cost' => 10,
                'route_name' => 'icp.index',
                'icon' => 'fa-solid fa-users-viewfinder',
            ],
            [
                'key' => 'job_analyze',
                'name' => 'Job Analyze',
                'description' => 'Analyze job postings against your resume',
                'is_active' => true,
                'credit_cost' => 5,
                'route_name' => 'user.job-analyze.index',
                'icon' => 'fa-solid fa-magnifying-glass-chart',
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
