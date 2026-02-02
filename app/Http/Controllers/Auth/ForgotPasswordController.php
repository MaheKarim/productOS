<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password form.
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle sending the password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Rate limiting: 5 attempts per minute per IP
        $key = 'password-reset:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many reset attempts. Please try again in {$seconds} seconds.",
            ])->withInput();
        }

        RateLimiter::hit($key, 60);

        // Log the attempt
        \App\Models\ActivityLog::create([
            'user_id' => null,
            'action' => 'Password Reset Requested',
            'description' => "Password reset requested for: {$request->email}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // For security, don't reveal if email exists or not
        // Always show success message
        return back()->with('status', 'If an account with that email exists, we have sent a password reset link.');
    }
}
