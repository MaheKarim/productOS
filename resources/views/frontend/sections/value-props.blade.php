{{-- Value Props Section --}}
<section class="py-24 bg-white relative overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute top-1/4 left-0 w-[500px] h-[500px] bg-blue-100/50 rounded-full blur-[100px] -z-10"></div>
    <div class="absolute bottom-1/4 right-0 w-[500px] h-[500px] bg-purple-100/50 rounded-full blur-[100px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center mb-20 max-w-3xl mx-auto">
            <span
                class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold mb-4 border border-blue-100 uppercase tracking-widest">
                Why ProductOS?
            </span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                Stop Managing Chaos. <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Start Managing
                    Products.</span>
            </h2>
            <p class="text-xl text-slate-500 leading-relaxed">
                Most PMs spend 70% of their time on busy work. Our tools flip that ratio so you can focus on strategy
                and users.
            </p>
        </div>

        {{-- Problem vs Solution Cards --}}
        <div class="space-y-24">
            {{-- Prop 1: Strategy --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center group">
                <div class="relative order-2 lg:order-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity">
                    </div>
                    <div
                        class="relative bg-white border border-slate-100 rounded-3xl p-8 shadow-2xl shadow-blue-900/5 overflow-hidden">
                        {{-- Fake UI representation --}}
                        <div class="space-y-4">
                            <div
                                class="flex items-center gap-3 p-3 rounded-xl bg-red-50 border border-red-100 opacity-60 grayscale group-hover:grayscale-0 transition-all">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-red-800">The Old Way</div>
                                    <div class="text-xs text-red-600">Scattered docs, endless meetings, gut feelings
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center py-2 text-slate-300">
                                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <div
                                class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-100 shadow-sm">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-emerald-900">The ProductOS Way</div>
                                    <div class="text-xs text-emerald-700">Data-driven frameworks & auto-generated
                                        roadmaps</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-4">Strategic Clarity</h3>
                    <p class="text-lg text-slate-500 mb-6 leading-relaxed">
                        Stop guessing what to build next. Use our prioritization matrices (RICE, MoSCoW) and strategic
                        roadmap builders to align stakeholders instantly.
                    </p>
                    <a href="{{ route('tools.index') }}"
                        class="group inline-flex items-center text-blue-600 font-bold hover:text-blue-700">
                        Try Strategy Tools
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Prop 2: Knowledge --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center group">
                <div class="order-1">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-4">Knowledge at Speed</h3>
                    <p class="text-lg text-slate-500 mb-6 leading-relaxed">
                        Don't have time to read 300-page business books? Get chapter-wise summaries and actionable
                        takeaways from the world's best product management literature.
                    </p>
                    <a href="{{ route('books.index') }}"
                        class="group inline-flex items-center text-purple-600 font-bold hover:text-purple-700">
                        Explore Library
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
                <div class="relative order-2">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity">
                    </div>
                    <div
                        class="relative bg-white border border-slate-100 rounded-3xl p-8 shadow-2xl shadow-purple-900/5 rotate-1 group-hover:rotate-0 transition-transform duration-500">
                        <div class="flex gap-4 mb-4">
                            <div class="w-16 h-24 bg-slate-200 rounded-lg animate-pulse"></div>
                            <div class="flex-1 space-y-3">
                                <div class="h-4 bg-slate-200 rounded w-3/4"></div>
                                <div class="h-4 bg-slate-200 rounded w-1/2"></div>
                                <div class="h-20 bg-slate-50 rounded p-3 text-xs text-slate-400">
                                    "Key Takeaway: The value hypothesis must be proven before the growth hypothesis..."
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Prop 3: Career --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center group">
                <div class="relative order-2 lg:order-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity">
                    </div>
                    <div
                        class="relative bg-white border border-slate-100 rounded-3xl p-8 shadow-2xl shadow-orange-900/5 overflow-hidden -rotate-1 group-hover:rotate-0 transition-transform duration-500">
                        <div class="space-y-3">
                            <div
                                class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                                <span class="text-sm font-medium text-slate-600">Behavioral Interview</span>
                                <span
                                    class="text-xs font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Passed</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                                <span class="text-sm font-medium text-slate-600">Product Design</span>
                                <span class="text-xs font-bold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">In
                                    Progress</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-100">
                                <span class="text-sm font-medium text-slate-600">Estimation</span>
                                <span
                                    class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-4">Career Acceleration</h3>
                    <p class="text-lg text-slate-500 mb-6 leading-relaxed">
                        Ace your next PM interview with our tailored practice sets, and navigate your career path with
                        confidence using our growth frameworks.
                    </p>
                    <a href="{{ route('interview-prep.landing') }}"
                        class="group inline-flex items-center text-amber-600 font-bold hover:text-amber-700">
                        Start Practicing
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
