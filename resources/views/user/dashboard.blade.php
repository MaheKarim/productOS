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
        @if (isset($interviewSessions) && $interviewSessions->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-8">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900">Recent Interview Sessions</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Your latest practice performance</p>
                    </div>
                    <a href="{{ route('user.interview-prep.index') }}"
                        class="text-indigo-600 text-sm font-semibold hover:underline">
                        Start New Session →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-xs border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3 text-center">Questions</th>
                                <th class="px-6 py-3 text-center">Score</th>
                                <th class="px-6 py-3 text-center">Duration</th>
                                <th class="px-6 py-3 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($interviewSessions as $session)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        {{ $session->completed_at->format('M d, Y') }}
                                        <div class="text-xs text-slate-400 font-normal">
                                            {{ $session->completed_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-slate-700 font-bold">{{ $session->correct_answers }}</span>
                                        <span class="text-slate-400">/ {{ $session->attempted_questions }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold
                                            {{ $session->score >= 80
                                                ? 'bg-green-100 text-green-700'
                                                : ($session->score >= 50
                                                    ? 'bg-amber-100 text-amber-700'
                                                    : 'bg-red-100 text-red-700') }}">
                                            {{ number_format($session->score, 0) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-slate-500">
                                        {{ gmdate('i:s', $session->duration_seconds) }}m
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

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
