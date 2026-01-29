<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OnboardingSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if setting already exists to avoid duplicates
        $exists = DB::table('settings')->where('key', 'onboarding_feature_enabled')->exists();

        if (!$exists) {
            DB::table('settings')->insert([
                'group' => 'auth',
                'key' => 'onboarding_feature_enabled',
                'value' => '1', // Enabled by default as per spec option (or 0 if preferred, spec said "true (or false based on your preference)", I'll go with true)
                'type' => 'boolean',
                'label' => 'Enable User Onboarding',
                'description' => 'If enabled, new users must complete professional information before accessing the dashboard.',
                'is_locked' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
