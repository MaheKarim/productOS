<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(\App\Services\SettingsService $settings): void
    {
        // Override Mail Config from Database Settings
        // Only if smtp_host is set to avoid breaking default config if DB is empty
        if ($settings->get('smtp_host')) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $settings->get('smtp_host'),
                'mail.mailers.smtp.port' => $settings->get('smtp_port'),
                'mail.mailers.smtp.username' => $settings->get('smtp_username'),
                'mail.mailers.smtp.password' => $settings->get('smtp_password'),
                'mail.mailers.smtp.encryption' => $settings->get('smtp_encryption'),
                'mail.from.address' => $settings->get('mail_from_address'),
                'mail.from.name' => $settings->get('mail_from_name'),
            ]);
        }
    }
}
