@extends('user.layout')

@section('header', 'Dashboard')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Welcome Section -->
        <div class="relative overflow-hidden bg-slate-900 rounded-3xl p-8 md:p-10 shadow-2xl">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-blue-500 rounded-full blur-[100px] opacity-20">
            </div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-500 rounded-full blur-[100px] opacity-20">
            </div>

            <div class="relative z-10">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-white/10 text-white/80 text-xs font-semibold backdrop-blur-md border border-white/10 mb-4">
                    Beta Access
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Hello, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                </h2>
                <p class="text-slate-300 text-lg max-w-xl">
                    Welcome to your personal dashboard. Track your activity, manage your profile, and explore new tools.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('profile.edit') }}"
                        class="px-6 py-3 bg-white text-slate-900 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-lg shadow-white/10">
                        Edit Profile
                    </a>
                    <a href="{{ route('tools.index') }}"
                        class="px-6 py-3 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-colors border border-white/10 backdrop-blur-md">
                        Explore Tools
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Account Status -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <i class="fa-regular fa-id-badge text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Account Status</h3>
                <p class="text-slate-500 text-sm mt-1">Your current membership is active.</p>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase">Role</span>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
            </div>

            <!-- Join Date -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                    <i class="fa-regular fa-calendar-check text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Member Since</h3>
                <p class="text-slate-500 text-sm mt-1">You joined the platform securely.</p>
                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase">Date</span>
                    <span class="text-sm font-medium text-slate-900">
                        {{ Auth::user()->created_at->format('F d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Placeholder -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900">Recent Login Activity</h3>
                <span class="text-xs text-slate-400">Security Log</span>
            </div>
            <div class="bg-slate-50/50 p-8 text-center">
                <div
                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm">
                    <i class="fa-solid fa-shield-cat text-2xl"></i>
                </div>
                <p class="text-slate-600 font-medium">Activity Logging Enabled</p>
                <p class="text-sm text-slate-400 mt-1">Your account security is being monitored.</p>
            </div>
        </div>
    </div>
@endsection
