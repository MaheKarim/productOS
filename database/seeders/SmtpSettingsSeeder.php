<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SmtpSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // SMTP Settings
            [
                'group' => 'email',
                'key' => 'smtp_host',
                'value' => 'smtp.mailtrap.io',
                'type' => 'string',
                'label' => 'SMTP Host',
            ],
            [
                'group' => 'email',
                'key' => 'smtp_port',
                'value' => '2525',
                'type' => 'string',
                'label' => 'SMTP Port',
            ],
            [
                'group' => 'email',
                'key' => 'smtp_username',
                'value' => '',
                'type' => 'string',
                'label' => 'SMTP Username',
            ],
            [
                'group' => 'email',
                'key' => 'smtp_password',
                'value' => '',
                'type' => 'password', // Custom type required in view
                'label' => 'SMTP Password',
            ],
            [
                'group' => 'email',
                'key' => 'smtp_encryption',
                'value' => 'tls',
                'type' => 'string',
                'label' => 'Encryption',
                'description' => 'tls or ssl',
            ],
            [
                'group' => 'email',
                'key' => 'mail_from_address',
                'value' => 'hello@example.com',
                'type' => 'string',
                'label' => 'From Address',
            ],
            [
                'group' => 'email',
                'key' => 'mail_from_name',
                'value' => 'ProductOS',
                'type' => 'string',
                'label' => 'From Name',
            ],

            // Registration Email Template
            [
                'group' => 'email',
                'key' => 'registration_email_subject',
                'value' => 'Welcome to ProductOS!',
                'type' => 'string',
                'label' => 'Registration Subject',
                'description' => 'Subject line for the welcome email.',
            ],
            [
                'group' => 'email',
                'key' => 'registration_email_body',
                'value' => "Hi {{name}},\n\nWelcome to ProductOS! We are excited to have you on board.\n\nBest,\nThe ProductOS Team",
                'type' => 'text', // Textarea
                'label' => 'Registration Body',
                'description' => 'Available variables: {{name}}, {{email}}',
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
