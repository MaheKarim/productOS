{{-- Social Proof & Testimonials Section --}}
<section id="social-proof" class="py-24 px-8 bg-white relative overflow-hidden">
    {{-- Decorative text --}}
    <div
        class="absolute -top-10 left-1/2 -translate-x-1/2 text-[12rem] font-black text-slate-50 select-none pointer-events-none opacity-50">
        TRUST
    </div>

    <div class="max-w-[1200px] mx-auto relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <span
                class="inline-block py-1.5 px-4 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold mb-4 border border-indigo-100 uppercase tracking-widest">
                Social Proof
            </span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                Trusted by <span class="text-indigo-600 italic">Product Managers</span> Worldwide
            </h2>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Join thousands of PMs who save time and level up their workflow with our free tools.
            </p>
        </div>

        {{-- Trust Badges --}}
        <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-16" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center gap-3 px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">20+</div>
                    <div class="text-xs text-slate-500 font-medium">PM Tools</div>
                </div>
            </div>

            <div class="flex items-center gap-3 px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">10,000+</div>
                    <div class="text-xs text-slate-500 font-medium">Summaries Generated</div>
                </div>
            </div>

            <div class="flex items-center gap-3 px-6 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">200+</div>
                    <div class="text-xs text-slate-500 font-medium">Directory Resources</div>
                </div>
            </div>
        </div>

        {{-- Testimonials Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="200">
            @foreach ($testimonials->take(3) as $testimonial)
                <div
                    class="group relative bg-white border border-slate-200 rounded-[2rem] p-8 hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col h-full">
                    {{-- Quote Icon --}}
                    <div class="absolute top-6 right-8 text-slate-100 group-hover:text-indigo-50 transition-colors">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                    </div>

                    <div class="flex items-center space-x-4 mb-6">
                        <div class="relative">
                            @if ($testimonial->avatar_image)
                                <img src="{{ $testimonial->avatar_image_url }}" alt="{{ $testimonial->name }}"
                                    class="w-14 h-14 rounded-2xl object-cover ring-4 ring-slate-50 group-hover:ring-indigo-50 transition-all">
                            @else
                                <div
                                    class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center border border-indigo-100 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition-all">
                                    <svg class="w-6 h-6 text-indigo-400 group-hover:text-white transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-lg flex items-center justify-center border-2 border-white">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-lg leading-tight">{{ $testimonial->name }}</div>
                            @if ($testimonial->designation || $testimonial->company)
                                <div class="text-xs font-medium text-slate-400 uppercase tracking-wide mt-0.5">
                                    {{ $testimonial->designation }}{{ $testimonial->company ? ' @ ' . $testimonial->company : '' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex mb-4 space-x-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= ($testimonial->rating ?? 5) ? 'fill-amber-400 text-amber-400' : 'text-slate-200' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
                                    fill="currentColor" />
                            </svg>
                        @endfor
                    </div>

                    <p class="text-slate-600 leading-relaxed flex-grow italic">
                        "{{ $testimonial->feedback }}"
                    </p>

                    @if ($testimonial->project)
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <span
                                class="inline-flex items-center text-xs font-semibold text-slate-400 uppercase tracking-wide">
                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                                {{ $testimonial->project->title }}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
