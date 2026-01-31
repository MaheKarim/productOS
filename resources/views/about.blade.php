@extends('frontend.layout')

@section('title', 'About Me - Mahe Karim')

@section('content')
    <div class="relative min-h-screen overflow-hidden bg-slate-950">

        <!-- Three.js Canvas for Floating Icons -->
        <canvas id="three-canvas" class="fixed inset-0 z-0 pointer-events-none"></canvas>

        <!-- Gradient Mesh Background -->
        <div class="fixed inset-0 z-0 pointer-events-none">
            <!-- Animated Gradient Orbs -->
            <div
                class="absolute top-[-20%] left-[-10%] w-[800px] h-[800px] bg-gradient-to-br from-indigo-600/30 via-violet-600/20 to-transparent rounded-full blur-[150px] animate-float-slow">
            </div>
            <div
                class="absolute top-[40%] right-[-15%] w-[600px] h-[600px] bg-gradient-to-br from-teal-500/25 via-cyan-500/15 to-transparent rounded-full blur-[120px] animate-float-medium">
            </div>
            <div
                class="absolute bottom-[-10%] left-[30%] w-[500px] h-[500px] bg-gradient-to-br from-purple-600/20 via-pink-500/10 to-transparent rounded-full blur-[100px] animate-float-fast">
            </div>

            <!-- Noise Texture Overlay -->
            <div class="absolute inset-0 opacity-[0.03]"
                style="background-image: url('data:image/svg+xml,<svg viewBox=\"0 0 200 200\" xmlns=\"http://www.w3.org/2000/svg\"><filter id=\"noise\"><feTurbulence type=\"fractalNoise\" baseFrequency=\"0.65\" numOctaves=\"3\" stitchTiles=\"stitch\"/></filter><rect width=\"100%\" height=\"100%\" filter=\"url(%23noise)\"/></svg>'); filter: contrast(120%) brightness(120%);">
            </div>

            <!-- Grid Pattern -->
            <div class="absolute inset-0 opacity-[0.02]"
                style="background-image: linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 60px 60px;">
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10">

            <!-- Hero Section -->
            <section class="relative min-h-screen flex items-center justify-center py-20 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Central Hero Content -->
                    <div class="text-center space-y-8 max-w-4xl mx-auto" data-aos="fade-up" data-aos-duration="1000">

                        <!-- Status Badge -->
                        <div
                            class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white/5 border border-white/10 backdrop-blur-xl">
                            <span class="relative flex h-3 w-3">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            <span class="text-sm font-medium text-slate-300 tracking-wide">Available for Projects</span>
                        </div>

                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tight">
                                <span class="block text-white">Hi, I'm</span>
                                <span
                                    class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-violet-400 to-purple-400 animate-gradient-x">
                                    Mahe Karim
                                </span>
                            </h1>
                        </div>

                        <!-- Role Tags -->
                        <div class="flex flex-wrap justify-center gap-3 mt-8">
                            <span
                                class="px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-medium backdrop-blur-sm hover:bg-indigo-500/20 transition-all duration-300 cursor-default">
                                Product Manager
                            </span>
                            <span
                                class="px-4 py-2 rounded-xl bg-teal-500/10 border border-teal-500/20 text-teal-300 text-sm font-medium backdrop-blur-sm hover:bg-teal-500/20 transition-all duration-300 cursor-default">
                                Ex-Software Developer
                            </span>
                            <span
                                class="px-4 py-2 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-300 text-sm font-medium backdrop-blur-sm hover:bg-purple-500/20 transition-all duration-300 cursor-default">
                                Poet & Photographer
                            </span>
                        </div>

                        <!-- Bio -->
                        <p class="text-lg sm:text-xl text-slate-400 leading-relaxed max-w-3xl mx-auto">
                            Based in <span class="text-indigo-400 font-semibold">Dhaka, Bangladesh</span>. Founder of
                            <span
                                class="text-teal-400 font-semibold hover:text-teal-300 transition-colors cursor-pointer">GrassHopper
                                Digital</span> and
                            <span
                                class="text-blue-400 font-semibold hover:text-blue-300 transition-colors cursor-pointer">OnDemand
                                Agency</span>.
                            I build digital products that drive growth and transform businesses.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
                            <a href="{{ url('/contact') }}"
                                class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 shadow-2xl shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all duration-500 hover:scale-105 cursor-pointer">
                                <span
                                    class="absolute inset-0 bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span class="relative flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Get in Touch
                                </span>
                            </a>
                            <a href="{{ url('/portfolio') }}"
                                class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-slate-300 rounded-2xl border-2 border-white/10 bg-white/5 backdrop-blur-sm hover:bg-white/10 hover:border-white/20 transition-all duration-300 cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    View Portfolio
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                        <div class="w-8 h-14 rounded-full border-2 border-white/20 flex items-start justify-center p-2">
                            <div class="w-1.5 h-3 rounded-full bg-white/40 animate-scroll-indicator"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="relative py-20 border-y border-white/5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <!-- Stat 1 -->
                        <div class="group text-center p-6 rounded-3xl bg-white/[0.02] border border-white/5 backdrop-blur-sm hover:bg-white/[0.05] hover:border-white/10 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="100">
                            <div
                                class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-br from-indigo-400 to-violet-400 mb-2">
                                2+</div>
                            <div class="text-sm text-slate-500 uppercase tracking-widest font-medium">Years Experience</div>
                        </div>

                        <!-- Stat 2 -->
                        <div class="group text-center p-6 rounded-3xl bg-white/[0.02] border border-white/5 backdrop-blur-sm hover:bg-white/[0.05] hover:border-white/10 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="200">
                            <div
                                class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-br from-teal-400 to-cyan-400 mb-2">
                                50+</div>
                            <div class="text-sm text-slate-500 uppercase tracking-widest font-medium">Projects Delivered
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="group text-center p-6 rounded-3xl bg-white/[0.02] border border-white/5 backdrop-blur-sm hover:bg-white/[0.05] hover:border-white/10 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="300">
                            <div
                                class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-br from-purple-400 to-pink-400 mb-2">
                                100+</div>
                            <div class="text-sm text-slate-500 uppercase tracking-widest font-medium">Happy Clients</div>
                        </div>

                        <!-- Stat 4 -->
                        <div class="group text-center p-6 rounded-3xl bg-white/[0.02] border border-white/5 backdrop-blur-sm hover:bg-white/[0.05] hover:border-white/10 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="400">
                            <div
                                class="text-5xl md:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-br from-amber-400 to-orange-400 mb-2">
                                2</div>
                            <div class="text-sm text-slate-500 uppercase tracking-widest font-medium">Companies Founded
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- My Journey Section -->
            <section class="relative py-24 lg:py-32">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                        <!-- Left: Content -->
                        <div class="space-y-8" data-aos="fade-right">
                            <div
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-sm font-medium text-indigo-300 tracking-wide">My Story</span>
                            </div>

                            <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                                From Curiosity to
                                <span
                                    class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">Building
                                    the Future</span>
                            </h2>

                            <div class="space-y-6 text-lg text-slate-400 leading-relaxed">
                                <p>
                                    My journey in tech started with curiosity—taking apart computers just to see how they
                                    worked. That childhood fascination evolved into a career building <span
                                        class="text-indigo-400 font-semibold">innovative SaaS products</span>, scalable web
                                    applications, and AI-powered solutions.
                                </p>
                                <p>
                                    Today, I lead <span class="text-teal-400 font-semibold">GrassHopper Digital</span>,
                                    where we craft digital transformation strategies for businesses. We don't just build
                                    software—we architect solutions that drive real growth.
                                </p>
                                <p>
                                    Simultaneously, I founded <span class="text-blue-400 font-semibold">OnDemand
                                        Agency</span>, a tech-focused consultancy delivering bespoke solutions—from AI
                                    integration to custom web development.
                                </p>
                            </div>
                        </div>

                        <!-- Right: Bento Grid -->
                        <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                            <!-- Card 1: Innovation -->
                            <div
                                class="group p-6 rounded-3xl bg-gradient-to-br from-indigo-500/10 to-violet-500/5 border border-indigo-500/20 backdrop-blur-sm hover:border-indigo-500/40 transition-all duration-500 cursor-default">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">Innovation</h3>
                                <p class="text-sm text-slate-400">Pushing boundaries to create better solutions</p>
                            </div>

                            <!-- Card 2: Empathy -->
                            <div
                                class="group p-6 rounded-3xl bg-gradient-to-br from-teal-500/10 to-cyan-500/5 border border-teal-500/20 backdrop-blur-sm hover:border-teal-500/40 transition-all duration-500 cursor-default mt-8">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-teal-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">Empathy</h3>
                                <p class="text-sm text-slate-400">Understanding needs and building connections</p>
                            </div>

                            <!-- Card 3: Excellence -->
                            <div
                                class="group p-6 rounded-3xl bg-gradient-to-br from-purple-500/10 to-pink-500/5 border border-purple-500/20 backdrop-blur-sm hover:border-purple-500/40 transition-all duration-500 cursor-default">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">Excellence</h3>
                                <p class="text-sm text-slate-400">Delivering quality in every interaction</p>
                            </div>

                            <!-- Card 4: Growth -->
                            <div
                                class="group p-6 rounded-3xl bg-gradient-to-br from-amber-500/10 to-orange-500/5 border border-amber-500/20 backdrop-blur-sm hover:border-amber-500/40 transition-all duration-500 cursor-default mt-8">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/25 mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-2">Growth</h3>
                                <p class="text-sm text-slate-400">Driving measurable business impact</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Skills Section -->
            <section class="relative py-24 lg:py-32 border-y border-white/5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- Section Header -->
                    <div class="text-center mb-16" data-aos="fade-up">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-violet-500/10 border border-violet-500/20 mb-6">
                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <span class="text-sm font-medium text-violet-300 tracking-wide">Tech Stack</span>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">Skills & Expertise</h2>
                        <p class="text-lg text-slate-400 max-w-2xl mx-auto">The tools and technologies I use to bring ideas
                            to life</p>
                    </div>

                    <!-- Skills Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Skill 1: SaaS Development -->
                        <div class="group relative p-8 rounded-3xl bg-gradient-to-br from-white/[0.03] to-transparent border border-white/5 backdrop-blur-sm overflow-hidden hover:border-indigo-500/30 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="100">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="relative">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-xl shadow-indigo-500/20 mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">SaaS Development</h3>
                                <p class="text-sm text-slate-400 mb-6">Scalable, subscription-based software with modern
                                    architectures</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">Laravel</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">React</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">Vue.js</span>
                                </div>
                            </div>
                        </div>

                        <!-- Skill 2: AI & Data -->
                        <div class="group relative p-8 rounded-3xl bg-gradient-to-br from-white/[0.03] to-transparent border border-white/5 backdrop-blur-sm overflow-hidden hover:border-teal-500/30 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="200">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="relative">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-xl shadow-teal-500/20 mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">AI & Data</h3>
                                <p class="text-sm text-slate-400 mb-6">AI/ML solutions for smarter decision-making</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-teal-500/10 text-teal-300 border border-teal-500/20">OpenAI</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-teal-500/10 text-teal-300 border border-teal-500/20">Claude</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-teal-500/10 text-teal-300 border border-teal-500/20">LangChain</span>
                                </div>
                            </div>
                        </div>

                        <!-- Skill 3: Cloud & DevOps -->
                        <div class="group relative p-8 rounded-3xl bg-gradient-to-br from-white/[0.03] to-transparent border border-white/5 backdrop-blur-sm overflow-hidden hover:border-blue-500/30 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="300">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="relative">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-xl shadow-blue-500/20 mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Cloud & DevOps</h3>
                                <p class="text-sm text-slate-400 mb-6">Cloud infrastructure with CI/CD pipelines</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-300 border border-blue-500/20">AWS</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-300 border border-blue-500/20">Docker</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-300 border border-blue-500/20">K8s</span>
                                </div>
                            </div>
                        </div>

                        <!-- Skill 4: Design & UX -->
                        <div class="group relative p-8 rounded-3xl bg-gradient-to-br from-white/[0.03] to-transparent border border-white/5 backdrop-blur-sm overflow-hidden hover:border-purple-500/30 transition-all duration-500 cursor-default"
                            data-aos="fade-up" data-aos-delay="400">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div class="relative">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-xl shadow-purple-500/20 mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Design & UX</h3>
                                <p class="text-sm text-slate-400 mb-6">Intuitive, beautiful user interfaces</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-500/10 text-purple-300 border border-purple-500/20">Figma</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-500/10 text-purple-300 border border-purple-500/20">Tailwind</span>
                                    <span
                                        class="px-3 py-1.5 text-xs font-medium rounded-lg bg-purple-500/10 text-purple-300 border border-purple-500/20">XD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="relative py-24 lg:py-32">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

                    <!-- Decorative Glow -->
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-gradient-to-r from-indigo-500/20 via-violet-500/20 to-purple-500/20 rounded-full blur-[120px] pointer-events-none">
                    </div>

                    <div class="relative space-y-8" data-aos="fade-up">
                        <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                            Let's Create Something
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-violet-400 to-purple-400">Amazing
                                Together</span>
                        </h2>
                        <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                            Whether you need a SaaS product, AI integration, or a stunning website—I'm here to help bring
                            your vision to life.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                            <a href="{{ url('/contact') }}"
                                class="group relative inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-white overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 shadow-2xl shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all duration-500 hover:scale-105 cursor-pointer">
                                <span
                                    class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                <span class="relative flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Start a Project
                                </span>
                            </a>
                            <a href="mailto:hello@mahekarim.com"
                                class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-slate-300 rounded-2xl border-2 border-white/10 bg-white/5 backdrop-blur-sm hover:bg-white/10 hover:border-white/20 transition-all duration-300 cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Email Me
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Three.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        // Three.js Floating Icons Scene
        (function() {
            const canvas = document.getElementById('three-canvas');
            if (!canvas) return;

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({
                canvas,
                alpha: true,
                antialias: true
            });

            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            // Create floating geometric shapes
            const shapes = [];
            const geometries = [
                new THREE.IcosahedronGeometry(0.5, 0),
                new THREE.OctahedronGeometry(0.5),
                new THREE.TetrahedronGeometry(0.5),
                new THREE.DodecahedronGeometry(0.4),
                new THREE.TorusGeometry(0.3, 0.1, 16, 100),
                new THREE.BoxGeometry(0.5, 0.5, 0.5),
            ];

            const colors = [
                0x6366f1, // indigo
                0x8b5cf6, // violet
                0xa855f7, // purple
                0x14b8a6, // teal
                0x06b6d4, // cyan
                0x3b82f6, // blue
            ];

            for (let i = 0; i < 20; i++) {
                const geometry = geometries[Math.floor(Math.random() * geometries.length)];
                const material = new THREE.MeshBasicMaterial({
                    color: colors[Math.floor(Math.random() * colors.length)],
                    wireframe: true,
                    transparent: true,
                    opacity: 0.15 + Math.random() * 0.15
                });

                const mesh = new THREE.Mesh(geometry, material);

                mesh.position.x = (Math.random() - 0.5) * 20;
                mesh.position.y = (Math.random() - 0.5) * 20;
                mesh.position.z = (Math.random() - 0.5) * 10 - 5;

                mesh.rotation.x = Math.random() * Math.PI;
                mesh.rotation.y = Math.random() * Math.PI;

                const scale = 0.5 + Math.random() * 1.5;
                mesh.scale.set(scale, scale, scale);

                mesh.userData = {
                    rotationSpeed: {
                        x: (Math.random() - 0.5) * 0.01,
                        y: (Math.random() - 0.5) * 0.01,
                        z: (Math.random() - 0.5) * 0.01
                    },
                    floatSpeed: 0.0005 + Math.random() * 0.001,
                    floatOffset: Math.random() * Math.PI * 2,
                    originalY: mesh.position.y
                };

                scene.add(mesh);
                shapes.push(mesh);
            }

            camera.position.z = 5;

            // Mouse interaction
            let mouseX = 0;
            let mouseY = 0;
            let targetX = 0;
            let targetY = 0;

            document.addEventListener('mousemove', (event) => {
                mouseX = (event.clientX / window.innerWidth) * 2 - 1;
                mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
            });

            // Animation loop
            function animate() {
                requestAnimationFrame(animate);

                targetX += (mouseX - targetX) * 0.02;
                targetY += (mouseY - targetY) * 0.02;

                shapes.forEach((shape, i) => {
                    shape.rotation.x += shape.userData.rotationSpeed.x;
                    shape.rotation.y += shape.userData.rotationSpeed.y;
                    shape.rotation.z += shape.userData.rotationSpeed.z;

                    // Floating animation
                    shape.position.y = shape.userData.originalY +
                        Math.sin(Date.now() * shape.userData.floatSpeed + shape.userData.floatOffset) * 0.5;

                    // Subtle parallax effect
                    shape.position.x += targetX * 0.001 * (i % 3 + 1);
                });

                // Camera subtle movement
                camera.position.x += (targetX * 0.5 - camera.position.x) * 0.02;
                camera.position.y += (targetY * 0.3 - camera.position.y) * 0.02;
                camera.lookAt(scene.position);

                renderer.render(scene, camera);
            }

            animate();

            // Handle resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });

            // Respect reduced motion preference
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                shapes.forEach(shape => {
                    shape.userData.rotationSpeed = {
                        x: 0,
                        y: 0,
                        z: 0
                    };
                    shape.userData.floatSpeed = 0;
                });
            }
        })();
    </script>

    <style>
        /* Custom Animations */
        @keyframes float-slow {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, -30px) rotate(5deg);
            }

            50% {
                transform: translate(-10px, -50px) rotate(-3deg);
            }

            75% {
                transform: translate(-30px, -20px) rotate(2deg);
            }
        }

        @keyframes float-medium {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(-25px, 40px) rotate(-5deg);
            }

            66% {
                transform: translate(25px, 20px) rotate(5deg);
            }
        }

        @keyframes float-fast {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(30px, -30px);
            }
        }

        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes scroll-indicator {
            0% {
                transform: translateY(0);
                opacity: 1;
            }

            50% {
                transform: translateY(8px);
                opacity: 0.5;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-float-slow {
            animation: float-slow 20s ease-in-out infinite;
        }

        .animate-float-medium {
            animation: float-medium 15s ease-in-out infinite;
        }

        .animate-float-fast {
            animation: float-fast 10s ease-in-out infinite;
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
        }

        .animate-scroll-indicator {
            animation: scroll-indicator 2s ease-in-out infinite;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {

            .animate-float-slow,
            .animate-float-medium,
            .animate-float-fast,
            .animate-gradient-x,
            .animate-scroll-indicator,
            .animate-bounce,
            .animate-ping,
            .animate-pulse {
                animation: none;
            }
        }
    </style>
@endsection
