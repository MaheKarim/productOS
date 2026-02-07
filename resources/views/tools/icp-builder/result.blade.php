@extends('user.layout')

@section('title', 'ICP Analysis — ' . $icp->project_name)

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .icp-result-container {
            font-family: 'Inter', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glass-card-light {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e2e8f0;
        }

        .gradient-text {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-ring {
            background: conic-gradient(#3B82F6 calc(var(--score) * 1%), #1e293b calc(var(--score) * 1%));
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.2);
        }

        .tag-pill {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .section-divider {
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.3), transparent);
        }
    </style>
@endpush

@section('content')
    <div class="icp-result-container min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header Section -->
            <header class="mb-10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('icp-builder.index') }}"
                            class="p-2 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-slate-900 hover:border-slate-300 transition-all cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $icp->project_name }}</h1>
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    Complete
                                </span>
                            </div>
                            <p class="text-slate-500 text-sm mt-1">Generated {{ $icp->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button onclick="window.print()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-slate-600 font-medium text-sm hover:bg-slate-50 hover:border-slate-300 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Export PDF
                        </button>
                        <a href="{{ route('icp-builder.create') }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium text-sm hover:from-blue-700 hover:to-indigo-700 transition-all cursor-pointer shadow-lg shadow-blue-500/25">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            New ICP
                        </a>
                    </div>
                </div>
            </header>

            @php
                $data = $icp->generated_icp ?? [];
            @endphp

            <!-- Score Hero Card -->
            <div
                class="mb-8 p-6 sm:p-8 rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 border border-slate-700/50 shadow-2xl">
                <div class="flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-10">
                    <!-- Score Ring -->
                    <div class="flex-shrink-0 relative">
                        <div class="w-28 h-28 rounded-full stat-ring flex items-center justify-center"
                            style="--score: {{ $data['icp_summary']['confidence_score'] ?? 75 }}">
                            <div class="w-24 h-24 rounded-full bg-slate-900 flex items-center justify-center">
                                <div class="text-center">
                                    <span
                                        class="text-3xl font-bold text-white">{{ $data['icp_summary']['confidence_score'] ?? 75 }}%</span>
                                    <span class="block text-xs text-slate-400 mt-0.5">Confidence</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-slate-400 mb-2">ICP Summary</h2>
                        <p class="text-xl sm:text-2xl font-medium text-white leading-relaxed">
                            "{{ $data['icp_summary']['one_liner'] ?? 'Your ideal customer profile analysis is ready.' }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Column 1: Firmographics + Negative ICP -->
                <div class="space-y-6">

                    <!-- Firmographics Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Firmographics</h3>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <span
                                    class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Industries</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($data['firmographics']['industry'] ?? [] as $ind)
                                        <span
                                            class="tag-pill px-3 py-1.5 rounded-full text-xs font-medium text-blue-700">{{ $ind }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Size</span>
                                    <p class="text-slate-900 font-semibold text-sm mt-1">
                                        {{ $data['firmographics']['company_size'] ?? 'N/A' }}</p>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <span
                                        class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Revenue</span>
                                    <p class="text-slate-900 font-semibold text-sm mt-1">
                                        {{ $data['firmographics']['revenue_range'] ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div>
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Geography</span>
                                <p class="text-slate-700 font-medium text-sm mt-1">
                                    {{ implode(', ', $data['firmographics']['geography'] ?? ['Global']) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Negative ICP Card -->
                    <div
                        class="rounded-2xl p-6 bg-gradient-to-br from-red-50 to-orange-50 border border-red-100 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-red-900">Avoid These</h3>
                        </div>

                        <ul class="space-y-2.5">
                            @foreach ($data['negative_icp']['avoid_industries'] ?? [] as $avoid)
                                <li class="flex items-start gap-2.5 text-red-700 text-sm">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ $avoid }}
                                </li>
                            @endforeach
                            @foreach ($data['negative_icp']['avoid_company_types'] ?? [] as $avoid)
                                <li class="flex items-start gap-2.5 text-red-700 text-sm">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-red-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ $avoid }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Column 2: Personas + Pain Points -->
                <div class="space-y-6">

                    <!-- Buyer Personas Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Buyer Personas</h3>
                        </div>

                        <div class="space-y-4">
                            @foreach ($data['buyer_personas'] ?? [] as $persona)
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-start justify-between mb-2">
                                        <h4 class="font-bold text-slate-900">{{ $persona['role'] }}</h4>
                                        <span
                                            class="text-xs px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md font-medium border border-indigo-200">
                                            {{ $persona['decision_power'] ?? 'Key' }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mb-2">{{ $persona['seniority'] ?? '' }}</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($persona['job_titles'] ?? [] as $title)
                                            <span
                                                class="text-[10px] bg-white text-slate-600 px-2 py-1 rounded border border-slate-200">{{ $title }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pain Points Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Pain Points</h3>
                        </div>

                        <ul class="space-y-3">
                            @foreach ($data['pain_points'] ?? [] as $pain)
                                <li class="flex items-start gap-3 text-slate-700 text-sm">
                                    <span
                                        class="w-2 h-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 mt-1.5 flex-shrink-0"></span>
                                    {{ $pain }}
                                </li>
                            @endforeach
                        </ul>

                        @if (!empty($data['jobs_to_be_done']))
                            <div class="section-divider h-px my-5"></div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Jobs to be Done</h4>
                            <ul class="space-y-3">
                                @foreach ($data['jobs_to_be_done'] ?? [] as $job)
                                    <li class="flex items-start gap-3 text-slate-700 text-sm">
                                        <span
                                            class="w-2 h-2 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 mt-1.5 flex-shrink-0"></span>
                                        {{ $job }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <!-- Column 3: GTM + Fit Scoring + Intel -->
                <div class="space-y-6">

                    <!-- GTM Strategy Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">GTM Strategy</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="p-3 rounded-xl bg-purple-50 border border-purple-100">
                                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Sales
                                    Motion</span>
                                <p class="text-purple-900 font-bold text-sm mt-1">
                                    {{ $data['gtm_recommendation']['sales_motion'] ?? 'Consultative' }}</p>
                            </div>

                            <div>
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Best
                                    Channels</span>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach ($data['gtm_recommendation']['best_channels'] ?? [] as $channel)
                                        <span
                                            class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">{{ $channel }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Messaging
                                    Angle</span>
                                <p class="text-slate-700 text-sm mt-2 italic leading-relaxed">
                                    "{{ $data['gtm_recommendation']['messaging_angle'] ?? 'Focus on ROI and efficiency gains.' }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Fit Scoring Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Fit Scoring</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4
                                    class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Good Fit Signals
                                </h4>
                                <ul class="space-y-1.5">
                                    @foreach ($data['fit_scoring_logic']['good_fit_criteria'] ?? [] as $criteria)
                                        <li class="text-xs text-slate-600 pl-4 border-l-2 border-emerald-300">
                                            {{ $criteria }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="section-divider h-px"></div>

                            <div>
                                <h4
                                    class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Bad Fit Signals
                                </h4>
                                <ul class="space-y-1.5">
                                    @foreach ($data['fit_scoring_logic']['bad_fit_criteria'] ?? [] as $criteria)
                                        <li class="text-xs text-slate-600 pl-4 border-l-2 border-red-300">
                                            {{ $criteria }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buying Intel Card -->
                    <div class="glass-card-light rounded-2xl p-6 hover-lift">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Buying Intel</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-green-50 border border-green-100 text-center">
                                <span class="text-xs font-semibold text-green-600 uppercase tracking-wider">Budget</span>
                                <p class="text-green-900 font-bold text-lg mt-1">
                                    {{ $data['budget_expectation'] ?? 'TBD' }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 text-center">
                                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Cycle</span>
                                <p class="text-blue-900 font-bold text-lg mt-1">
                                    {{ $data['sales_cycle_estimate'] ?? 'TBD' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
