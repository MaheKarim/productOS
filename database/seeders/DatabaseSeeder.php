<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
                // 1. Admin & Auth
            AdminSeeder::class,

                // 2. Settings & Configuration
            SettingsSeeder::class,
            SmtpSettingsSeeder::class,
            EmailTemplatesSeeder::class,
            OnboardingSettingsSeeder::class,

                // 3. Features & Pages
            FeatureSeeder::class,
            PagesSeeder::class,

                // 4. System Prompts (AI)
            SystemPromptSeeder::class,
            BookQuestionPromptSeeder::class,
            StrategicRoadmapPromptSeeder::class,

                // 5. Content & Directory
            ToolSeeder::class,
            TamSamSomSeeder::class,
            DirectoryCategorySeeder::class,
            DirectoryItemSeeder::class,
            PromptCategorySeeder::class,
            PromptSeeder::class,

                // 6. Roadmap & Topics
            RoadmapSeeder::class,
            TopicSeeder::class,

                // 7. Case Studies & Support
            CaseStudySeeder::class,
            SupportSectionSeeder::class,
            PortfolioSeeder::class,

                // 8. Demo Data (Videos require AiProvider)
            VideoSeeder::class,
        ]);
    }
}
