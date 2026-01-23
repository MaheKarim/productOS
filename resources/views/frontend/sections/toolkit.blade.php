@php
    // Pull featured tools dynamically from database
    $featuredTools = \App\Models\Tool::where('is_active', true)->with('category')->inRandomOrder()->take(6)->get();

    // Get tool categories for stats
    $toolCategories = \App\Models\ToolCategory::withCount([
        'tools' => function ($q) {
            $q->where('is_active', true);
        },
    ])->get();

    $totalTools = $toolCategories->sum('tools_count');
@endphp

<section id="toolkit" class="py-24 relative overflow-hidden bg-white">
    <!-- Background Elements -->
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute bottom-20 left-0 w-96 h-96 bg-cyan-100 rounded-full blur-3xl opacity-30"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-100 text-blue-600 rounded-full text-sm font-semibold mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                </svg>
                Free PM Tools
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                Tools <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">I've
                    Built</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Professional calculators and frameworks I created from real PM challenges.
                <span class="font-semibold text-blue-600">100% free for the community.</span>
            </p>
        </div>

        <!-- Tools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
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
                    class="group block bg-white rounded-2xl p-6 border border-slate-200 hover:border-{{ $theme['bg'] }}-400 hover:shadow-xl hover:shadow-{{ $theme['bg'] }}-500/10 transition-all duration-300 cursor-pointer transform hover:-translate-y-1">

                    <!-- Tool Icon -->
                    <div
                        class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 bg-gradient-to-br {{ $theme['gradient'] }} shadow-lg shadow-{{ $theme['bg'] }}-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>

                    <!-- Category Badge -->
                    <div class="mb-3">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $theme['bg'] }}-100 text-{{ $theme['bg'] }}-700">
                            {{ $tool->category->name }}
                        </span>
                    </div>

                    <!-- Tool Name -->
                    <h3
                        class="font-bold text-xl text-slate-900 mb-2 group-hover:text-{{ $theme['bg'] }}-600 transition-colors">
                        {{ $tool->name }}
                    </h3>

                    <!-- Description -->
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">
                        {{ $tool->description }}
                    </p>

                    <!-- Meta -->
                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $tool->time_estimate }}
                            </span>
                            <span
                                class="inline-flex items-center text-xs font-bold px-2.5 py-1 rounded-lg
                                @if ($tool->difficulty === 'Easy') bg-emerald-100 text-emerald-700
                                @elseif($tool->difficulty === 'Medium') bg-amber-100 text-amber-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ $tool->difficulty }}
                            </span>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-{{ $theme['bg'] }}-500 transition-colors transform group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </a>
            @empty
                <!-- Fallback if no tools in DB -->
                <div class="col-span-3 text-center py-12">
                    <p class="text-slate-500">Tools are being loaded...</p>
                </div>
            @endforelse
        </div>

        <!-- View All Tools CTA -->
        <div class="text-center">
            <a href="{{ route('tools.index') }}"
                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all hover:shadow-lg hover:shadow-blue-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Explore All {{ $totalTools }} Tools
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>

        <!-- Connection to PM Work -->
        <div
            class="mt-16 bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 rounded-3xl p-8 md:p-12 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Built from Real PM Challenges</h3>
                    <p class="text-blue-100/80 max-w-xl">
                        Every tool here was born from actual product problems I faced. They're battle-tested, not
                        theoretical.
                    </p>
                </div>
                <a href="#portfolio"
                    class="shrink-0 px-6 py-3 bg-white text-slate-900 font-bold rounded-xl hover:bg-blue-50 transition-colors flex items-center gap-2">
                    See the Case Studies
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
