<x-layout.app>
    <x-slot:title>PM Career Compass - Assess Your Product Management Career</x-slot:title>

    <!-- Hero Section -->
    <section class="pt-28 pb-20 relative overflow-hidden min-h-[80vh]">
        <!-- Animated Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900"></div>

        <!-- Animated Orbs -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-600/10 rounded-full blur-3xl">
            </div>
        </div>

        <!-- Grid Pattern -->
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]">
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-indigo-200 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Based on Bangaly Kaba's Framework</span>
                </div>

                <!-- Main Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    🧭 PM Career
                    <span
                        class="bg-gradient-to-r from-indigo-400 via-violet-400 to-purple-400 bg-clip-text text-transparent">
                        Compass
                    </span>
                </h1>

                <p class="text-xl md:text-2xl text-indigo-100/80 mb-4 max-w-3xl mx-auto">
                    Is your Product Management career on the right track?
                </p>

                <p class="text-lg text-indigo-200/60 mb-10 max-w-2xl mx-auto">
                    This tool helps you understand your career health, identify areas for improvement, and get
                    actionable next steps using the proven framework from Facebook, Instagram, and YouTube.
                </p>

                <!-- Formula Card -->
                <div
                    class="inline-block bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl px-8 py-5 mb-10">
                    <div class="flex items-center justify-center gap-3 text-2xl font-mono text-white">
                        <span class="text-indigo-300">Impact</span>
                        <span class="text-white/60">=</span>
                        <span class="text-emerald-400">Environment</span>
                        <span class="text-white/60">×</span>
                        <span class="text-amber-400">Skills</span>
                    </div>
                    <p class="text-sm text-indigo-200/60 mt-2">Max Score: 96 points (12 × 8)</p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="{{ route('career-compass.assess') }}"
                        class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-bold text-lg rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Start Assessment — 5 mins
                    </a>
                    <a href="#how-it-works"
                        class="px-6 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        How It Works
                    </a>
                </div>

                <!-- Stats Row -->
                <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">5 min</div>
                        <div class="text-sm text-indigo-200/60 mt-1">To Complete</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-white/10"></div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white">10</div>
                        <div class="text-sm text-indigo-200/60 mt-1">Variables Assessed</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-white/10"></div>
                    <div class="text-center">
                        <div
                            class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                            Free
                        </div>
                        <div class="text-sm text-indigo-200/60 mt-1">No Account Required</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path
                    d="M0 80L60 74.7C120 69 240 59 360 53.3C480 48 600 48 720 53.3C840 59 960 69 1080 69.3C1200 69 1320 59 1380 53.3L1440 48V80H1380C1320 80 1200 80 1080 80C960 80 840 80 720 80C600 80 480 80 360 80C240 80 120 80 60 80H0Z"
                    fill="white" />
            </svg>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">How It Works</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Complete a simple 4-step assessment to understand your career health
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-indigo-500 to-violet-600 w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-4 shadow-lg shadow-indigo-500/30">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Rate Environment</h3>
                    <p class="text-slate-600">Rate 6 factors: Manager, Resources, Team, Scope, Compensation, Culture</p>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-emerald-500 to-teal-600 w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-4 shadow-lg shadow-emerald-500/30">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Rate Skills</h3>
                    <p class="text-slate-600">Rate 4 skill areas: Communication, Leadership, Strategy, Execution</p>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-amber-500 to-orange-600 w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-4 shadow-lg shadow-amber-500/30">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Get Instant Results</h3>
                    <p class="text-slate-600">See your Impact Score with visual charts and personalized recommendations
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="relative">
                    <div
                        class="bg-gradient-to-br from-purple-500 to-pink-600 w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold mb-4 shadow-lg shadow-purple-500/30">
                        4
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Track Progress</h3>
                    <p class="text-slate-600">Create a free account to save assessments and track improvement over time
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">What You'll Get</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Benefit 1 -->
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-slate-100">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Impact Score</h3>
                    <p class="text-slate-600">Get a clear numerical score (0-96) that represents your overall career
                        health</p>
                </div>

                <!-- Benefit 2 -->
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-slate-100">
                    <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Strengths & Weaknesses</h3>
                    <p class="text-slate-600">Identify which areas are driving your success and which need attention
                    </p>
                </div>

                <!-- Benefit 3 -->
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow border border-slate-100">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Action Plan</h3>
                    <p class="text-slate-600">Get prioritized recommendations with specific steps and timelines</p>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-12">
                <a href="{{ route('career-compass.assess') }}"
                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-bold text-lg rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Start Your Free Assessment
                </a>
            </div>
        </div>
    </section>

    <!-- About the Framework -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-slate-50 to-indigo-50 rounded-3xl p-8 md:p-12 border border-slate-200">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">About This Framework</h3>
                        <p class="text-slate-600 mt-1">Created by Bangaly Kaba, Growth Leader at Facebook, Instagram,
                            and YouTube</p>
                    </div>
                </div>
                <p class="text-slate-700 leading-relaxed mb-6">
                    The <strong>Impact = Environment × Skills</strong> framework helps product managers evaluate their
                    career situation holistically.
                    Rather than focusing only on skills development, it recognizes that your work environment is equally
                    important (or even more important) for career success.
                </p>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-5 border border-slate-200">
                        <h4 class="font-bold text-emerald-700 mb-2">Environment (6 factors)</h4>
                        <p class="text-sm text-slate-600">Manager, Resources, Team, Scope, Compensation, Culture —
                            External factors that affect your ability to have impact</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 border border-slate-200">
                        <h4 class="font-bold text-amber-700 mb-2">Skills (4 factors)</h4>
                        <p class="text-sm text-slate-600">Communication, Leadership, Strategy, Execution — Internal
                            capabilities you can develop</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>
