<?php

namespace Database\Seeders;

use App\Models\SupportSection;
use Illuminate\Database\Seeder;

class SupportSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupportSection::updateOrCreate(
            ['id' => 1],
            [
                'headline' => 'Enjoying These Tools?',
                'body_text' => "If these resources save you time or help you succeed, consider supporting my work!\nEvery cup of coffee fuels more tools, updates, and free resources for Product Managers.",
                'buymeacoffee_url' => 'https://buymeacoffee.com/productos',
                'show_progress_bar' => true,
                'progress_label' => 'Monthly Support Goal',
                'progress_value' => 45,
                'progress_goal' => 100,
                'twitter_url' => 'https://twitter.com/productos',
                'linkedin_url' => 'https://linkedin.com/in/productos',
                'is_active' => true,
            ]
        );
    }
}
