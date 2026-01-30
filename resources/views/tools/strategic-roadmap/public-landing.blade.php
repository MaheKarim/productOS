<x-layout.app title="AI Strategic Roadmap Generator - ProductOS">
    {{-- Plus Jakarta Sans Font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        .font-jakarta {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        /* Smooth scroll-triggered animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatAnimation {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-float {
            animation: floatAnimation 6s ease-in-out infinite;
        }

        .animate-shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* Glass morphism cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Stats counter animation */
        .stat-number {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    {{-- Hero Section --}}
    <section
        class="font-jakarta relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/50 to-indigo-50">
        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            {{-- Gradient Orbs --}}
            <div
                class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-gradient-to-br from-blue-400/20 to-indigo-500/20 blur-3xl animate-float">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-gradient-to-br from-purple-400/15 to-pink-400/15 blur-3xl animate-float delay-300">
            </div>
            <div
                class="absolute top-1/3 right-1/4 w-72 h-72 rounded-full bg-gradient-to-br from-cyan-400/10 to-blue-400/10 blur-3xl animate-float delay-500">
            </div>

            {{-- Grid Pattern --}}
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#3B82F610_1px,transparent_1px),linear-gradient(to_bottom,#3B82F610_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Left Content --}}
                <div class="text-center lg:text-left opacity-0 animate-fade-in-up">
                    {{-- Badge --}}
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-200 mb-6">
                        <span class="relative flex h-2.5 w-2.5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                        </span>
                        <span class="text-blue-700 text-sm font-semibold tracking-wide">AI-Powered Strategy
                            Engine</span>
                    </div>

                    {{-- Headline --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.1] mb-6">
                        Build Your Strategic
                        <span
                            class="block mt-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent animate-gradient">
                            PM Roadmap
                        </span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
                        Get a personalized roadmap with metrics, action items, and industry benchmarks tailored to your
                        experience level.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ auth()->check() ? route('user.strategic-roadmap.index') : route('login', ['redirect' => route('user.strategic-roadmap.index')]) }}"
                            class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Start Building Free
                            <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#how-it-works"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-700 font-semibold rounded-2xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all duration-200 cursor-pointer">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            See How It Works
                        </a>
                    </div>

                    @guest
                        <p class="mt-6 text-slate-500 text-sm">Free account required to save and track your roadmaps</p>
                    @endguest
                </div>

                {{-- Right - Interactive Stats Card --}}
                <div class="opacity-0 animate-fade-in-up delay-200 order-first lg:order-last">
                    <div class="relative">
                        {{-- Main Stats Card --}}
                        <div
                            class="glass-card rounded-3xl border border-slate-200/60 shadow-2xl shadow-slate-200/50 p-8 lg:p-10">
                            {{-- Header --}}
                            <div class="flex items-center gap-3 mb-8 pb-6 border-b border-slate-100">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Strategic Roadmap</h3>
                                    <p class="text-sm text-slate-500">AI-Generated Report</p>
                                </div>
                            </div>

                            {{-- Stats Grid --}}
                            <div class="grid grid-cols-3 gap-6 mb-8">
                                <div class="text-center">
                                    <div class="text-3xl sm:text-4xl font-extrabold stat-number mb-1">90</div>
                                    <div class="text-xs sm:text-sm text-slate-500 font-medium">Day Plans</div>
                                </div>
                                <div class="text-center border-x border-slate-100">
                                    <div class="text-3xl sm:text-4xl font-extrabold stat-number mb-1">5+</div>
                                    <div class="text-xs sm:text-sm text-slate-500 font-medium">Frameworks</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl sm:text-4xl font-extrabold stat-number mb-1">3</div>
                                    <div class="text-xs sm:text-sm text-slate-500 font-medium">PM Levels</div>
                                </div>
                            </div>

                            {{-- Progress Bar Visual --}}
                            <div class="space-y-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-slate-700">Roadmap Progress</span>
                                    <span class="text-blue-600 font-bold">78%</span>
                                </div>
                                <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                                    <div
                                        class="h-full w-[78%] bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full relative">
                                        <div class="absolute inset-0 animate-shimmer"></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Track your progress in real-time
                                </div>
                            </div>
                        </div>

                        {{-- Floating Badge --}}
                        <div
                            class="absolute -top-4 -right-4 sm:-top-6 sm:-right-6 bg-gradient-to-br from-orange-500 to-pink-500 text-white px-4 py-2 rounded-xl shadow-lg shadow-orange-500/30 font-bold text-sm animate-float">
                            ✨ AI Powered
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- User Level Cards Section --}}
    <section class="font-jakarta py-20 lg:py-28 bg-white relative overflow-hidden" id="how-it-works">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#3B82F608_1px,transparent_1px)] bg-[size:24px_24px]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 lg:mb-20">
                <span
                    class="inline-block px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">Choose
                    Your Path</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4">
                    Select Your Experience Level
                </h2>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto">
                    Get a roadmap tailored exactly to where you are in your PM journey
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                {{-- Junior PM Card --}}
                <a href="{{ auth()->check() ? route('user.strategic-roadmap.quick-start') : route('login', ['redirect' => route('user.strategic-roadmap.quick-start')]) }}"
                    class="group relative bg-white rounded-3xl border-2 border-slate-100 p-6 lg:p-8 hover:border-emerald-300 hover:shadow-2xl hover:shadow-emerald-100/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                    {{-- Gradient Overlay --}}
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative">
                        {{-- Icon --}}
                        <div
                            class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>

                        {{-- Content --}}
                        <h3 class="text-xl lg:text-2xl font-bold text-slate-900 mb-2">I'm New to PM</h3>
                        <p class="text-slate-500 mb-6">Less than 2 years experience</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>90-Day Action Plan</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Basic Metrics Guide</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Step-by-Step Checklist</span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center gap-2 text-emerald-600 font-bold group-hover:gap-3 transition-all duration-200">
                            Start Quick Assessment
                            <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Mid-Level PM Card (Most Popular) --}}
                <a href="{{ auth()->check() ? route('user.strategic-roadmap.advanced', ['level' => 'mid']) : route('login', ['redirect' => route('user.strategic-roadmap.advanced', ['level' => 'mid'])]) }}"
                    class="group relative bg-white rounded-3xl border-2 border-blue-200 p-6 lg:p-8 hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-100/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                    {{-- Popular Badge --}}
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                        <span
                            class="px-5 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-bold rounded-full shadow-lg shadow-blue-500/30">
                            Most Popular
                        </span>
                    </div>

                    {{-- Gradient Overlay --}}
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative">
                        {{-- Icon --}}
                        <div
                            class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-6 shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>

                        {{-- Content --}}
                        <h3 class="text-xl lg:text-2xl font-bold text-slate-900 mb-2">Experienced PM</h3>
                        <p class="text-slate-500 mb-6">2-5 years experience</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Quarterly OKR Roadmap</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Prioritization Framework</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Stakeholder Mapping</span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center gap-2 text-blue-600 font-bold group-hover:gap-3 transition-all duration-200">
                            Build Your Roadmap
                            <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- Senior PM Card --}}
                <a href="{{ auth()->check() ? route('user.strategic-roadmap.advanced', ['level' => 'senior']) : route('login', ['redirect' => route('user.strategic-roadmap.advanced', ['level' => 'senior'])]) }}"
                    class="group relative bg-white rounded-3xl border-2 border-slate-100 p-6 lg:p-8 hover:border-purple-300 hover:shadow-2xl hover:shadow-purple-100/50 transition-all duration-300 hover:-translate-y-2 cursor-pointer">
                    {{-- Gradient Overlay --}}
                    <div
                        class="absolute inset-0 rounded-3xl bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative">
                        {{-- Icon --}}
                        <div
                            class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-violet-600 flex items-center justify-center mb-6 shadow-lg shadow-purple-500/25 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>

                        {{-- Content --}}
                        <h3 class="text-xl lg:text-2xl font-bold text-slate-900 mb-2">Senior PM / Founder</h3>
                        <p class="text-slate-500 mb-6">5+ years or leading a startup</p>

                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Annual Strategic Framework</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Metrics Portfolio Design</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-600">
                                <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Org & Financial Planning</span>
                            </li>
                        </ul>

                        <div
                            class="flex items-center gap-2 text-purple-600 font-bold group-hover:gap-3 transition-all duration-200">
                            Create Strategy Doc
                            <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="font-jakarta py-20 lg:py-28 bg-slate-50 relative overflow-hidden">
        {{-- Background --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(135deg,#3B82F605_25%,transparent_25%,transparent_50%,#3B82F605_50%,#3B82F605_75%,transparent_75%,transparent)] bg-[size:40px_40px]">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 lg:mb-20">
                <span
                    class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold mb-4">Features</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-4">
                    What You'll Get
                </h2>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto">
                    AI-powered tools tailored for Product Managers
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Feature 1 --}}
                <div
                    class="group bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-xl hover:shadow-blue-100/40 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mb-5 shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Metric Frameworks</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">AARRR, HEART, North Star templates built into
                        every roadmap</p>
                </div>

                {{-- Feature 2 --}}
                <div
                    class="group bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-xl hover:shadow-emerald-100/40 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-5 shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Progress Tracking</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Interactive checkpoints saved to your account in
                        real-time</p>
                </div>

                {{-- Feature 3 --}}
                <div
                    class="group bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-xl hover:shadow-amber-100/40 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mb-5 shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Industry Benchmarks</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Compare your metrics against industry standards
                        by product type</p>
                </div>

                {{-- Feature 4 --}}
                <div
                    class="group bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-xl hover:shadow-purple-100/40 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-violet-600 flex items-center justify-center mb-5 shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">Best Practices</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">PM frameworks and proven strategies built into
                        every roadmap</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA Section --}}
    <section
        class="font-jakarta py-20 lg:py-28 bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 relative overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-purple-500/10 blur-3xl"></div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 mb-8">
                <span class="relative flex h-2.5 w-2.5">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-400"></span>
                </span>
                <span class="text-white/80 text-sm font-medium">Join 1,000+ Product Managers</span>
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-6 leading-tight">
                Ready to Build Your<br class="hidden sm:block">Strategic Roadmap?
            </h2>

            <p class="text-lg sm:text-xl text-blue-100/70 mb-10 max-w-2xl mx-auto">
                Join thousands of Product Managers using AI to accelerate their careers and ship better products.
            </p>

            <a href="{{ auth()->check() ? route('user.strategic-roadmap.index') : route('register') }}"
                class="group inline-flex items-center justify-center gap-3 px-10 py-5 bg-white text-slate-900 font-bold text-lg rounded-2xl shadow-2xl shadow-white/10 hover:shadow-white/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 cursor-pointer">
                {{ auth()->check() ? 'Go to Dashboard' : 'Create Free Account' }}
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>

            <p class="mt-6 text-blue-200/50 text-sm">No credit card required • Free forever • Start in 60 seconds</p>
        </div>
    </section>
</x-layout.app>
