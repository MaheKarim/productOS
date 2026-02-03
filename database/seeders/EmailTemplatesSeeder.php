<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Welcome Email
            [
                'group' => 'email_templates',
                'key' => 'registration_email_subject',
                'value' => 'Welcome to ProductOS!',
                'type' => 'string',
                'label' => 'Welcome Email Subject',
                'description' => 'Subject line for new user registration emails.',
            ],
            [
                'group' => 'email_templates',
                'key' => 'registration_email_body',
                'value' => "Hi {{name}},\n\nWelcome to ProductOS! We are thrilled to have you on board.\n\nGet started by completing your profile and exploring our tools.\n\nBest,\nThe ProductOS Team",
                'type' => 'textarea',
                'label' => 'Welcome Email Body',
                'description' => 'Available variables: {{name}}, {{email}}',
            ],

            // Forgot Password Email
            [
                'group' => 'email_templates',
                'key' => 'forgot_password_subject',
                'value' => 'Reset Your Password - ProductOS',
                'type' => 'string',
                'label' => 'Forgot Password Subject',
                'description' => 'Subject for password reset request emails.',
            ],
            [
                'group' => 'email_templates',
                'key' => 'forgot_password_body',
                'value' => "Hello,\n\nYou are receiving this email because we received a password reset request for your account.\n\nThis password reset link will expire in 60 minutes.\n\nIf you did not request a password reset, no further action is required.",
                'type' => 'textarea',
                'label' => 'Forgot Password Body',
                'description' => 'Note: The reset button and greeting are added automatically. This text appears before the button.',
            ],

            // Password Reset Success Email
            [
                'group' => 'email_templates',
                'key' => 'password_reset_success_subject',
                'value' => 'Password Changed Successfully - ProductOS',
                'type' => 'string',
                'label' => 'Password Changed Subject',
                'description' => 'Subject for successful password change emails.',
            ],
            [
                'group' => 'email_templates',
                'key' => 'password_reset_success_body',
                'value' => "Hello {{name}}!\n\nYour password has been successfully changed.\n\nIf you did not make this change, please contact our support team immediately.",
                'type' => 'textarea',
                'label' => 'Password Changed Body',
                'description' => 'Available variables: {{name}}',
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
