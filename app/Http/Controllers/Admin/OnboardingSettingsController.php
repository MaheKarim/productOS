<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class OnboardingSettingsController extends Controller
{
    /**
     * Display the onboarding settings page.
     */
    public function index()
    {
        $setting = Setting::where('key', 'onboarding_feature_enabled')->first();
        $isEnabled = $setting ? (bool) $setting->formatted_value : true; // Default to true if missing (though seeder ensures it exists)

        return view('admin.onboarding.settings', compact('isEnabled', 'setting'));
    }

    /**
     * Update the onboarding settings.
     */
    public function update(Request $request)
    {
        // Checkbox only sends value if checked. If unchecked, it's missing from request.
        // But simpler logic: we expect a boolean toggle.
        // Usually UI sends '1' or 'on' if checked.

        $isEnabled = $request->has('onboarding_feature_enabled');

        Setting::updateOrCreate(
            ['key' => 'onboarding_feature_enabled'],
            [
                'value' => $isEnabled ? '1' : '0',
                'group' => 'auth',
                'type' => 'boolean',
                'label' => 'Enable User Onboarding',
            ]
        );

        return back()->with('success', 'Onboarding settings updated successfully.');
    }
}
