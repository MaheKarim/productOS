@extends('frontend.layout')

@section('title', 'Home')

@section('content')
    {{-- New Value Proposition Section (replaces Hero) --}}
    @include('frontend.sections.value-proposition')

    {{-- Social Proof / Testimonials Section --}}
    @include('frontend.sections.social-proof')

    {{-- Features Hub Section --}}
    @include('frontend.sections.features-hub')

    @php
        // UI/UX Pro Max: Populate mock data if DB is empty to showcase the design
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

    {{-- About section removed - replaced by Social Proof section above --}}
    @include('frontend.sections.toolkit')


    <!-- Testimonials Section -->
    <section id="testimonials" class="py-32 px-8 bg-white relative overflow-hidden">
        {{-- Decorative text --}}
        <div
            class="absolute -top-10 left-1/2 -translate-x-1/2 text-[15rem] font-black text-slate-50 select-none pointer-events-none opacity-50">
            TRUST</div>

        <div class="max-w-[1200px] mx-auto relative z-10">
            <div class="text-center mb-24">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-bold mb-4 border border-indigo-100 uppercase tracking-widest">Endorsements</span>
                <h2 class="text-5xl font-black text-slate-900 mb-6 tracking-tight">The <span
                        class="text-indigo-600 italic">Human</span> ROI</h2>
                <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed italic">"Behind every metric is a human
                    experience. Here's what it feels like to build together."</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($testimonials as $testimonial)
                    <div
                        class="group relative bg-white border border-slate-200 rounded-[2.5rem] p-10 hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col h-full">
                        {{-- Quote Icon --}}
                        <div class="absolute top-8 right-10 text-slate-100 group-hover:text-indigo-50 transition-colors">
                            <i data-lucide="quote" class="w-12 h-12"></i>
                        </div>

                        <div class="flex items-center space-x-4 mb-8">
                            <div class="relative">
                                @if ($testimonial->avatar_image)
                                    <img src="{{ $testimonial->avatar_image_url }}" alt="{{ $testimonial->name }}"
                                        class="w-16 h-16 rounded-2xl object-cover ring-4 ring-slate-50 group-hover:ring-indigo-50 transition-all">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition-all">
                                        <i data-lucide="user"
                                            class="w-6 h-6 text-indigo-400 group-hover:text-white transition-colors"></i>
                                    </div>
                                @endif
                                <div
                                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-lg flex items-center justify-center border-4 border-white">
                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="font-black text-slate-900 text-lg leading-tight">{{ $testimonial->name }}
                                </div>
                                @if ($testimonial->designation || $testimonial->company)
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-1">
                                        {{ $testimonial->designation }}
                                        {{ $testimonial->company ? '@ ' . $testimonial->company : '' }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex mb-6 space-x-1">
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

                        @if ($testimonial->project)
                            <div class="mt-8 pt-6 border-t border-slate-100 group">
                                <a href="#portfolio"
                                    class="inline-flex items-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-colors">
                                    <i data-lucide="link" class="w-3 h-3 mr-2"></i>
                                    Context: {{ $testimonial->project->title }}
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section (Upgraded with Dual CTA) -->
    <section id="contact" class="py-24 relative overflow-hidden">
        <!-- Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Let's Build Something <span
                    class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Measurable</span></h2>
            <p class="text-xl text-blue-100/80 mb-12 max-w-2xl mx-auto">
                Whether you need strategic guidance, hands-on product execution, or want to explore my free tools—I'm here
                to help.
            </p>

            <!-- Dual CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                <a href="mailto:pm@example.com"
                    class="px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all hover:shadow-lg hover:shadow-blue-500/25 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Let's Talk Product
                </a>
                <a href="{{ route('tools.index') }}"
                    class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold rounded-xl hover:bg-white/20 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    Use Free PM Tools
                </a>
            </div>

            <!-- Contact Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <a href="mailto:pm@example.com"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all border border-white/10 group">
                    <div
                        class="w-14 h-14 rounded-xl bg-white/10 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-white font-bold mb-1">Email</div>
                    <div class="text-blue-200/60 text-sm">pm@example.com</div>
                </a>

                <a href="https://linkedin.com" target="_blank"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all border border-white/10 group">
                    <div
                        class="w-14 h-14 rounded-xl bg-white/10 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </div>
                    <div class="text-white font-bold mb-1">LinkedIn</div>
                    <div class="text-blue-200/60 text-sm">Connect with me</div>
                </a>

                <a href="#"
                    class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all border border-white/10 group">
                    <div
                        class="w-14 h-14 rounded-xl bg-white/10 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-white font-bold mb-1">Schedule</div>
                    <div class="text-blue-200/60 text-sm">Book a call</div>
                </a>
            </div>

            <!-- Social Proof -->
            <div class="mt-12 pt-8 border-t border-white/10">
                <p class="text-blue-200/60 text-sm">Join <span class="text-white font-bold">5,000+</span> product managers
                    using these free tools</p>
            </div>
        </div>
    </section>
@endsection
