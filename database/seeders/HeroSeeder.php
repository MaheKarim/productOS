<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::truncate();

        HeroSection::create([
            'is_active' => true,
            'order' => 1,
            'badge_text' => 'Senior Product Manager',
            'title' => 'I Build Products That Scale Revenue',
            'subtitle' => 'Combining rigorous data analysis with strategic thinking to transform product ideas into growth engines. My approach: Strategy + Metrics + Execution.',
            'cta_primary_text' => 'Explore Toolkit',
            'cta_primary_url' => '/tools',
            'cta_secondary_text' => 'View Case Studies',
            'cta_secondary_url' => '/portfolio',
            'stat1_icon' => 'chart-line',
            'stat1_value' => '300%',
            'stat1_label' => 'ARR Growth',
            'stat2_icon' => 'users',
            'stat2_value' => '40%',
            'stat2_label' => 'CAC Reduction',
            'stat3_icon' => 'target',
            'stat3_value' => '50+',
            'stat3_label' => 'Products Shipped',
            'floating_card1_icon' => 'rocket',
            'floating_card1_title' => 'Product-Led Growth',
            'floating_card1_subtitle' => 'Driving acquisition through product value.',
            'floating_card2_icon' => 'analytics',
            'floating_card2_title' => 'Data-Driven Decisions',
            'floating_card2_subtitle' => 'Every feature backed by metrics.',
            'meta_title' => 'ProductOS - Analytics-Driven Product Management',
            'meta_description' => 'Senior Product Manager portfolio showcasing data-driven growth strategies, SaaS metrics expertise, and a comprehensive PM toolkit.',
        ]);
    }
}
