<section id="services" class="py-32 bg-slate-50 relative overflow-hidden">
    {{-- Decorative background elements --}}
    <div class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-white to-transparent"></div>
    <div class="absolute top-1/4 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl"></div>

    <div class="max-w-[1200px] mx-auto px-8 relative z-10">
        <div class="text-center mb-20" data-aos="fade-up">
            <span
                class="inline-block py-1 px-3 rounded-full bg-white border border-slate-200 text-teal-600 text-xs font-bold mb-4 uppercase tracking-widest shadow-sm">
                Expertise & Capabilities
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6 tracking-tight">
                Strategic Impact <span
                    class="bg-gradient-to-r from-teal-500 to-blue-600 bg-clip-text text-transparent">Delivered</span>
            </h2>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Comprehensive product leadership—from zero-to-one discovery to scaling growth engines.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($services as $service)
                <div class="group relative bg-white border border-slate-200 p-8 rounded-[2rem] transition-all duration-500 hover:shadow-2xl hover:border-teal-500/30 hover:-translate-y-2 overflow-hidden flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    {{-- Decorative gradient blob --}}
                    <div
                        class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-teal-50 to-blue-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                    </div>

                    <div class="relative z-10 flex-grow">
                        {{-- Icon --}}
                        <div
                            class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center mb-8 group-hover:bg-teal-500 group-hover:border-teal-500 transition-all duration-300 shadow-sm">
                            <i
                                class="{{ $service->full_icon }} text-slate-600 text-2xl group-hover:text-white transition-colors duration-300"></i>
                        </div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-4 group-hover:text-teal-600 transition-colors">
                            {{ $service->title }}
                        </h3>

                        {{-- Problem / Solution --}}
                        @if ($service->problem_solves)
                            <div class="mb-6">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">The
                                    Challenge</p>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $service->problem_solves }}</p>
                            </div>
                        @endif

                        {{-- Outcome Badge --}}
                        @if ($service->tangible_outcome)
                            <div class="mb-8 p-4 bg-teal-50 rounded-xl border border-teal-100/50">
                                <div class="flex items-center space-x-2 mb-1">
                                    <i class="fa-solid fa-check-circle text-teal-500 text-xs"></i>
                                    <span
                                        class="text-[10px] font-bold text-teal-700 uppercase tracking-wider">Outcome</span>
                                </div>
                                <p class="text-sm text-teal-900 font-semibold leading-snug">
                                    {{ $service->tangible_outcome }}</p>
                            </div>
                        @endif

                        {{-- Features List --}}
                        @if ($service->features && count($service->features) > 0)
                            <ul class="space-y-3 mb-8">
                                @foreach ($service->features as $feature)
                                    <li class="flex items-center space-x-3 text-slate-500">
                                        <div class="w-1.5 h-1.5 rounded-full bg-teal-400"></div>
                                        <span class="text-sm font-medium">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    {{-- Tool Connection & CTA --}}
                    <div class="mt-auto pt-6 border-t border-slate-100">
                        {{-- Visual Tool Connection (Mockup) --}}
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Related
                                Tool</span>
                            <a href="{{ route('tools.index') }}"
                                class="flex items-center space-x-2 text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                <i class="fa-solid fa-wrench"></i>
                                <span>Find in Toolkit</span>
                            </a>
                        </div>

                        @if ($service->cta_text)
                            <a href="{{ $service->cta_url ?: '#contact' }}"
                                class="inline-flex items-center justify-center w-full py-3 px-6 rounded-xl bg-slate-50 text-slate-900 border border-slate-200 font-bold hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300">
                                <span>{{ $service->cta_text }}</span>
                                <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
