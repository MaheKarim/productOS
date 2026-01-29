<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class UserOnboardingController extends Controller
{
    public function create()
    {
        // Double check if feature is enabled, though middleware handles redirect TO here.
        // If disabled, user shouldn't be here, redirect to dashboard.
        $setting = Setting::where('key', 'onboarding_feature_enabled')->first();
        $isEnabled = $setting ? (bool) $setting->formatted_value : true;

        if (!$isEnabled) {
            return redirect()->route('dashboard');
        }

        // If already completed, go to dashboard
        if (Auth::user()->onboarding_completed) {
            return redirect()->route('dashboard');
        }

        $jobRoles = [
            'Entry Level & Junior' => [
                'Aspiring Product Manager',
                'Associate Product Manager (APM)',
                'Junior Product Manager',
                'Product Owner (Junior)',
                'Product Specialist',
                'Product Coordinator',
                'Product Operations Analyst (ProdOps – entry)',
                'Product Analyst',
            ],
            'Mid-Level' => [
                'Product Manager (PM)',
                'Technical Product Manager',
                'Growth Product Manager',
                'Platform Product Manager',
                'AI / ML Product Manager',
                'SaaS Product Manager',
                'FinTech Product Manager',
                'HealthTech Product Manager',
                'EdTech Product Manager',
                'Payments Product Manager',
                'API Product Manager',
                'Infrastructure / Platform PM',
                'Mobile Product Manager',
                'Security Product Manager',
                'Data Product Manager',
                'B2B Product Manager',
                'B2C Product Manager',
                'Product Owner',
                'Product Strategy Manager',
            ],
            'Senior' => [
                'Senior Product Manager',
                'Lead Product Manager',
                'Principal Product Manager',
                'Staff Product Manager',
            ],
            'Management & Leadership' => [
                'Group Product Manager (GPM)',
                'Director of Product Management',
                'Head of Product',
                'VP of Product',
                'Chief Product Officer (CPO)',
            ],
            'Specialized' => [
                'Product Portfolio Manager',
                'Product Operations Manager (ProdOps)',
            ],
        ];

        $yearsOfExperience = [
            '0-1 years',
            '1-3 years',
            '3-5 years',
            '5-8 years',
            '8-12 years',
            '12+ years',
        ];

        return view('user.onboarding.create', compact('jobRoles', 'yearsOfExperience'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_role' => 'required|string|max:255',
            'years_of_experience' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'job_role' => $validated['job_role'],
            'years_of_experience' => $validated['years_of_experience'],
            'company_name' => $validated['company_name'],
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Profile completed successfully! Welcome aboard.');
    }
}
