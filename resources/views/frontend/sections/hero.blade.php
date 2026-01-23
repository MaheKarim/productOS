@php
    $hero = App\Models\HeroSection::active()->ordered()->first();
@endphp

<section id="hero" class="relative pt-28 pb-32 overflow-hidden min-h-[90vh] flex items-center">
    <!-- Premium Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>

    <!-- Animated Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-cyan-500/10 rounded-full blur-3xl">
        </div>
    </div>

    <!-- Grid Pattern -->
    <div
        class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Content Column -->
            <div class="lg:col-span-7">
                <!-- Specialization Badges -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ $hero->badge_text ?? 'B2B SaaS' }}
                    </span>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-cyan-200 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Growth Strategy
                    </span>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-emerald-200 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                        0-to-1 Products
                    </span>
                </div>

                <!-- Main Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    {!! nl2br(
                        $hero->title ??
                            "I Build Products\nThat <span class='bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400 bg-clip-text text-transparent'>Drive Growth</span>",
                    ) !!}
                </h1>

                <!-- Subtitle -->
                <p class="text-lg md:text-xl text-blue-100/80 mb-10 leading-relaxed max-w-2xl">
                    {!! nl2br(
                        $hero->subtitle ??
                            'Product Manager specializing in B2B SaaS. I help startups and enterprises build scalable, user-centric products—and I create free tools for the PM community.',
                    ) !!}
                </p>

                <!-- Dual CTAs -->
                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ $hero->cta_primary_url ?? '#portfolio' }}"
                        class="px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all hover:shadow-lg hover:shadow-blue-500/25 hover:-translate-y-1 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        {{ $hero->cta_primary_text ?? 'View My Product Work' }}
                    </a>
                    <a href="{{ route('tools.index') }}"
                        class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 hover:border-white/30 transition-all hover:-translate-y-1 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        Explore Free PM Tools
                    </a>
                </div>

                <!-- Stats Row -->
                <div class="flex flex-wrap gap-8 md:gap-12" x-data="{ shown: false }" x-intersect="shown = true">
                    <div class="text-center md:text-left">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-show="shown" x-transition>
                            {{ $hero->stat1_value ?? '50k+' }}
                        </div>
                        <div class="text-sm text-blue-200/60 mt-1">{{ $hero->stat1_label ?? 'Users Impacted' }}</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-white/10"></div>
                    <div class="text-center md:text-left">
                        <div class="text-3xl md:text-4xl font-bold text-white" x-show="shown" x-transition>
                            {{ $hero->stat2_value ?? '15+' }}
                        </div>
                        <div class="text-sm text-blue-200/60 mt-1">{{ $hero->stat2_label ?? 'Products Shipped' }}</div>
                    </div>
                    <div class="hidden md:block w-px h-12 bg-white/10"></div>
                    <div class="text-center md:text-left">
                        <div class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent"
                            x-show="shown" x-transition>
                            20+
                        </div>
                        <div class="text-sm text-blue-200/60 mt-1">Free PM Tools</div>
                    </div>
                </div>
            </div>

            <!-- Image Column -->
            <div class="lg:col-span-5 relative hidden lg:block">
                <div class="relative">
                    <!-- Profile Image Container with Glassmorphism -->
                    <div
                        class="relative rounded-3xl overflow-hidden border border-white/20 bg-white/5 backdrop-blur-sm shadow-2xl">
                        @if (isset($hero) && $hero->profile_image)
                            <img class="w-full h-[500px] object-cover" src="{{ $hero->profile_image_url }}"
                                alt="Product Manager">
                        @else
                            <div
                                class="w-full h-[500px] bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                                <svg class="w-32 h-32 text-white/20" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Floating Card 1 - Tools -->
                    <div class="absolute -bottom-6 -left-6 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 shadow-xl flex items-center gap-3 animate-pulse"
                        style="animation-duration: 3s;">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-blue-200/60 font-medium">Free Tools</div>
                            <div class="text-white font-bold">20+ PM Calculators</div>
                        </div>
                    </div>

                    <!-- Floating Card 2 - Rating -->
                    <div
                        class="absolute top-10 -right-6 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 shadow-xl flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-blue-200/60 font-medium">
                                {{ $hero->floating_card2_title ?? 'Client Rating' }}</div>
                            <div class="text-white font-bold flex items-center gap-1">
                                5.0
                                <span class="text-amber-400">★★★★★</span>
                            </div>
                        </div>
                    </div>
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
