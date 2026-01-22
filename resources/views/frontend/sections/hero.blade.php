@php
    $hero = App\Models\HeroSection::active()->ordered()->first();
@endphp

<section id="hero" class="relative pt-32 pb-40 px-8 overflow-hidden bg-white">
    <!-- Dynamic Background -->
    <div
        class="absolute top-0 right-0 w-[800px] h-[800px] bg-gradient-to-br from-teal-100/40 to-primary/20 rounded-full blur-3xl opacity-60 -translate-y-1/2 translate-x-1/3 animate-pulse-slow">
    </div>
    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-accent/10 rounded-full blur-3xl opacity-40 translate-y-1/3 -translate-x-1/4 animate-pulse-slow"
        style="animation-delay: 1s;"></div>

    <div class="max-w-[1200px] mx-auto relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            <div class="col-span-1 md:col-span-7">
                <div
                    class="inline-block px-4 py-2 bg-white/80 backdrop-blur rounded-full shadow-level-1 mb-8 border border-white/50 animate-fade-in-up">
                    <span
                        class="text-sm font-semibold text-primary tracking-wide uppercase">{{ $hero->badge_text ?? 'Product Manager + Growth Strategist' }}</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold text-teal-900 leading-tight mb-6 animate-fade-in-up"
                    style="animation-delay: 100ms;">
                    {!! nl2br($hero->title ?? "Building Products\nThat Matter") !!}
                </h1>
                <p class="text-xl text-slate-600 mb-12 leading-relaxed max-w-xl animate-fade-in-up"
                    style="animation-delay: 200ms;">
                    {!! nl2br(
                        $hero->subtitle ??
                            'I help startups and enterprises build scalable, user-centric products that drive measurable business growth.',
                    ) !!}
                </p>
                <div class="flex flex-wrap items-center gap-4 animate-fade-in-up" style="animation-delay: 300ms;">
                    <a href="{{ $hero->cta_primary_url ?? '#contact' }}"
                        class="gradient-primary text-white font-bold px-8 py-4 rounded-xl hover:shadow-glow hover:-translate-y-1 transition-all duration-300">
                        {{ $hero->cta_primary_text ?? "Let's Talk Product" }}
                    </a>
                    <a href="{{ $hero->cta_secondary_url ?? '#portfolio' }}"
                        class="bg-white text-teal-900 font-bold px-8 py-4 rounded-xl border border-gray-200 hover:border-primary hover:text-primary hover:-translate-y-1 transition-all duration-300 shadow-sm">
                        {{ $hero->cta_secondary_text ?? 'View Case Studies' }}
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-16 animate-fade-in-up" style="animation-delay: 400ms;">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="{{ $hero->stat1_icon ?? 'fa-solid fa-users' }} text-xl"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-teal-900">{{ $hero->stat1_value ?? '10k+' }}</div>
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                {{ $hero->stat1_label ?? 'Users Impacted' }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center text-accent">
                            <i class="{{ $hero->stat2_icon ?? 'fa-solid fa-chart-line' }} text-xl"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-teal-900">{{ $hero->stat2_value ?? '$2M+' }}</div>
                            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                {{ $hero->stat2_label ?? 'Revenue Generated' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-5 relative">
                <div class="relative z-10 animate-float">
                    <div
                        class="overflow-hidden rounded-[2rem] shadow-2xl h-[400px] md:h-[600px] border-8 border-white bg-slate-100 relative group">
                        @if (isset($hero) && $hero->profile_image)
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                src="{{ $hero->profile_image_url }}" alt="Professional product manager portrait">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-teal-50 to-teal-100 flex items-center justify-center">
                                <i class="fa-solid fa-user-tie text-[10rem] text-teal-200/50"></i>
                            </div>
                        @endif

                        <!-- Overlay Gradient -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-teal-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <!-- Floating Card 1 -->
                    <div
                        class="absolute -bottom-6 -left-6 md:-left-12 glass p-5 rounded-2xl flex items-center gap-4 shadow-glass animate-float-delayed z-20">
                        <div
                            class="w-12 h-12 rounded-xl gradient-primary flex items-center justify-center shadow-lg text-white">
                            <i class="{{ $hero->floating_card1_icon ?? 'fa-solid fa-rocket' }}"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Product Hint</div>
                            <div class="text-base font-bold text-teal-900">
                                {{ $hero->floating_card1_title ?? 'Top 1% Talent' }}</div>
                        </div>
                    </div>

                    <!-- Floating Card 2 -->
                    <div
                        class="absolute top-10 -right-6 md:-right-8 glass p-5 rounded-2xl flex items-center gap-4 shadow-glass animate-float z-20">
                        <div
                            class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm text-yellow-500">
                            <i class="{{ $hero->floating_card2_icon ?? 'fa-solid fa-star' }}"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rating</div>
                            <div class="text-base font-bold text-teal-900">
                                {{ $hero->floating_card2_title ?? '5.0/5.0' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-yellow-200 rounded-full blur-2xl opacity-40"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-primary rounded-full blur-3xl opacity-30"></div>
            </div>
        </div>
    </div>
</section>
