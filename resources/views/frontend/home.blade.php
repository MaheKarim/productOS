@extends('frontend.layout')

@section('title', 'Home')

@section('content')
    {{-- Modern Hero Section --}}
    @include('frontend.sections.hero-modern')

    {{-- Trusted Marquee (Social Proof) --}}
    @include('frontend.sections.trusted-marquee')

    {{-- Value Props (Problem vs Solution) --}}
    @include('frontend.sections.value-props')

    {{-- Bento Directory (Resource Overview) --}}
    @include('frontend.sections.bento-directory')

    {{-- Toolkit Carousel --}}
    @include('frontend.sections.toolkit')

    {{-- Testimonials Section (Preserved & Refined) --}}
    @php
        // Populate mock data if DB is empty to showcase the design
        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                (object) [
                    'name' => 'Sarah Jenkins',
                    'designation' => 'CEO',
                    'company' => 'TechFlow Inc.',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'One of the most strategic product minds I have worked with. They completely transformed our product vision.',
                    'project' => (object) ['title' => 'Product Strategy Overhaul'],
                ],
                (object) [
                    'name' => 'Michael Chen',
                    'designation' => 'CTO',
                    'company' => 'DataSphere',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'Bridged the gap between engineering and business perfectly. Delivered on time and above expectations.',
                    'project' => (object) ['title' => 'Analytics Platform'],
                ],
                (object) [
                    'name' => 'Emily Rodriguez',
                    'designation' => 'VP of Product',
                    'company' => 'StartUp Scale',
                    'avatar_image' => null,
                    'rating' => 5,
                    'feedback' =>
                        'Incredible attention to detail and user empathy. Our user satisfaction scores skyrocketed.',
                    'project' => (object) ['title' => 'UX Redesign'],
                ],
            ]);
        }
    @endphp

    <section id="testimonials" class="py-24 px-8 bg-white relative overflow-hidden">
        {{-- Decorative text --}}
        <div
            class="absolute -top-10 left-1/2 -translate-x-1/2 text-[12rem] md:text-[15rem] font-black text-slate-50 select-none pointer-events-none opacity-50">
            TRUST
        </div>

        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="text-center mb-16">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold mb-4 border border-indigo-100 uppercase tracking-widest">
                    Community Love
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">The <span
                        class="text-indigo-600 italic">Human</span> ROI</h2>
                <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed italic">"Behind every metric is a human
                    experience. Here's what it feels like to build together."</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($testimonials as $testimonial)
                    <div
                        class="group relative bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col h-full hover:-translate-y-1">
                        {{-- Quote Icon --}}
                        <div class="absolute top-8 right-8 text-slate-100 group-hover:text-indigo-50 transition-colors">
                            <i data-lucide="quote" class="w-10 h-10"></i>
                        </div>

                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative">
                                @if ($testimonial->avatar_image)
                                    <img src="{{ $testimonial->avatar_image_url }}" alt="{{ $testimonial->name }}"
                                        class="w-14 h-14 rounded-2xl object-cover ring-4 ring-slate-50 group-hover:ring-indigo-50 transition-all">
                                @else
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition-all">
                                        <i data-lucide="user"
                                            class="w-6 h-6 text-indigo-400 group-hover:text-white transition-colors"></i>
                                    </div>
                                @endif
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-lg flex items-center justify-center border-4 border-white">
                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-black text-slate-900 text-lg leading-tight">{{ $testimonial->name }}</div>
                                @if ($testimonial->designation || $testimonial->company)
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">
                                        {{ $testimonial->designation }}
                                        {{ $testimonial->company ? '@ ' . $testimonial->company : '' }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex mb-4 space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i data-lucide="star"
                                    class="w-4 h-4 {{ $i <= ($testimonial->rating ?? 5) ? 'fill-amber-400 text-amber-400' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>

                        <div class="relative flex-grow">
                            <p class="text-slate-600 leading-relaxed text-lg italic">
                                “{{ $testimonial->feedback }}”
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA Section --}}
    <section id="contact" class="py-24 relative overflow-hidden bg-slate-900">
        <!-- Background Gradients -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-600/20 rounded-full blur-[120px] pointer-events-none">
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight">
                Ready to Upgrade Your <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Product Game?</span>
            </h2>
            <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                Join thousands of product managers building the future with our tools and frameworks.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                @guest
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-white text-slate-900 font-bold rounded-xl hover:bg-blue-50 transition-all hover:scale-105 flex items-center gap-2 shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                        Get Started for Free
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                            </path>
                        </svg>
                    </a>
                @endguest
                <a href="{{ route('tools.index') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 transition-all flex items-center gap-2">
                    Browse All Tools
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </a>
            </div>

            <div class="flex items-center justify-center gap-8 text-slate-500 text-sm font-semibold">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    No credit card required
                </span>
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Free forever plan
                </span>
            </div>
        </div>
    </section>
@endsection
