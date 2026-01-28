<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Cache key for settings.
     */
    protected const CACHE_KEY = 'global_settings';

    /**
     * Cache duration in seconds (24 hours).
     */
    protected const CACHE_TTL = 86400;

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->all();

        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }

        return $default;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set(string $key, $value)
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            $setting->update(['value' => $value]);
            $this->clearCache();
            return true;
        }

        return false;
    }

    /**
     * Retrieve all settings from cache or database.
     *
     * @return array
     */
    public function all()
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::all()->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->formatted_value];
            })->toArray();
        });
    }

    /**
     * Clear the settings cache.
     *
     * @return void
     */
    public function clearCache()
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Create or update a setting.
     *
     * @param array $data
     * @return Setting
     */
    public function createOrUpdate(array $data)
    {
        $setting = Setting::updateOrCreate(
            ['key' => $data['key']],
            [
                'group' => $data['group'],
                'value' => $data['value'],
                'type' => $data['type'] ?? 'string',
                'label' => $data['label'] ?? null,
                'description' => $data['description'] ?? null,
                'is_locked' => $data['is_locked'] ?? false,
            ]
        );

        $this->clearCache();

        return $setting;
    }
}
