<section id="about" class="py-32 relative overflow-hidden">
    {{-- Background Elements --}}
    <div
        class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-500/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2 pointer-events-none">
    </div>
    <div
        class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2 pointer-events-none">
    </div>

    <div class="max-w-[1200px] mx-auto px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Left Column: Content --}}
            <div data-aos="fade-right">
                <div
                    class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-teal-50 border border-teal-100 text-teal-700 text-sm font-semibold mb-8">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    <span>About Me</span>
                </div>

                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-8 leading-tight">
                    {{ $about->heading }}
                </h2>

                <div class="space-y-6 text-lg text-slate-600 leading-relaxed mb-10">
                    {!! nl2br($about->description) !!}
                </div>

                {{-- Animated Stats Row (Requested Feature) --}}
                <div class="grid grid-cols-3 gap-6 py-8 border-t border-slate-100" x-data="{ shown: false }"
                    x-intersect.once="shown = true">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-teal-600 mb-1" x-show="shown" x-transition>
                            <span x-data="{ count: 0 }" x-init="$nextTick(() => { let i = 0; const t = setInterval(() => { count++; if (count >= 8) clearInterval(t); }, 100); })" x-text="count">0</span>+
                        </div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Years Exp.</div>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <div class="text-3xl font-bold text-teal-600 mb-1" x-show="shown" x-transition>
                            <span x-data="{ count: 0 }" x-init="$nextTick(() => { let i = 0; const t = setInterval(() => { count += 2; if (count >= 15) clearInterval(t); }, 100); })" x-text="count">0</span>+
                        </div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Products</div>
                    </div>
                    <div class="text-center border-l border-slate-100">
                        <div class="text-3xl font-bold text-teal-600 mb-1" x-show="shown" x-transition>
                            <span x-data="{ count: 0 }" x-init="$nextTick(() => { let i = 0; const t = setInterval(() => { count += 5; if (count >= 50) clearInterval(t); }, 50); })" x-text="count">0</span>k+
                        </div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Users</div>
                    </div>
                </div>

                {{-- Philosophy Grid --}}
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if ($about->philosophy1_title)
                        <div
                            class="flex items-start p-4 rounded-xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <div
                                class="w-10 h-10 rounded-lg bg-teal-50 flex items-center justify-center flex-shrink-0 text-teal-600 mr-4">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $about->philosophy1_title }}</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $about->philosophy1_description }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($about->philosophy2_title)
                        <div
                            class="flex items-start p-4 rounded-xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-600 mr-4">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $about->philosophy2_title }}</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $about->philosophy2_description }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Glassmorphism Card "How I Work" --}}
            <div class="relative" data-aos="fade-left">
                {{-- Decorative blobs --}}
                <div
                    class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-br from-teal-400 to-blue-500 rounded-full blur-2xl opacity-20 animate-pulse">
                </div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur-2xl opacity-20 animate-pulse"
                    style="animation-delay: 1s;"></div>

                <div
                    class="relative bg-white/80 backdrop-blur-xl border border-white/50 rounded-[2.5rem] p-10 shadow-2xl">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white/40 to-white/10 rounded-[2.5rem] pointer-events-none">
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-slate-900">How I Work</h3>
                            <div
                                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 to-blue-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                                <i class="fa-solid fa-layer-group text-white text-xl"></i>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @if ($about->work_item1)
                                <div
                                    class="group flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-teal-100 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center text-sm font-bold group-hover:bg-teal-500 group-hover:text-white transition-colors">
                                            1</div>
                                        <span
                                            class="font-medium text-slate-700 group-hover:text-slate-900">{{ $about->work_item1 }}</span>
                                    </div>
                                    <i
                                        class="fa-solid fa-arrow-right text-slate-300 group-hover:text-teal-500 transform group-hover:translate-x-1 transition-all"></i>
                                </div>
                            @endif
                            @if ($about->work_item2)
                                <div
                                    class="group flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-blue-100 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                            2</div>
                                        <span
                                            class="font-medium text-slate-700 group-hover:text-slate-900">{{ $about->work_item2 }}</span>
                                    </div>
                                    <i
                                        class="fa-solid fa-arrow-right text-slate-300 group-hover:text-blue-500 transform group-hover:translate-x-1 transition-all"></i>
                                </div>
                            @endif
                            @if ($about->work_item3)
                                <div
                                    class="group flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-indigo-100 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                            3</div>
                                        <span
                                            class="font-medium text-slate-700 group-hover:text-slate-900">{{ $about->work_item3 }}</span>
                                    </div>
                                    <i
                                        class="fa-solid fa-arrow-right text-slate-300 group-hover:text-indigo-500 transform group-hover:translate-x-1 transition-all"></i>
                                </div>
                            @endif
                            @if ($about->work_item4)
                                <div
                                    class="group flex items-center justify-between p-4 rounded-2xl bg-slate-50 hover:bg-white border border-transparent hover:border-purple-100 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                            4</div>
                                        <span
                                            class="font-medium text-slate-700 group-hover:text-slate-900">{{ $about->work_item4 }}</span>
                                    </div>
                                    <i
                                        class="fa-solid fa-arrow-right text-slate-300 group-hover:text-purple-500 transform group-hover:translate-x-1 transition-all"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Core Values Chips --}}
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Core Values</h4>
                            <div class="flex flex-wrap gap-2">
                                @if ($about->core_value1)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200">{{ $about->core_value1 }}</span>
                                @endif
                                @if ($about->core_value2)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200">{{ $about->core_value2 }}</span>
                                @endif
                                @if ($about->core_value3)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200">{{ $about->core_value3 }}</span>
                                @endif
                                @if ($about->core_value4)
                                    <span
                                        class="px-3 py-1 rounded-lg bg-slate-50 text-slate-600 text-xs font-semibold border border-slate-200">{{ $about->core_value4 }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
