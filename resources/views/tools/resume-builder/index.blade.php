@extends('user.layout')

@section('title', 'ATS Resume Analyzer')

@section('content')
    <script>
        function resumeAnalyzer() {
            return {
                // Analyzer state
                isAnalyzing: false,
                analysisComplete: false,
                analysisResult: null,
                analyzerFileName: '',

                async analyzeResume(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    this.isAnalyzing = true;
                    this.analysisComplete = false;
                    this.analysisResult = null;
                    this.analyzerFileName = file.name;

                    const formData = new FormData();
                    formData.append('resume', file);

                    try {
                        const response = await fetch('{{ route('resume-builder.analyze') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.analysisResult = result.analysis;
                            this.analysisComplete = true;
                            setTimeout(() => {
                                document.getElementById('analysis-results')?.scrollIntoView({
                                    behavior: 'smooth'
                                });
                            }, 100);
                        } else {
                            alert('Analysis failed: ' + (result.message || 'Unknown error'));
                        }
                    } catch (err) {
                        alert('Analysis error: ' + err.message);
                    } finally {
                        this.isAnalyzing = false;
                    }
                },

                getScoreColor(score) {
                    if (score >= 80) return '#10b981';
                    if (score >= 60) return '#f59e0b';
                    if (score >= 40) return '#f97316';
                    return '#ef4444';
                },

                getScoreLabel(score) {
                    if (score >= 80) return 'Excellent';
                    if (score >= 60) return 'Good';
                    if (score >= 40) return 'Needs Work';
                    return 'Poor';
                },

                getPriorityColor(priority) {
                    if (priority === 'critical') return 'bg-red-100 text-red-700 border-red-200';
                    if (priority === 'important') return 'bg-amber-100 text-amber-700 border-amber-200';
                    return 'bg-blue-100 text-blue-700 border-blue-200';
                },

                getSeverityColor(severity) {
                    if (severity === 'high') return 'text-red-600';
                    if (severity === 'medium') return 'text-amber-600';
                    return 'text-blue-600';
                },

                resetAnalysis() {
                    this.analysisComplete = false;
                    this.analysisResult = null;
                    this.analyzerFileName = '';
                }
            }
        }
    </script>

    <div class="relative min-h-screen py-8" x-data="resumeAnalyzer()">

        <!-- Ambient Background Elements -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div
                class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-emerald-200/40 rounded-full blur-[100px] opacity-60 mix-blend-multiply animate-blob">
            </div>
            <div
                class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-teal-200/40 rounded-full blur-[100px] opacity-60 mix-blend-multiply animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-32 left-20 w-[600px] h-[600px] bg-cyan-200/40 rounded-full blur-[120px] opacity-50 mix-blend-multiply animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    AI-Powered Career Tools
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    ATS Resume <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">Analyzer</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Get instant AI-powered feedback on your resume's ATS compatibility, missing sections, and actionable
                    recommendations.
                </p>
            </div>

            <!-- Upload Section -->
            <div x-show="!analysisComplete" class="relative bg-white rounded-3xl p-8 border border-slate-200 shadow-xl">
                <div class="text-center mb-8">
                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Upload Your Resume</h2>
                    <p class="text-slate-500">Get instant AI-powered ATS compatibility analysis</p>
                </div>

                <label
                    class="relative flex flex-col items-center justify-center w-full h-48 rounded-2xl border-2 border-dashed cursor-pointer transition-all duration-300"
                    :class="isAnalyzing ? 'border-emerald-500 bg-emerald-50/50' :
                        'border-slate-300 hover:border-emerald-400 bg-slate-50/50 hover:bg-white'">

                    <div x-show="!isAnalyzing" class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div class="w-14 h-14 mb-4 rounded-full bg-white shadow-md flex items-center justify-center">
                            <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                        </div>
                        <p class="mb-1 text-sm font-semibold text-slate-700">Click to upload resume</p>
                        <p class="text-xs text-slate-400">PDF or DOCX (max 5MB)</p>
                    </div>

                    <div x-show="isAnalyzing" style="display: none;"
                        class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div class="relative w-14 h-14 mb-4">
                            <div class="absolute inset-0 rounded-full border-4 border-emerald-100"></div>
                            <div
                                class="absolute inset-0 rounded-full border-4 border-emerald-500 border-t-transparent animate-spin">
                            </div>
                        </div>
                        <p class="text-sm text-emerald-600 font-bold animate-pulse">Analyzing your resume...</p>
                        <p class="text-xs text-slate-400 mt-1">This may take a moment</p>
                    </div>

                    <input type="file" class="hidden" @change="analyzeResume" accept=".pdf,.docx">
                </label>
            </div>

            <!-- Analysis Results -->
            <div x-show="analysisComplete" id="analysis-results" style="display: none;" class="space-y-6">

                <!-- Score Card -->
                <div class="relative bg-white rounded-3xl p-8 border border-slate-200 shadow-xl overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-100 to-teal-50 rounded-full blur-3xl opacity-50 -mr-20 -mt-20">
                    </div>

                    <div class="relative flex flex-col md:flex-row md:items-center gap-8">
                        <!-- Score Circle -->
                        <div class="flex-shrink-0">
                            <div class="relative w-36 h-36">
                                <svg class="w-36 h-36 transform -rotate-90">
                                    <circle cx="72" cy="72" r="64" fill="none" stroke="#e2e8f0"
                                        stroke-width="12">
                                    </circle>
                                    <circle cx="72" cy="72" r="64" fill="none"
                                        :stroke="getScoreColor(analysisResult?.overall_score || 0)" stroke-width="12"
                                        stroke-linecap="round"
                                        :stroke-dasharray="`${(analysisResult?.overall_score || 0) * 4.02} 999`">
                                    </circle>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-4xl font-bold"
                                        :style="`color: ${getScoreColor(analysisResult?.overall_score || 0)}`"
                                        x-text="analysisResult?.overall_score || 0"></span>
                                    <span class="text-xs text-slate-500 font-medium">/ 100</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-2xl font-bold text-slate-800">ATS Score</h3>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold"
                                    :style="`background-color: ${getScoreColor(analysisResult?.overall_score || 0)}20; color: ${getScoreColor(analysisResult?.overall_score || 0)}`"
                                    x-text="getScoreLabel(analysisResult?.overall_score || 0)"></span>
                            </div>
                            <p class="text-slate-600 mb-4" x-text="analyzerFileName"></p>
                            <button @click="resetAnalysis"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Analyze Another Resume
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Priority Summary Card -->
                <template x-if="analysisResult?.priority_summary">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Priority Action Items
                        </h4>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-4 rounded-xl bg-red-50 border border-red-100">
                                <div class="text-3xl font-bold text-red-600"
                                    x-text="analysisResult.priority_summary.critical || 0"></div>
                                <div class="text-sm font-medium text-red-700">🔴 Critical</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-amber-50 border border-amber-100">
                                <div class="text-3xl font-bold text-amber-600"
                                    x-text="analysisResult.priority_summary.important || 0"></div>
                                <div class="text-sm font-medium text-amber-700">🟡 Important</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                                <div class="text-3xl font-bold text-emerald-600"
                                    x-text="analysisResult.priority_summary.optional || 0"></div>
                                <div class="text-sm font-medium text-emerald-700">🟢 Optional</div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Section Breakdown -->
                <template x-if="analysisResult?.section_breakdown?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Section-by-Section Breakdown
                        </h4>
                        <div class="space-y-3">
                            <template x-for="sec in analysisResult.section_breakdown" :key="sec.section">
                                <div
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl"
                                            x-text="sec.status === 'complete' ? '✅' : sec.status === 'present' ? '✅' : sec.status === 'needs_improvement' ? '⚠️' : '❌'"></span>
                                        <div>
                                            <p class="font-semibold text-slate-800" x-text="sec.section"></p>
                                            <p class="text-xs text-slate-500" x-text="sec.word_count + ' words'"></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium"
                                            :class="sec.status === 'complete' ? 'bg-emerald-100 text-emerald-700' : sec
                                                .status === 'present' ? 'bg-blue-100 text-blue-700' : sec
                                                .status === 'needs_improvement' ? 'bg-amber-100 text-amber-700' :
                                                'bg-red-100 text-red-700'"
                                            x-text="sec.status.replace('_', ' ')"></span>
                                        <template x-if="sec.issues?.length > 0">
                                            <p class="text-xs text-slate-500 mt-1" x-text="sec.issues[0]"></p>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Content Metrics -->
                <template x-if="analysisResult?.content_metrics">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Content Strength Metrics
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="text-2xl font-bold text-slate-800"
                                    x-text="analysisResult.content_metrics.total_words || 0"></div>
                                <div class="text-xs text-slate-500">Total Words</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="text-2xl font-bold text-emerald-600"
                                    x-text="(analysisResult.content_metrics.action_verb_percentage || 0) + '%'"></div>
                                <div class="text-xs text-slate-500">Action Verbs</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="text-2xl font-bold text-blue-600">
                                    <span x-text="analysisResult.content_metrics.quantifiable_achievements || 0"></span>
                                    <span class="text-sm text-slate-400">/ <span
                                            x-text="analysisResult.content_metrics.recommended_achievements || 15"></span></span>
                                </div>
                                <div class="text-xs text-slate-500">Achievements</div>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="text-2xl font-bold text-indigo-600"
                                    x-text="analysisResult.content_metrics.keywords_found || 0"></div>
                                <div class="text-xs text-slate-500">Keywords Found</div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- ATS Compatibility Checklist -->
                <template x-if="analysisResult?.ats_checklist?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ATS Compatibility Checklist
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <template x-for="item in analysisResult.ats_checklist" :key="item.item">
                                <div class="flex items-center gap-3 p-3 rounded-xl"
                                    :class="item.passed ? 'bg-emerald-50' : 'bg-red-50'">
                                    <span class="text-xl" x-text="item.passed ? '✅' : '❌'"></span>
                                    <div class="flex-1">
                                        <p class="font-medium" :class="item.passed ? 'text-emerald-800' : 'text-red-800'"
                                            x-text="item.item"></p>
                                        <template x-if="item.note">
                                            <p class="text-xs" :class="item.passed ? 'text-emerald-600' : 'text-red-600'"
                                                x-text="item.note"></p>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Improvement Examples (Before/After) -->
                <template x-if="analysisResult?.improvement_examples?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Before → After Examples
                        </h4>
                        <div class="space-y-4">
                            <template x-for="(ex, idx) in analysisResult.improvement_examples" :key="idx">
                                <div
                                    class="p-4 rounded-xl bg-gradient-to-r from-slate-50 to-emerald-50 border border-slate-200">
                                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"
                                        x-text="ex.section"></div>
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="p-3 rounded-lg bg-red-50 border border-red-200">
                                            <div class="text-xs font-bold text-red-600 mb-1">❌ Current</div>
                                            <p class="text-sm text-red-800" x-text="ex.current"></p>
                                        </div>
                                        <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200">
                                            <div class="text-xs font-bold text-emerald-600 mb-1">✅ Improved</div>
                                            <p class="text-sm text-emerald-800" x-text="ex.improved"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Contact & Resume Length Row -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Contact Validation -->
                    <template x-if="analysisResult?.contact_validation">
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                            <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Contact Validation
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                                    <span class="text-sm text-slate-600">Email</span>
                                    <span
                                        x-text="analysisResult.contact_validation.email?.present ? (analysisResult.contact_validation.email?.professional ? '✅ Professional' : '⚠️ Present') : '❌ Missing'"
                                        class="text-sm font-medium"></span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                                    <span class="text-sm text-slate-600">Phone</span>
                                    <span
                                        x-text="analysisResult.contact_validation.phone?.present ? '✅ Present' : '❌ Missing'"
                                        class="text-sm font-medium"></span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                                    <span class="text-sm text-slate-600">LinkedIn</span>
                                    <span
                                        x-text="analysisResult.contact_validation.linkedin?.present ? '✅ Present' : '❌ Missing'"
                                        class="text-sm font-medium"></span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-slate-50">
                                    <span class="text-sm text-slate-600">Location</span>
                                    <span
                                        x-text="analysisResult.contact_validation.location?.present ? '✅ Present' : '❌ Missing'"
                                        class="text-sm font-medium"></span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Resume Length -->
                    <template x-if="analysisResult?.resume_length">
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                            <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Resume Length
                            </h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Estimated Pages</span>
                                    <span class="text-2xl font-bold text-slate-800"
                                        x-text="analysisResult.resume_length.estimated_pages || '~1'"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Recommended</span>
                                    <span class="text-lg font-medium text-emerald-600"
                                        x-text="(analysisResult.resume_length.recommended_pages || 1) + ' page(s)'"></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-600">Density</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium"
                                        :class="analysisResult.resume_length.content_density === 'good' ?
                                            'bg-emerald-100 text-emerald-700' : analysisResult.resume_length
                                            .content_density === 'sparse' ? 'bg-amber-100 text-amber-700' :
                                            'bg-red-100 text-red-700'"
                                        x-text="analysisResult.resume_length.content_density || 'N/A'"></span>
                                </div>
                                <template x-if="analysisResult.resume_length.verdict">
                                    <p class="text-sm text-slate-500 italic"
                                        x-text="analysisResult.resume_length.verdict"></p>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Missing Sections -->
                <template x-if="analysisResult?.missing_sections?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Missing Sections
                        </h4>
                        <div class="space-y-3">
                            <template x-for="section in analysisResult.missing_sections" :key="section.section">
                                <div class="flex items-start gap-3 p-3 rounded-xl border"
                                    :class="getPriorityColor(section.priority)">
                                    <span class="px-2 py-0.5 text-xs font-bold uppercase rounded"
                                        :class="section.priority === 'critical' ? 'bg-red-200 text-red-800' : section
                                            .priority === 'important' ? 'bg-amber-200 text-amber-800' :
                                            'bg-blue-200 text-blue-800'"
                                        x-text="section.priority"></span>
                                    <div>
                                        <p class="font-semibold" x-text="section.section"></p>
                                        <p class="text-sm opacity-75" x-text="section.suggestion"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Recommendations -->
                <template x-if="analysisResult?.recommendations?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recommendations
                        </h4>
                        <div class="space-y-3">
                            <template x-for="rec in analysisResult.recommendations" :key="rec.title">
                                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="px-2 py-0.5 text-xs font-bold uppercase rounded flex-shrink-0"
                                        :class="rec.priority === 'critical' ? 'bg-red-100 text-red-700' : rec
                                            .priority === 'important' ? 'bg-amber-100 text-amber-700' :
                                            'bg-blue-100 text-blue-700'"
                                        x-text="rec.priority"></span>
                                    <div>
                                        <p class="font-semibold text-slate-800" x-text="rec.title"></p>
                                        <p class="text-sm text-slate-600 mt-1" x-text="rec.description"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Keyword Suggestions -->
                <template x-if="analysisResult?.keyword_suggestions?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            Suggested Keywords
                        </h4>
                        <div class="space-y-2">
                            <template x-for="kw in analysisResult.keyword_suggestions" :key="kw.keyword">
                                <div
                                    class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium border"
                                            :class="kw.relevance === 'high' ?
                                                'bg-emerald-50 text-emerald-700 border-emerald-200' : kw
                                                .relevance === 'medium' ?
                                                'bg-amber-50 text-amber-700 border-amber-200' :
                                                'bg-slate-50 text-slate-600 border-slate-200'"
                                            x-text="kw.keyword"></span>
                                        <span class="text-xs px-2 py-0.5 rounded bg-slate-200 text-slate-600"
                                            x-text="kw.relevance"></span>
                                    </div>
                                    <template x-if="kw.where_to_add">
                                        <span class="text-xs text-slate-500" x-text="'→ ' + kw.where_to_add"></span>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Formatting Issues -->
                <template x-if="analysisResult?.formatting_issues?.length > 0">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-lg">
                        <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Formatting Issues
                        </h4>
                        <div class="space-y-2">
                            <template x-for="issue in analysisResult.formatting_issues" :key="issue.issue">
                                <div class="flex items-start gap-3 p-3 rounded-lg bg-slate-50">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" :class="getSeverityColor(issue.severity)"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-slate-800" x-text="issue.issue"></p>
                                        <p class="text-sm text-slate-500" x-text="issue.fix"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>


            </div>

        </div>

        <style>
            @keyframes blob {
                0% {
                    transform: translate(0px, 0px) scale(1);
                }

                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }

                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                100% {
                    transform: translate(0px, 0px) scale(1);
                }
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </div>
@endsection
