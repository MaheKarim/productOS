{{-- Modern Hero Section with Glassmorphism --}}
<section id="hero"
    class="relative pt-32 pb-20 overflow-hidden min-h-screen flex items-center bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50">
    {{-- Animated Background Orbs --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-[10%] w-96 h-96 bg-blue-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-[15%] w-[500px] h-[500px] bg-indigo-400/20 rounded-full blur-3xl animate-float"
            style="animation-delay: 2s;"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-cyan-400/10 rounded-full blur-3xl">
        </div>
    </div>

    {{-- Grid Pattern --}}
    <div
        class="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.03)_1px,transparent_1px)] bg-[size:50px_50px]">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        {{-- Hero Content --}}
        <div class="text-center mb-16">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 glass-card rounded-full text-sm font-semibold mb-8 text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Product Manager OS
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-slate-900 leading-tight mb-6">
                Empower Your<br>
                <span
                    class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-clip-text text-transparent animate-gradient">
                    Product Management Journey
                </span>
            </h1>

            <p class="text-xl md:text-2xl text-slate-600 mb-10 leading-relaxed max-w-3xl mx-auto">
                Save time, gain insights, and streamline your workflows with <strong>9 powerful tools</strong> designed
                specifically for Product Managers.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="#features-grid"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-smooth hover:shadow-lg hover:shadow-orange-500/25 hover:-translate-y-1 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Explore All Tools
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 glass-card text-slate-700 font-semibold rounded-xl hover:bg-white/80 transition-smooth hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                        Get Started Free
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @endguest
            </div>

            {{-- Trust Indicators --}}
            <div class="flex flex-wrap justify-center gap-8 md:gap-12 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>100% Free</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>No Credit Card</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>5k+ Active PMs</span>
                </div>
            </div>
        </div>

        {{-- Features Grid - 3x3 for 9 features --}}
        <div id="features-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            {{-- 1. Prompts --}}
            <a href="{{ route('prompts.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">AI Prompts</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Curated prompts for product strategy, research, and
                    documentation.</p>
            </a>

            {{-- 2. Library --}}
            <a href="{{ route('books.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">Book Library</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Chapter-wise summaries of essential PM and business
                    books.</p>
            </a>

            {{-- 3. Tools --}}
            <a href="{{ route('tools.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">PM Tools</h3>
                <p class="text-slate-600 text-sm leading-relaxed">ROI calculators, prioritization matrices, and
                    analytics tools.</p>
            </a>

            {{-- 4. Roadmap --}}
            <a href="{{ route('roadmap.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">Product Roadmap</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Explore our feature roadmap and upcoming tools.</p>
            </a>

            {{-- 5. Directory --}}
            <a href="{{ route('directory.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">PM Directory</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Curated tools, frameworks, communities, and
                    resources.</p>
            </a>

            {{-- 6. YouTube Summarizer --}}
            <a href="{{ route('yt-summarize.index') }}"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">YouTube Summarizer</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Get concise summaries and key takeaways from videos.
                </p>
            </a>

            {{-- 7. Interview Preparation --}}
            <a href="#"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">Interview Prep</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Practice PM interview questions and ace your next
                    interview.</p>
            </a>

            {{-- 8. Strategic Roadmap --}}
            <a href="#"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">Strategic Roadmap</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Plan and visualize your product strategy with
                    AI-powered insights.</p>
            </a>

            {{-- 9. Resume Builder (Coming Soon) --}}
            <a href="#"
                class="group glass-card rounded-2xl p-6 hover:glass-card-strong transition-smooth hover:-translate-y-2 hover:shadow-xl cursor-pointer relative overflow-hidden">
                <div class="absolute top-4 right-4 px-2 py-1 bg-orange-500 text-white text-xs font-bold rounded-full">
                    Coming Soon</div>
                <div
                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-400 to-slate-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-slate-900 font-bold text-lg mb-2">Resume Builder</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Create ATS-optimized PM resumes with AI assistance.
                </p>
            </a>
        </div>
    </div>
</section>
