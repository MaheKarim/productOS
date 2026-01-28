<?php

use App\Services\SettingsService;

if (!function_exists('settings')) {
    /**
     * Get or set a global setting.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        $service = app(SettingsService::class);

        if (is_null($key)) {
            return $service;
        }

        return $service->get($key, $default);
    }
}
