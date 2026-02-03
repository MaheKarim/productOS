<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display the global settings page.
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        // Define tabs and their labels
        $groups = [
            'general' => 'General',
            'contact' => 'Contact',
            'seo' => 'SEO',
            'social' => 'Social Media',
            'email' => 'Email / SMTP',
            'email_templates' => 'Email Templates',
            'maintenance' => 'Maintenance',
            'auth' => 'User & Auth',
            'logs' => 'Activity Logs',
            'notifications' => 'Notifications',
        ];

        return view('admin.system-settings.index', compact('settings', 'groups'));
    }

    /**
     * Update global settings.
     */
    public function update(Request $request)
    {
        // We handle validation dynamically or loosely here as fields vary wildly
        // Ideally, we'd use a FormRequest with dynamically generated rules

        $inputs = $request->except(['_token', '_method']);

        foreach ($inputs as $key => $value) {
            // Find the setting definition to check type
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                // Handle File Uploads (Logo, Favicon, etc.)
                if ($request->hasFile($key)) {
                    $path = $request->file($key)->store('settings', 'public');
                    $this->settingsService->set($key, $path);
                    continue;
                }

                $this->settingsService->set($key, $value);
            }
        }

        // Handle boolean toggles that might be missing from request if unchecked
        // (Only for boolean types present in the current group/tab if we were splitting updates)
        // For now, assume we implement a specific handling for unchecked checkboxes if needed.
        // A common pattern is hidden inputs or explicitly checking boolean keys.

        return back()->with('success', 'Settings updated successfully.');
    }
}
