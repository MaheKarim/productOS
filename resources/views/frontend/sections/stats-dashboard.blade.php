@php
    // Get real stats from database
    $toolCategories = \App\Models\ToolCategory::withCount([
        'tools' => function ($q) {
            $q->where('is_active', true);
        },
    ])->get();

    $totalTools = $toolCategories->sum('tools_count');
    $categoryCount = $toolCategories->count();
@endphp

<section id="stats" class="py-16 bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 1s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center" x-data="{ shown: false }" x-intersect="shown = true">
            <!-- Total Tools -->
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2" x-show="shown" x-transition>
                    {{ $totalTools }}+
                </div>
                <div class="text-blue-200/60 text-sm font-medium">Free PM Tools</div>
            </div>

            <!-- Categories -->
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2" x-show="shown" x-transition>
                    {{ $categoryCount }}
                </div>
                <div class="text-blue-200/60 text-sm font-medium">Tool Categories</div>
            </div>

            <!-- Products Shipped -->
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2" x-show="shown" x-transition>
                    15+
                </div>
                <div class="text-blue-200/60 text-sm font-medium">Products Shipped</div>
            </div>

            <!-- Users Impacted -->
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div class="text-4xl md:text-5xl font-bold text-white mb-2" x-show="shown" x-transition>
                    50k+
                </div>
                <div class="text-blue-200/60 text-sm font-medium">Users Impacted</div>
            </div>
        </div>
    </div>
</section>
