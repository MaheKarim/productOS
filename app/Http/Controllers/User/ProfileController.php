<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Handle Password Update if current_password is set
        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Password updated successfully.');
        }

        // Handle Profile Update
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string'],
        ]);

        // Handle Avatar (Placeholder Logic - normally would be file upload)
        // If file given, would store and update 'avatar' field. 
        // For now, assuming no file logic in this quick step, but added to view.

        $user->update($validated);

        \App\Models\ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'Profile Updated',
            'description' => 'User updated their profile details.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
