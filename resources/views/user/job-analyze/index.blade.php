@extends('user.layout')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8" x-data="jobAnalyzePage()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Job Analysis</h1>
                        <p class="mt-2 text-gray-600">Analyze your resume against job postings to identify strengths, gaps,
                            and optimization opportunities.</p>
                    </div>
                    <a href="/jobs"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4"></path>
                        </svg>
                        Browse Jobs
                    </a>
                </div>
            </div>

            <!-- Selected Job for Analysis -->
            @if ($selectedJob)
                <div class="bg-white rounded-lg shadow-sm border border-purple-200 p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-14 h-14 rounded-xl bg-purple-100 border border-purple-200 flex items-center justify-center text-purple-700 font-bold text-xl flex-shrink-0">
                            {{ strtoupper(substr($selectedJob->company_name ?? 'C', 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-gray-900">{{ $selectedJob->job_title }}</h2>
                            <p class="text-gray-600">{{ $selectedJob->company_name }} •
                                {{ $selectedJob->location ?? 'Remote' }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @if ($selectedJob->job_type)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $selectedJob->job_type }}
                                    </span>
                                @endif
                                @if ($selectedJob->experience_level)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $selectedJob->experience_level }}
                                    </span>
                                @endif
                                @if ($selectedJob->salary_range)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $selectedJob->salary_range }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" @click="performAnalysis({{ $selectedJob->id }})" :disabled="analyzing"
                                class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-bold rounded-lg hover:bg-purple-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg x-show="!analyzing" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                                <svg x-show="analyzing" class="w-5 h-5 mr-2 animate-spin" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span x-text="analyzing ? 'Analyzing...' : 'Analyze This Job'"></span>
                            </button>
                        </div>
                    </div>
                    @if ($selectedJob->job_details)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-600 line-clamp-3">{{ Str::limit($selectedJob->job_details, 300) }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Inline Analysis Results -->
                <div x-show="analysisResult" x-cloak class="mb-6">
                    <div class="bg-white rounded-lg shadow-sm border border-green-200 overflow-hidden">
                        <!-- Analysis Header -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-green-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Analysis Complete</h3>
                                        <p class="text-sm text-gray-600">Your resume has been analyzed against this job</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold"
                                        :class="getScoreColor(analysisResult?.overall_match_score)">
                                        <span x-text="analysisResult?.overall_match_score || 0"></span>%
                                    </div>
                                    <p class="text-sm text-gray-500">Match Score</p>
                                </div>
                            </div>
                        </div>

                        <!-- Analysis Content -->
                        <div class="p-6">
                            <!-- Match Summary -->
                            <div class="mb-6" x-show="analysisResult?.match_summary">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Summary</h4>
                                <p class="text-gray-600" x-text="analysisResult?.match_summary"></p>
                            </div>

                            <!-- Strengths -->
                            <div class="mb-6" x-show="analysisResult?.strengths_assessment?.skill_matches?.length">
                                <h4 class="text-sm font-semibold text-green-700 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Strengths
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <template
                                        x-for="(strength, index) in analysisResult?.strengths_assessment?.skill_matches"
                                        :key="index">
                                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                            <div class="flex items-center justify-between">
                                                <span class="font-medium text-green-800" x-text="strength.skill"></span>
                                                <span class="text-xs px-2 py-1 rounded-full"
                                                    :class="strength.proficiency === 'high' ?
                                                        'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800'"
                                                    x-text="strength.proficiency"></span>
                                            </div>
                                            <p class="text-sm text-green-600 mt-1" x-text="strength.evidence"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Gaps -->
                            <div class="mb-6" x-show="analysisResult?.gap_analysis?.missing_skills?.length">
                                <h4 class="text-sm font-semibold text-yellow-700 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Skill Gaps
                                </h4>
                                <div class="space-y-2">
                                    <template x-for="(gap, index) in analysisResult?.gap_analysis?.missing_skills"
                                        :key="index">
                                        <div class="bg-yellow-50 rounded-lg p-3 border border-yellow-100">
                                            <div class="flex items-center justify-between">
                                                <span class="font-medium text-yellow-800" x-text="gap.skill"></span>
                                                <span class="text-xs px-2 py-1 rounded-full"
                                                    :class="gap.importance === 'critical' ? 'bg-red-200 text-red-800' :
                                                        'bg-yellow-200 text-yellow-800'"
                                                    x-text="gap.importance"></span>
                                            </div>
                                            <p class="text-sm text-yellow-600 mt-1" x-text="gap.suggestion"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Next Steps -->
                            <div x-show="analysisResult?.next_steps?.immediate_actions?.length">
                                <h4 class="text-sm font-semibold text-indigo-700 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Recommended Next Steps
                                </h4>
                                <ul class="space-y-2">
                                    <template x-for="(action, index) in analysisResult?.next_steps?.immediate_actions"
                                        :key="index">
                                        <li class="flex items-start gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-indigo-500 mt-0.5 flex-shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span x-text="action"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div x-show="errorMessage" x-cloak class="mb-6">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-medium text-red-800">Analysis Failed</p>
                            <p class="text-sm text-red-600" x-text="errorMessage"></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Loading State -->
            <div x-show="loading" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 text-center">
                    <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <p class="text-gray-600">Loading analysis...</p>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" action="{{ route('user.job-analyze.index') }}" x-on:submit="loading = true"
                    class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Jobs</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Search by job title, company, or keywords...">
                        </div>
                        <div>
                            <label for="date_range" class="block text-sm font-medium text-gray-700 mb-2">Date
                                Range</label>
                            <select name="date_range" id="date_range"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Time</option>
                                <option value="7" {{ request('date_range') == '7' ? 'selected' : '' }}>Last 7 Days
                                </option>
                                <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Last 30 Days
                                </option>
                                <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>Last 90 Days
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="match_score" class="block text-sm font-medium text-gray-700 mb-2">Match
                                Score</label>
                            <select name="match_score" id="match_score"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Scores</option>
                                <option value="80-100" {{ request('match_score') == '80-100' ? 'selected' : '' }}>
                                    Excellent
                                    (80-100%)</option>
                                <option value="60-79" {{ request('match_score') == '60-79' ? 'selected' : '' }}>Good
                                    (60-79%)</option>
                                <option value="40-59" {{ request('match_score') == '40-59' ? 'selected' : '' }}>Fair
                                    (40-59%)</option>
                                <option value="0-39" {{ request('match_score') == '0-39' ? 'selected' : '' }}>Needs
                                    Improvement (0-39%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Search
                            </button>
                            <a href="{{ route('user.job-analyze.index') }}"
                                class="text-gray-600 hover:text-gray-800 transition-colors">Clear Filters</a>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $analyses->total() }} analysis{{ $analyses->total() !== 1 ? 'es' : '' }} found
                        </div>
                    </div>
                </form>
            </div>

            <!-- Analysis Results -->
            <div class="space-y-6">
                @forelse($analyses as $analysis)
                    <div
                        class="analysis-card bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-200 hover:border-indigo-200">
                        <div class="p-6">
                            <!-- Job Header -->
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-1 truncate">
                                        {{ $analysis->job->job_title ?? 'Unknown Job' }}</h3>
                                    <p class="text-gray-600">{{ $analysis->job->company_name ?? 'Unknown Company' }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Analyzed
                                        {{ $analysis->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <!-- Match Score -->
                                    @php
                                        $matchScore =
                                            $analysis->match_score ??
                                            ($analysis->confidence_score ??
                                                ($analysis->analysis_results['overall_match_score'] ?? 0));
                                    @endphp
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $matchScore >= 80 ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $matchScore >= 60 && $matchScore < 80 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $matchScore < 60 ? 'bg-red-100 text-red-800' : '' }}">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $matchScore }}% Match
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                <div class="bg-green-50 rounded-lg p-4 hover:bg-green-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-green-800">Strengths</p>
                                            <p class="text-lg font-semibold text-green-900">
                                                {{ count($analysis->analysis_results['strengths_assessment']['skill_matches'] ?? ($analysis->analysis_results['strengths'] ?? [])) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-yellow-50 rounded-lg p-4 hover:bg-yellow-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-yellow-800">Gaps</p>
                                            <p class="text-lg font-semibold text-yellow-900">
                                                {{ count($analysis->analysis_results['gap_analysis']['missing_skills'] ?? ($analysis->analysis_results['gaps'] ?? [])) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4 hover:bg-red-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-red-800">Weaknesses</p>
                                            <p class="text-lg font-semibold text-red-900">
                                                {{ count($analysis->analysis_results['weaknesses'] ?? ($analysis->analysis_results['gap_analysis']['experience_gaps'] ?? [])) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                    <a href="{{ route('user.job-analyze.show', $analysis) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        View Detailed Analysis
                                    </a>
                                    @if (count(
                                            $analysis->analysis_results['weaknesses'] ??
                                                ($analysis->analysis_results['gap_analysis']['experience_gaps'] ?? [])) > 0)
                                        <a href="{{ route('user.job-analyze.prepare-interview', $analysis) }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Prepare Interview
                                        </a>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 text-right">
                                    @if ($analysis->resume)
                                        <div class="font-medium">{{ $analysis->resume->file_name }}</div>
                                        <div class="text-xs text-gray-400">Resume used</div>
                                    @elseif($analysis->file_name)
                                        <div class="font-medium">{{ $analysis->file_name }}</div>
                                        <div class="text-xs text-gray-400">Resume used</div>
                                    @else
                                        <div class="font-medium text-gray-400">Resume on file</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Job Analyses Yet</h3>
                        <p class="text-gray-600 mb-6">Start analyzing your resume against job postings to see how well you
                            match.</p>
                        <a href="/jobs"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Browse Jobs
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($analyses->hasPages())
                <div class="mt-8">
                    {{ $analyses->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function jobAnalyzePage() {
            return {
                loading: false,
                analyzing: false,
                analysisResult: null,
                errorMessage: null,

                performAnalysis(jobId) {
                    this.analyzing = true;
                    this.errorMessage = null;
                    this.analysisResult = null;

                    fetch('{{ route('user.job-analyze.perform-analysis') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                job_id: jobId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.analyzing = false;
                            if (data.success) {
                                this.analysisResult = data.analysis;
                                // Scroll to results
                                setTimeout(() => {
                                    document.querySelector('[x-show="analysisResult"]')?.scrollIntoView({
                                        behavior: 'smooth'
                                    });
                                }, 100);
                            } else {
                                this.errorMessage = data.message || 'An error occurred during analysis.';
                                if (data.redirect) {
                                    setTimeout(() => {
                                        window.location.href = data.redirect;
                                    }, 2000);
                                }
                            }
                        })
                        .catch(error => {
                            this.analyzing = false;
                            this.errorMessage = 'An unexpected error occurred. Please try again.';
                            console.error('Analysis error:', error);
                        });
                },

                getScoreColor(score) {
                    if (score >= 80) return 'text-green-600';
                    if (score >= 60) return 'text-yellow-600';
                    return 'text-red-600';
                }
            }
        }
    </script>
@endsection
