<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class EnsureOnboardingCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is authenticated
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // 2. Check if onboarding feature is enabled globally
        // We'll fetch from cache or DB. For now DB directly or use the helper if available.
        // I'll query directly to be safe and independent.
        $setting = Setting::where('key', 'onboarding_feature_enabled')->first();
        $isEnabled = $setting ? (bool) $setting->formatted_value : true; // Default true if not found as per seeder logic

        if (!$isEnabled) {
            return $next($request);
        }

        // 3. Check if user has completed onboarding
        if ($user->onboarding_completed) {
            return $next($request);
        }

        // 4. Redirect to onboarding page if not completed
        // Ensure we don't redirect if we are already ON the onboarding page to avoid loops
        if ($request->routeIs('onboarding.*')) {
            return $next($request);
        }

        // Allow logout
        if ($request->routeIs('logout')) {
            return $next($request);
        }

        return redirect()->route('onboarding.create');
    }
}
