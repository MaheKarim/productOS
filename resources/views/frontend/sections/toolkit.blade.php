@php
    // Pull featured tools dynamically from database
    $featuredTools = \App\Models\Tool::where('is_active', true)->with('category')->inRandomOrder()->take(6)->get();

    // Get tool categories for stats
    $totalTools = \App\Models\Tool::where('is_active', true)->count();
@endphp

<section id="toolkit" class="py-24 relative overflow-hidden bg-slate-50" x-data="{ scroll: 0 }">
    <!-- Background Elements -->
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-20 left-0 w-96 h-96 bg-cyan-100 rounded-full blur-3xl opacity-30"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="max-w-xl">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold mb-4 border border-blue-100 uppercase tracking-widest">
                    Interactive Tools
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-4">
                    Product <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-600">Calculators</span>
                </h2>
                <p class="text-lg text-slate-500 leading-relaxed">
                    Stop using spreadsheet templates. Use our interactive calculators for prioritization, ROI, and
                    metrics.
                </p>
            </div>

            <div class="flex gap-2">
                <button @click="$refs.carousel.scrollBy({left: -300, behavior: 'smooth'})"
                    class="p-3 rounded-full bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button @click="$refs.carousel.scrollBy({left: 300, behavior: 'smooth'})"
                    class="p-3 rounded-full bg-slate-900 text-white hover:bg-slate-800 transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel -->
        <div x-ref="carousel" class="flex gap-6 overflow-x-auto pb-8 snap-x snap-mandatory hide-scrollbar">
            @forelse($featuredTools as $tool)
                @php
                    $categoryThemes = [
                        'strategy-validation' => ['gradient' => 'from-emerald-500 to-teal-600', 'bg' => 'emerald'],
                        'saas-metrics' => ['gradient' => 'from-blue-500 to-indigo-600', 'bg' => 'blue'],
                        'prioritization' => ['gradient' => 'from-purple-500 to-violet-600', 'bg' => 'purple'],
                        'validation-research' => ['gradient' => 'from-amber-500 to-orange-600', 'bg' => 'amber'],
                        'execution-delivery' => ['gradient' => 'from-orange-500 to-red-600', 'bg' => 'orange'],
                        'growth-engagement' => ['gradient' => 'from-rose-500 to-pink-600', 'bg' => 'rose'],
                    ];
                    $theme = $categoryThemes[$tool->category->slug ?? ''] ?? [
                        'gradient' => 'from-slate-500 to-slate-600',
                        'bg' => 'slate',
                    ];
                @endphp

                <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]) }}"
                    class="min-w-[300px] md:min-w-[350px] snap-center group block bg-white rounded-3xl p-6 border border-slate-200 hover:border-{{ $theme['bg'] }}-400 hover:shadow-xl transition-all duration-300 cursor-pointer flex flex-col h-[400px]">

                    <div
                        class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 bg-gradient-to-br {{ $theme['gradient'] }} shadow-lg shadow-{{ $theme['bg'] }}-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>

                    <div class="mb-3">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-{{ $theme['bg'] }}-50 text-{{ $theme['bg'] }}-700">
                            {{ $tool->category->name }}
                        </span>
                    </div>

                    <h3
                        class="font-bold text-xl text-slate-900 mb-3 group-hover:text-{{ $theme['bg'] }}-600 transition-colors">
                        {{ $tool->name }}
                    </h3>

                    <p class="text-slate-500 text-sm mb-6 line-clamp-3 leading-relaxed">
                        {{ $tool->description }}
                    </p>

                    <div class="mt-auto border-t border-slate-100 pt-4 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-400">
                            {{ $tool->time_estimate ?? '5 min' }} use
                        </span>
                        <span
                            class="flex items-center text-sm font-bold text-{{ $theme['bg'] }}-600 group-hover:gap-2 transition-all">
                            Open
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="min-w-full text-center py-12">
                    <p class="text-slate-500">Tools are being loaded...</p>
                </div>
            @endforelse

            {{-- "View All" Card --}}
            <a href="{{ route('tools.index') }}"
                class="min-w-[200px] snap-center flex flex-col items-center justify-center bg-slate-100 rounded-3xl border-2 border-dashed border-slate-300 hover:border-blue-500 hover:bg-blue-50 transition-all cursor-pointer group p-6">
                <div
                    class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:scale-110 transition-all mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
                <span class="font-bold text-slate-500 group-hover:text-blue-700">View All {{ $totalTools }}
                    Tools</span>
            </a>
        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</section>
