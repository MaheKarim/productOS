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
                    <a href="{{ route('roadmap.index') }}"
                        class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold rounded-xl hover:from-yellow-500 hover:to-orange-600 transition-colors shadow-lg shadow-orange-500/20 flex items-center gap-2">
                        <i class="fa-solid fa-map"></i> My Roadmap
                    </a>
                </div>
            </div>
        </div>



        <!-- PM Roadmap Progress -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Your PM Roadmap Progress</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Track your Product Manager skill development</p>
                </div>
                <a href="{{ route('roadmap.index') }}" class="text-indigo-600 text-sm font-semibold hover:underline">View
                    Full Roadmap →</a>
            </div>
            <div class="p-6">
                <livewire:roadmap.analytics />
            </div>
        </div>
    </div>
@endsection
