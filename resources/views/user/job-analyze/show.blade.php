@extends('user.layout')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <a href="{{ route('user.job-analyze.index') }}"
                            class="text-gray-600 hover:text-gray-800 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            Back to Analyses
                        </a>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('user.job-analyze.prepare-interview', $analysis) }}"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Prepare Interview
                        </a>
                        @if ($analysis->job && $analysis->job->slug)
                            <a href="{{ route('jobs.show', $analysis->job->slug) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                View Job Posting
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Job Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $analysis->job->job_title ?? 'Unknown Job' }}</h1>
                            <p class="text-lg text-gray-600 mb-1">{{ $analysis->job->company_name ?? 'Unknown Company' }}
                            </p>
                            <p class="text-sm text-gray-500">Analyzed {{ $analysis->created_at->format('F j, Y') }} at
                                {{ $analysis->created_at->format('g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <!-- Overall Match Score -->
                            <div
                                class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold
                            {{ $analysis->match_score >= 80 ? 'bg-green-100 text-green-800' : '' }}
                            {{ $analysis->match_score >= 60 && $analysis->match_score < 80 ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $analysis->match_score < 60 ? 'bg-red-100 text-red-800' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $analysis->match_score ?? ($analysis->confidence_score ?? 0) }}% Overall Match
                            </div>
                            @if ($analysis->file_name)
                                <p class="text-sm text-gray-500 mt-2">Resume: {{ $analysis->file_name }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Strengths -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Strengths</h3>
                        <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ count($analysis->analysis_results['strengths_assessment']['skill_matches'] ?? ($analysis->analysis_results['strengths'] ?? [])) }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @php
                            $strengths =
                                $analysis->analysis_results['strengths_assessment']['skill_matches'] ??
                                ($analysis->analysis_results['strengths'] ?? []);
                        @endphp
                        @forelse($strengths as $strength)
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $strength['skill'] ?? $strength }}</p>
                                    @if (is_array($strength) && isset($strength['description']))
                                        <p class="text-xs text-gray-600 mt-1">{{ $strength['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No specific strengths identified</p>
                        @endforelse
                    </div>
                </div>

                <!-- Gaps -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Skill Gaps</h3>
                        <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ count($analysis->analysis_results['gap_analysis']['missing_skills'] ?? ($analysis->analysis_results['gaps'] ?? [])) }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @php
                            $gaps =
                                $analysis->analysis_results['gap_analysis']['missing_skills'] ??
                                ($analysis->analysis_results['gaps'] ?? []);
                        @endphp
                        @forelse($gaps as $gap)
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-yellow-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $gap['skill'] ?? $gap }}</p>
                                    @if (is_array($gap) && isset($gap['importance']))
                                        <p class="text-xs text-gray-600 mt-1">Importance: {{ $gap['importance'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No significant skill gaps identified</p>
                        @endforelse
                    </div>
                </div>

                <!-- Weaknesses -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Areas for Improvement</h3>
                        <span class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ count($analysis->analysis_results['weaknesses'] ?? ($analysis->analysis_results['gap_analysis']['experience_gaps'] ?? [])) }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @php
                            $weaknesses =
                                $analysis->analysis_results['weaknesses'] ??
                                ($analysis->analysis_results['gap_analysis']['experience_gaps'] ?? []);
                        @endphp
                        @forelse($weaknesses as $weakness)
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $weakness['area'] ?? $weakness }}</p>
                                    @if (is_array($weakness) && isset($weakness['suggestion']))
                                        <p class="text-xs text-gray-600 mt-1">{{ $weakness['suggestion'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No specific weaknesses identified</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Detailed Analysis -->
            @if (!empty($analysis->analysis_results['detailed_analysis'] ?? $analysis->analysis_results['match_summary']))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Detailed Analysis</h3>
                    <div class="prose max-w-none">
                        {!! $analysis->analysis_results['detailed_analysis'] ?? $analysis->analysis_results['match_summary'] !!}
                    </div>
                </div>
            @endif

            <!-- Resume Optimization Suggestions -->
            @php
                $suggestions =
                    $analysis->analysis_results['suggestions'] ??
                    ($analysis->analysis_results['next_steps']['immediate_actions'] ?? []);
            @endphp
            @if (!empty($suggestions))
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Resume Optimization Suggestions</h3>
                    <div class="space-y-4">
                        @foreach ($suggestions as $suggestion)
                            <div class="flex items-start p-4 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $suggestion['title'] ?? 'Optimization Suggestion' }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $suggestion['description'] ?? $suggestion }}
                                    </p>
                                    @if (isset($suggestion['priority']))
                                        <span
                                            class="inline-block mt-2 px-2 py-1 text-xs font-medium rounded-full
                                    {{ $suggestion['priority'] == 'high' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $suggestion['priority'] == 'medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $suggestion['priority'] == 'low' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ ucfirst($suggestion['priority']) }} Priority
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ready to Prepare for Your Interview?</h3>
                        <p class="text-gray-600">Based on your analysis, we can generate targeted interview questions
                            focusing on your areas for improvement.</p>
                    </div>
                    <a href="{{ route('user.job-analyze.prepare-interview', $analysis) }}"
                        class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Generate Interview Questions
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
