<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // 1. General Site Settings
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'ProductOS',
                'type' => 'string',
                'label' => 'Site Name',
                'description' => 'The name of your application.',
                'is_locked' => true,
            ],
            [
                'group' => 'general',
                'key' => 'site_tagline',
                'value' => 'Analytics-Driven Product Management',
                'type' => 'string',
                'label' => 'Site Tagline',
                'description' => 'A short slogan for your site.',
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'value' => 'ProductOS is a comprehensive platform for product managers.',
                'type' => 'string',
                'label' => 'Site Description',
                'description' => 'Used for meta description and general info.',
            ],
            [
                'group' => 'general',
                'key' => 'timezone',
                'value' => 'UTC',
                'type' => 'string',
                'label' => 'Timezone',
                'description' => 'Application default timezone.',
            ],

            // 2. Contact Information
            [
                'group' => 'contact',
                'key' => 'contact_email',
                'value' => 'support@productos.com',
                'type' => 'string',
                'label' => 'Support Email',
                'description' => 'Public facing support email.',
            ],

            // 3. SEO Settings
            [
                'group' => 'seo',
                'key' => 'meta_title_default',
                'value' => 'ProductOS - Analytics for PMs',
                'type' => 'string',
                'label' => 'Default Meta Title',
            ],
            [
                'group' => 'seo',
                'key' => 'google_analytics_id',
                'value' => 'UA-XXXXX-Y',
                'type' => 'string',
                'label' => 'Google Analytics ID',
            ],

            // 4. Social Media Links
            [
                'group' => 'social',
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/productos',
                'type' => 'string',
                'label' => 'Twitter / X URL',
            ],
            [
                'group' => 'social',
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/company/productos',
                'type' => 'string',
                'label' => 'LinkedIn URL',
            ],

            // 6. Maintenance Mode
            [
                'group' => 'maintenance',
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'label' => 'Maintenance Mode',
                'description' => 'Enable to show maintenance page to non-admins.',
            ],
            [
                'group' => 'maintenance',
                'key' => 'maintenance_message',
                'value' => 'We are currently performing scheduled maintenance.',
                'type' => 'string',
                'label' => 'Maintenance Message',
            ],

            // 7. User & Auth
            [
                'group' => 'auth',
                'key' => 'registration_enabled',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Allow Registration',
                'description' => 'Toggle user registration on/off.',
            ],
            [
                'group' => 'auth',
                'key' => 'require_email_verification',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Require Email Verification',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
