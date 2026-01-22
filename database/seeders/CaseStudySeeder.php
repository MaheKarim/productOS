<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseStudy;

class CaseStudySeeder extends Seeder
{
    public function run()
    {
        CaseStudy::truncate();

        $caseStudies = [
            [
                'title' => 'Scaling Fintech Growth',
                'slug' => 'scaling-fintech-growth',
                'industry' => 'Fintech',
                'headline_metric' => '+300% ARR',
                'problem' => 'User acquisition was stagnant despite high spend.',
                'strategy' => 'Shifted focus from paid acquisition to product-led growth loops.',
                'implementation' => json_encode(['Implemented referral program', 'Optimized onboarding flow', 'Launched freemium tier']),
                'results' => json_encode(['300% ARR growth in 12 months', 'CAC reduced by 40%']),
                'tools_used' => json_encode(['CAC', 'LTV', 'Retention']),
                'is_featured' => true,
            ],
            // Add more as needed
        ];

        foreach ($caseStudies as $study) {
            CaseStudy::create($study);
        }
    }
}
