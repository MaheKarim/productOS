@extends('user.layout')

@section('header', 'Dashboard')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">
        @inject('featureService', 'App\Services\FeatureAccessService')

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
                    <a href="{{ route('feedback.dashboard') }}"
                        class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
                        <i class="fas fa-comment-dots mr-2"></i>
                        My Feedback
                    </a>
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

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Strategic Roadmap -->
            @php $roadmapStatus = $featureService->checkAccess(Auth::user(), 'strategic_roadmap'); @endphp
            <a href="{{ $roadmapStatus['status'] === 'inactive' ? '#' : route('user.strategic-roadmap.index') }}"
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group relative overflow-hidden {{ $roadmapStatus['status'] === 'inactive' ? 'opacity-70 cursor-not-allowed' : '' }}">
                @if ($roadmapStatus['status'] === 'inactive')
                    <div
                        class="absolute top-2 right-2 bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                        Coming Soon</div>
                @else
                    <div
                        class="absolute top-2 right-2 {{ ($roadmapStatus['feature']->credit_cost ?? 0) == -1 ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }} text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1 border {{ ($roadmapStatus['feature']->credit_cost ?? 0) == -1 ? 'border-green-100' : 'border-amber-100' }}">
                        @if (($roadmapStatus['feature']->credit_cost ?? 0) == -1)
                            <i class="fa-solid fa-infinity"></i>
                            Unlimited
                        @else
                            <i class="fa-solid fa-coins"></i>
                            {{ $roadmapStatus['feature']->credit_cost ?? ($roadmapStatus['cost'] ?? 0) }}
                        @endif
                    </div>
                @endif
                <div
                    class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-1">Strategic Roadmap</h3>
                <p class="text-sm text-slate-500">Plan your career path with AI-driven insights.</p>
            </a>

            <!-- Resume Builder -->
            @php $resumeStatus = $featureService->checkAccess(Auth::user(), 'resume_builder'); @endphp
            <a href="{{ $resumeStatus['status'] === 'inactive' ? '#' : route('resume-builder.index') }}"
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group relative overflow-hidden {{ $resumeStatus['status'] === 'inactive' ? 'opacity-70 cursor-not-allowed' : '' }}">
                @if ($resumeStatus['status'] === 'inactive')
                    <div
                        class="absolute top-2 right-2 bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                        Coming Soon</div>
                @else
                    <div
                        class="absolute top-2 right-2 {{ ($resumeStatus['feature']->credit_cost ?? 0) == -1 ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }} text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1 border {{ ($resumeStatus['feature']->credit_cost ?? 0) == -1 ? 'border-green-100' : 'border-amber-100' }}">
                        @if (($resumeStatus['feature']->credit_cost ?? 0) == -1)
                            <i class="fa-solid fa-infinity"></i>
                            Unlimited
                        @else
                            <i class="fa-solid fa-coins"></i>
                            {{ $resumeStatus['feature']->credit_cost ?? ($resumeStatus['cost'] ?? 0) }}
                        @endif
                    </div>
                @endif
                <div
                    class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-file-contract text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-1">Resume Builder</h3>
                <p class="text-sm text-slate-500">Create ATS-friendly resumes in minutes.</p>
            </a>

            <!-- Interview Prep -->
            @php $interviewStatus = $featureService->checkAccess(Auth::user(), 'interview_prep'); @endphp
            <a href="{{ $interviewStatus['status'] === 'inactive' ? '#' : route('user.interview-prep.index') }}"
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group relative overflow-hidden {{ $interviewStatus['status'] === 'inactive' ? 'opacity-70 cursor-not-allowed' : '' }}">
                @if ($interviewStatus['status'] === 'inactive')
                    <div
                        class="absolute top-2 right-2 bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                        Coming Soon</div>
                @else
                    <div
                        class="absolute top-2 right-2 {{ ($interviewStatus['feature']->credit_cost ?? 0) == -1 ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }} text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1 border {{ ($interviewStatus['feature']->credit_cost ?? 0) == -1 ? 'border-green-100' : 'border-amber-100' }}">
                        @if (($interviewStatus['feature']->credit_cost ?? 0) == -1)
                            <i class="fa-solid fa-infinity"></i>
                            Unlimited
                        @else
                            <i class="fa-solid fa-coins"></i>
                            {{ $interviewStatus['feature']->credit_cost ?? ($interviewStatus['cost'] ?? 0) }}
                        @endif
                    </div>
                @endif
                <div
                    class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clipboard-question text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-1">Interview Prep</h3>
                <p class="text-sm text-slate-500">Practice with AI-generated questions.</p>
            </a>
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
                                <th class="px-6 py-3 text-center">Progress</th>
                                <th class="px-6 py-3 text-center">Results</th>
                                <th class="px-6 py-3 text-center">Score</th>
                                <th class="px-6 py-3 text-right">Duration</th>
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
                                        <div class="flex flex-col items-center">
                                            <span
                                                class="text-slate-900 font-bold text-sm">{{ $session->attempted_questions }}
                                                <span class="text-slate-400 font-normal">/
                                                    {{ $session->total_questions }}</span></span>
                                            <span
                                                class="text-[10px] text-slate-400 uppercase tracking-wide">Attempted</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-4">
                                            <div class="flex flex-col items-center">
                                                <span
                                                    class="text-green-600 font-bold text-sm">{{ $session->correct_answers }}</span>
                                                <span class="text-[10px] text-green-600/70 font-medium">Pass</span>
                                            </div>
                                            <div class="w-px h-6 bg-slate-200"></div>
                                            <div class="flex flex-col items-center">
                                                <span
                                                    class="text-red-500 font-bold text-sm">{{ $session->attempted_questions - $session->correct_answers }}</span>
                                                <span class="text-[10px] text-red-500/70 font-medium">Fail</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-slate-900 font-bold text-sm">
                                                {{ $session->correct_answers }} <span class="text-slate-400 font-normal">/
                                                    {{ $session->attempted_questions }}</span>
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide
                                                {{ $session->score >= 80
                                                    ? 'bg-green-100 text-green-700'
                                                    : ($session->score >= 50
                                                        ? 'bg-amber-100 text-amber-700'
                                                        : 'bg-red-100 text-red-700') }}">
                                                {{ number_format($session->score, 0) }}% Score
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate-500">
                                        @php
                                            $minutes = floor($session->duration_seconds / 60);
                                            $seconds = $session->duration_seconds % 60;
                                        @endphp
                                        {{ $minutes }}m {{ $seconds }}s
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
