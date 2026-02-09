@extends('user.layout')

@section('title', 'Resume Analysis - ' . $job->job_title)
@section('header', 'Resume Analysis')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        {{-- Header Section --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 mb-2">Resume Analysis Results</h1>
                    <p class="text-slate-600">Comprehensive analysis of your resume against the job posting</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-slate-500 mb-1">Overall Match Score</div>
                    <div class="text-3xl font-bold text-purple-600">{{ $analysis['overall_match_score'] ?? 0 }}%</div>
                </div>
            </div>

            {{-- Job Info Card --}}
            <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 font-bold text-lg">
                        {{ strtoupper(substr($job->company_name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-slate-900">{{ $job->job_title }}</h2>
                        <p class="text-slate-600">{{ $job->company_name }}</p>
                        <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                            <span><i data-lucide="map-pin" class="w-4 h-4 inline mr-1"></i>{{ $job->location ?? 'Remote' }}</span>
                            <span><i data-lucide="briefcase" class="w-4 h-4 inline mr-1"></i>{{ $job->job_type }}</span>
                        </div>
                    </div>
                    <a href="{{ route('jobs.show', $job->slug) }}" 
                       class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors text-sm font-medium">
                        View Job Posting
                    </a>
                </div>
            </div>

            {{-- Match Summary --}}
            @if(!empty($analysis['match_summary']))
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <h3 class="font-semibold text-blue-900 mb-2">Analysis Summary</h3>
                    <p class="text-blue-800">{{ $analysis['match_summary'] }}</p>
                </div>
            @endif
        </div>

        {{-- Analysis Results Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Strengths Assessment --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Strengths Assessment</h3>
                </div>

                @if(!empty($analysis['strengths_assessment']['skill_matches']))
                    <div class="mb-6">
                        <h4 class="font-semibold text-slate-800 mb-3">Skill Matches</h4>
                        @foreach($analysis['strengths_assessment']['skill_matches'] as $skill)
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg mb-2">
                                <span class="font-medium text-slate-800">{{ $skill['skill'] }}</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-200 text-green-800">
                                    {{ ucfirst($skill['proficiency']) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($analysis['strengths_assessment']['relevant_experience']))
                    <div class="mb-6">
                        <h4 class="font-semibold text-slate-800 mb-3">Relevant Experience</h4>
                        @foreach($analysis['strengths_assessment']['relevant_experience'] as $exp)
                            <div class="p-3 bg-green-50 rounded-lg mb-2">
                                <p class="text-slate-800">{{ $exp['experience'] }}</p>
                                <p class="text-sm text-green-700 mt-1">Relevance: {{ ucfirst($exp['relevance']) }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($analysis['strengths_assessment']['achievements_aligned']))
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-3">Aligned Achievements</h4>
                        @foreach($analysis['strengths_assessment']['achievements_aligned'] as $achievement)
                            <div class="p-3 bg-green-50 rounded-lg mb-2">
                                <p class="text-slate-800">{{ $achievement['achievement'] }}</p>
                                <p class="text-sm text-green-700 mt-1">{{ $achievement['alignment'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Gap Analysis --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Gap Analysis</h3>
                </div>

                @if(!empty($analysis['gap_analysis']['missing_skills']))
                    <div class="mb-6">
                        <h4 class="font-semibold text-slate-800 mb-3">Missing Skills</h4>
                        @foreach($analysis['gap_analysis']['missing_skills'] as $skill)
                            <div class="p-3 bg-orange-50 rounded-lg mb-2 border-l-4 border-orange-400">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-medium text-slate-800">{{ $skill['skill'] }}</span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($skill['importance'] === 'critical') bg-red-200 text-red-800
                                        @elseif($skill['importance'] === 'important') bg-orange-200 text-orange-800
                                        @else bg-yellow-200 text-yellow-800 @endif">
                                        {{ ucfirst($skill['importance']) }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-600">{{ $skill['suggestion'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($analysis['gap_analysis']['missing_qualifications']))
                    <div class="mb-6">
                        <h4 class="font-semibold text-slate-800 mb-3">Missing Qualifications</h4>
                        @foreach($analysis['gap_analysis']['missing_qualifications'] as $qual)
                            <div class="p-3 bg-orange-50 rounded-lg mb-2">
                                <p class="font-medium text-slate-800">{{ $qual['qualification'] }}</p>
                                <p class="text-sm text-slate-600 mt-1">{{ $qual['suggestion'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(!empty($analysis['gap_analysis']['experience_gaps']))
                    <div>
                        <h4 class="font-semibold text-slate-800 mb-3">Experience Gaps</h4>
                        @foreach($analysis['gap_analysis']['experience_gaps'] as $gap)
                            <div class="p-3 bg-orange-50 rounded-lg mb-2">
                                <p class="font-medium text-slate-800">{{ $gap['area'] }}</p>
                                <p class="text-sm text-slate-600">Current: {{ $gap['current'] }} | Required: {{ $gap['required'] }}</p>
                                <p class="text-sm text-orange-700 mt-1">{{ $gap['gap'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Optimization Suggestions --}}
        @if(!empty($analysis['resume_optimization_suggestions']))
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Resume Optimization Suggestions</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if(!empty($analysis['resume_optimization_suggestions']['keyword_optimizations']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Keyword Optimizations</h4>
                            @foreach($analysis['resume_optimization_suggestions']['keyword_optimizations'] as $keyword)
                                <div class="p-3 bg-blue-50 rounded-lg mb-2">
                                    <p class="font-medium text-slate-800">{{ $keyword['keyword'] }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $keyword['recommended_usage'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($analysis['resume_optimization_suggestions']['content_recommendations']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Content Recommendations</h4>
                            @foreach($analysis['resume_optimization_suggestions']['content_recommendations'] as $rec)
                                <div class="p-3 bg-blue-50 rounded-lg mb-2">
                                    <p class="font-medium text-slate-800">{{ $rec['section'] }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $rec['recommended_change'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($analysis['resume_optimization_suggestions']['formatting_improvements']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Formatting Improvements</h4>
                            @foreach($analysis['resume_optimization_suggestions']['formatting_improvements'] as $improvement)
                                <div class="p-3 bg-blue-50 rounded-lg mb-2">
                                    <p class="font-medium text-slate-800">{{ $improvement['aspect'] }}</p>
                                    <p class="text-sm text-slate-600 mt-1">{{ $improvement['improvement'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Interview Prep Integration --}}
        @if(!empty($analysis['interview_prep_focus_areas']))
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl border border-purple-200 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="mic" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Interview Preparation</h3>
                    </div>
                    <a href="{{ route('user.interview-prep.index') }}" 
                       class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors font-bold shadow-lg shadow-purple-600/20">
                        <i data-lucide="arrow-right" class="w-4 h-4 inline mr-2"></i>
                        Start Interview Prep
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(!empty($analysis['interview_prep_focus_areas']['strengths_to_emphasize']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
                                <i data-lucide="star" class="w-4 h-4 text-green-600"></i>
                                Strengths to Emphasize
                            </h4>
                            <ul class="space-y-2">
                                @foreach($analysis['interview_prep_focus_areas']['strengths_to_emphasize'] as $strength)
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-green-600 mt-0.5 flex-shrink-0"></i>
                                        <span class="text-slate-700">{{ $strength }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($analysis['interview_prep_focus_areas']['weaknesses_to_address']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-orange-600"></i>
                                Weaknesses to Address
                            </h4>
                            <ul class="space-y-2">
                                @foreach($analysis['interview_prep_focus_areas']['weaknesses_to_address'] as $weakness)
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="circle" class="w-4 h-4 text-orange-600 mt-0.5 flex-shrink-0"></i>
                                        <span class="text-slate-700">{{ $weakness }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($analysis['interview_prep_focus_areas']['key_stories_to_prepare']))
                        <div class="md:col-span-2">
                            <h4 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
                                <i data-lucide="book-open" class="w-4 h-4 text-blue-600"></i>
                                Key Stories to Prepare
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($analysis['interview_prep_focus_areas']['key_stories_to_prepare'] as $story)
                                    <div class="p-4 bg-white rounded-lg border border-slate-200">
                                        <p class="font-medium text-slate-800 mb-2">{{ $story['story'] }}</p>
                                        <p class="text-sm text-slate-600">{{ $story['relevance'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Next Steps --}}
        @if(!empty($analysis['next_steps']))
            <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="target" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Next Steps</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if(!empty($analysis['next_steps']['immediate_actions']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Immediate Actions</h4>
                            <ul class="space-y-2">
                                @foreach($analysis['next_steps']['immediate_actions'] as $action)
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="arrow-right" class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0"></i>
                                        <span class="text-slate-700">{{ $action }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!empty($analysis['next_steps']['long_term_improvements']))
                        <div>
                            <h4 class="font-semibold text-slate-800 mb-3">Long-term Improvements</h4>
                            <ul class="space-y-2">
                                @foreach($analysis['next_steps']['long_term_improvements'] as $improvement)
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="calendar" class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0"></i>
                                        <span class="text-slate-700">{{ $improvement }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('resume-builder.index') }}" 
               class="px-6 py-3 bg-slate-200 text-slate-800 rounded-xl hover:bg-slate-300 transition-colors font-medium">
                <i data-lucide="upload" class="w-4 h-4 inline mr-2"></i>
                Upload New Resume
            </a>
            <a href="{{ route('jobs.index') }}" 
               class="px-6 py-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors font-medium">
                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                Browse More Jobs
            </a>
            @if(!empty($analysis['next_steps']['interview_preparation_priority']) && $analysis['next_steps']['interview_preparation_priority'] === 'high')
                <a href="{{ route('user.interview-prep.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl hover:from-purple-700 hover:to-blue-700 transition-colors font-bold shadow-lg">
                    <i data-lucide="zap" class="w-4 h-4 inline mr-2"></i>
                    Priority Interview Prep
                </a>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
@endpush