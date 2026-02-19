<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\FooterSettings;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        HeroSection::updateOrCreate(
            ['order' => 1],
            [
                'is_active' => true,
                'badge_text' => 'Product Manager + Growth Strategist',
                'title' => "I build growth strategies—\nand the tools to measure them",
                'subtitle' => "Strategy + Data + Execution\nHelping B2B SaaS and consumer products make decisions backed by metrics, not assumptions.",
                'cta_primary_text' => 'View Case Studies',
                'cta_primary_url' => '#portfolio',
                'cta_secondary_text' => 'Try Tools',
                'cta_secondary_url' => '#toolkit',
                'stat1_icon' => 'fa-solid fa-users',
                'stat1_value' => '2.4M+',
                'stat1_label' => 'Users Impacted',
                'stat2_icon' => 'fa-solid fa-chart-line',
                'stat2_value' => '127%',
                'stat2_label' => 'Avg Growth Rate',
                'stat3_icon' => 'fa-solid fa-rocket',
                'stat3_value' => '23',
                'stat3_label' => 'Products Shipped',
                'floating_card1_icon' => 'fa-solid fa-trophy',
                'floating_card1_title' => '8 Years Experience',
                'floating_card1_subtitle' => 'Top 1% PM',
                'floating_card2_icon' => 'fa-solid fa-star',
                'floating_card2_title' => '94% Projects',
                'floating_card2_subtitle' => 'Success Rate',
            ]
        );

        // About Section
        AboutSection::updateOrCreate(
            ['order' => 1],
            [
                'is_active' => true,
                'heading' => 'About Me',
                'description' => "I'm a product manager who believes that great products are built on great metrics. For the past 8 years, I've helped B2B and consumer companies turn data into growth.\n\nMy approach is simple: understand the problem deeply, measure what matters, test systematically, and scale what works. I've done this across 23 products, from 0-to-1 launches to scaling products to millions of users.",
                'philosophy1_title' => 'Data over opinions',
                'philosophy1_description' => 'Every decision backed by evidence, every hypothesis tested',
                'philosophy2_title' => 'Outcomes over outputs',
                'philosophy2_description' => "Shipping features means nothing if they don't move metrics",
                'philosophy3_title' => 'Speed over perfection',
                'philosophy3_description' => 'Ship fast, learn faster, iterate constantly',
                'philosophy4_title' => 'Users over stakeholders',
                'philosophy4_description' => 'Build what users need, not what executives think they need',
                'work_item1' => 'Embedded in your team, not external consultant',
                'work_item2' => 'Hands-on execution, not just strategy decks',
                'work_item3' => 'Weekly progress reviews with clear metrics',
                'work_item4' => 'Knowledge transfer: leave your team stronger',
                'core_value1' => 'Intellectual honesty',
                'core_value2' => 'Bias toward action',
                'core_value3' => 'Continuous learning',
                'core_value4' => 'User empathy',
            ]
        );

        // Services
        $services = [
            [
                'order' => 1,
                'title' => 'Product Strategy & Discovery',
                'icon' => 'fa-lightbulb',
                'icon_type' => 'fa-solid',
                'problem_solves' => "You're building features without clear strategic direction or validation that they'll move the needle.",
                'tangible_outcome' => 'A validated product roadmap with prioritized initiatives tied to measurable business outcomes.',
                'features' => ['Opportunity sizing & market analysis', 'User research & problem validation', 'North Star Metric definition', '3-6 month roadmap with success metrics'],
                'cta_text' => 'See Related Work',
                'cta_url' => '#portfolio',
                'cta_style' => 'primary',
            ],
            [
                'order' => 2,
                'title' => 'Growth & Experimentation',
                'icon' => 'fa-chart-line',
                'icon_type' => 'fa-solid',
                'problem_solves' => "Growth has plateaued and you're running out of ideas on what to test next.",
                'tangible_outcome' => 'A systematic experimentation program that delivers 15-30% improvement in key metrics within 3 months.',
                'features' => ['Growth model & lever identification', 'Experiment backlog (20+ ideas)', 'A/B testing framework & tooling', 'Weekly experiment reviews'],
                'cta_text' => 'See Related Work',
                'cta_url' => '#portfolio',
                'cta_style' => 'secondary',
            ],
            [
                'order' => 3,
                'title' => 'Metrics & Analytics',
                'icon' => 'fa-chart-pie',
                'icon_type' => 'fa-solid',
                'problem_solves' => "You have data but don't know which metrics matter or how to use them for decisions.",
                'tangible_outcome' => 'A complete metrics framework with dashboards that enable data-driven decision making across the org.',
                'features' => ['Metrics hierarchy & definitions', 'Event tracking implementation', 'Custom dashboards & reports', 'Team training on data interpretation'],
                'cta_text' => 'See Related Work',
                'cta_url' => '#portfolio',
                'cta_style' => 'primary',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                array_merge($service, ['is_active' => true])
            );
        }

        // Projects
        $projects = [
            [
                'order' => 1,
                'title' => 'Redesigning the Onboarding Flow for a B2B Analytics Platform',
                'description' => 'Reduced time-to-value from 14 days to 3 days through strategic product changes and a metrics-driven experimentation framework.',
                'category' => 'B2B SaaS',
                'metric_value' => '+89%',
                'metric_label' => 'Trial-to-Paid Conversion',
                'duration' => '6 months',
                'users' => '47K users',
                'tags' => ['Growth', 'Onboarding', 'B2B'],
                'related_tools' => ['Activation Rate Calculator', 'Cohort Analyzer', 'A/B Test Calculator'],
            ],
            [
                'order' => 2,
                'title' => 'Launching a Viral Referral Program',
                'description' => 'Built a K-factor optimization model that increased organic user acquisition by 3.2x.',
                'category' => 'Consumer App',
                'metric_value' => '+156%',
                'metric_label' => 'DAU Growth',
                'duration' => '8 months',
                'users' => '340K users',
                'tags' => ['Growth', 'Viral', 'Consumer'],
                'related_tools' => ['Viral Coefficient Calculator'],
            ],
            [
                'order' => 3,
                'title' => 'Pricing Model Optimization',
                'description' => 'Redesigned pricing tiers using Van Westendorp analysis and willingness-to-pay data.',
                'category' => 'Fintech',
                'metric_value' => '+42%',
                'metric_label' => 'Revenue Growth',
                'duration' => '4 months',
                'users' => '89K users',
                'tags' => ['Pricing', 'Fintech', 'Monetization'],
                'related_tools' => ['Pricing Sensitivity Tool'],
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                array_merge($project, ['is_active' => true])
            );
        }

        // Testimonials
        $testimonials = [
            [
                'order' => 1,
                'name' => 'Sarah Chen',
                'designation' => 'VP of Product',
                'company' => 'TechCorp',
                'feedback' => 'Working with this PM was transformative for our product. They brought a level of analytical rigor that helped us focus on the right metrics and double our conversion rates.',
                'rating' => 5,
            ],
            [
                'order' => 2,
                'name' => 'Michael Torres',
                'designation' => 'CEO',
                'company' => 'GrowthStart',
                'feedback' => 'The experimentation framework they set up is still driving results a year later. Best PM hire we ever made.',
                'rating' => 5,
            ],
            [
                'order' => 3,
                'name' => 'Emily Watson',
                'designation' => 'Head of Growth',
                'company' => 'FinanceApp',
                'feedback' => 'Clear communication, data-driven approach, and real results. Our pricing change led to a 42% revenue increase.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                array_merge($testimonial, ['is_active' => true])
            );
        }

        // Footer Settings
        FooterSettings::updateOrCreate(
            ['order' => 1],
            [
                'is_active' => true,
                'logo_text' => 'productOS',
                'description' => 'Building growth strategies and the tools to measure them.',
                'linkedin_url' => 'https://linkedin.com',
                'twitter_url' => 'https://twitter.com',
                'github_url' => 'https://github.com',
                'email' => 'pm@example.com',
                'column1_links' => [
                    ['text' => 'B2B SaaS Onboarding', 'url' => '#'],
                    ['text' => 'Viral Referral Program', 'url' => '#'],
                    ['text' => 'Pricing Optimization', 'url' => '#'],
                    ['text' => 'View All Projects', 'url' => '#portfolio'],
                ],
                'column2_links' => [
                    ['text' => 'Activation Calculator', 'url' => '#'],
                    ['text' => 'Cohort Analyzer', 'url' => '#'],
                    ['text' => 'A/B Test Calculator', 'url' => '#'],
                    ['text' => 'Browse All Tools', 'url' => '#toolkit'],
                ],
                'column3_links' => [
                    ['text' => 'LinkedIn', 'url' => 'https://linkedin.com'],
                    ['text' => 'Twitter', 'url' => 'https://twitter.com'],
                    ['text' => 'Email', 'url' => 'mailto:pm@example.com'],
                    ['text' => 'Schedule a Call', 'url' => '#contact'],
                ],
                'copyright_text' => 'PM+ Portfolio. All rights reserved.',
                'privacy_policy_url' => '#',
                'terms_url' => '#',
            ]
        );
    }
}
