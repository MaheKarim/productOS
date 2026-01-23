<x-layout.app>
    <x-slot:title>{{ $category->name }} Tools - ProductOS</x-slot:title>

    @php
        // Category theme configuration
        $themes = [
            'strategy-validation' => [
                'gradient' => 'from-emerald-600 via-teal-600 to-emerald-700',
                'accent' => 'emerald',
                'light' => 'emerald-100',
                'orb' => 'emerald-500',
            ],
            'saas-metrics' => [
                'gradient' => 'from-blue-600 via-indigo-600 to-blue-700',
                'accent' => 'blue',
                'light' => 'blue-100',
                'orb' => 'blue-500',
            ],
            'prioritization' => [
                'gradient' => 'from-purple-600 via-violet-600 to-purple-700',
                'accent' => 'purple',
                'light' => 'purple-100',
                'orb' => 'purple-500',
            ],
            'validation-research' => [
                'gradient' => 'from-amber-500 via-orange-500 to-amber-600',
                'accent' => 'amber',
                'light' => 'amber-100',
                'orb' => 'amber-500',
            ],
            'execution-delivery' => [
                'gradient' => 'from-orange-500 via-red-500 to-orange-600',
                'accent' => 'orange',
                'light' => 'orange-100',
                'orb' => 'orange-500',
            ],
            'growth-engagement' => [
                'gradient' => 'from-rose-500 via-pink-500 to-rose-600',
                'accent' => 'rose',
                'light' => 'rose-100',
                'orb' => 'rose-500',
            ],
        ];
        $theme = $themes[$category->slug] ?? [
            'gradient' => 'from-slate-600 via-slate-700 to-slate-800',
            'accent' => 'slate',
            'light' => 'slate-100',
            'orb' => 'slate-500',
        ];
    @endphp

    <div x-data="categoryPage()" class="min-h-screen">
        <!-- Hero Section -->
        <section class="pt-28 pb-20 relative overflow-hidden">
            <!-- Animated Gradient Background -->
            <div class="absolute inset-0 bg-gradient-to-br {{ $theme['gradient'] }}"></div>

            <!-- Animated Orbs -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/5 rounded-full blur-3xl">
                </div>
            </div>

            <!-- Grid Pattern -->
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:50px_50px]">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Breadcrumb -->
                <nav class="flex items-center gap-2 text-sm text-white/60 mb-8">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('tools.index') }}" class="hover:text-white transition-colors">Tools</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-white font-medium">{{ $category->name }}</span>
                </nav>

                <!-- Header Content -->
                <div class="max-w-3xl">
                    <!-- Category Icon -->
                    <div
                        class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-6 shadow-2xl">
                        @if ($category->name == 'Strategy & Validation')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($category->name == 'SaaS Metrics')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        @elseif($category->name == 'Prioritization')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                            </svg>
                        @elseif($category->name == 'Validation & Research')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                        @elseif($category->name == 'Execution & Delivery')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @elseif($category->name == 'Growth & Engagement')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        @else
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        @endif
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                        {{ $category->name }}
                    </h1>

                    <!-- Description -->
                    <p class="text-lg md:text-xl text-white/80 mb-8 leading-relaxed">
                        {{ $category->description ?? 'Professional calculators and frameworks for ' . Str::lower($category->name) . '.' }}
                    </p>

                    <!-- Stats Badge -->
                    <div
                        class="inline-flex items-center gap-3 px-5 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-white font-bold">{{ $category->tools->count() }} tools</span>
                        </div>
                        <div class="w-px h-5 bg-white/20"></div>
                        <span class="text-white/80">Free forever</span>
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

        <!-- Search & Filters -->
        <section class="py-8 bg-white border-b border-slate-200 sticky top-16 z-40 backdrop-blur-lg bg-white/95">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <!-- Search -->
                    <div class="relative w-full md:w-96">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" x-model="searchQuery" @input="filterTools()"
                            placeholder="Search {{ Str::lower($category->name) }} tools..."
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-{{ $theme['accent'] }}-500 focus:ring-4 focus:ring-{{ $theme['accent'] }}-500/10 transition-all text-slate-700 placeholder:text-slate-400">
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-3 items-center">
                        <!-- Difficulty Filter -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500 hidden sm:inline">Difficulty:</span>
                            <div class="flex gap-1">
                                <button @click="filterDifficulty = 'all'"
                                    :class="filterDifficulty === 'all' ? 'bg-slate-900 text-white' :
                                        'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer">All</button>
                                <button @click="filterDifficulty = 'Easy'"
                                    :class="filterDifficulty === 'Easy' ? 'bg-emerald-500 text-white' :
                                        'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer">Easy</button>
                                <button @click="filterDifficulty = 'Medium'"
                                    :class="filterDifficulty === 'Medium' ? 'bg-amber-500 text-white' :
                                        'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer">Medium</button>
                                <button @click="filterDifficulty = 'Advanced'"
                                    :class="filterDifficulty === 'Advanced' ? 'bg-red-500 text-white' :
                                        'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cursor-pointer">Advanced</button>
                            </div>
                        </div>

                        <!-- Sort -->
                        <select x-model="sortBy"
                            class="px-4 py-2 rounded-lg border border-slate-200 text-sm text-slate-600 focus:border-{{ $theme['accent'] }}-500 focus:ring-2 focus:ring-{{ $theme['accent'] }}-500/20 cursor-pointer">
                            <option value="name">Sort: A-Z</option>
                            <option value="difficulty">Sort: Difficulty</option>
                            <option value="time">Sort: Quick First</option>
                        </select>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="mt-4 text-sm text-slate-500" x-show="searchQuery || filterDifficulty !== 'all'">
                    Showing <span class="font-bold text-slate-700" x-text="filteredCount"></span> of
                    {{ $category->tools->count() }} tools
                </div>
            </div>
        </section>

        <!-- Tools Grid -->
        <section class="py-16 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($category->tools as $tool)
                        <a href="{{ route('tools.show', ['category' => $category->slug, 'tool' => $tool->slug]) }}"
                            x-show="shouldShowTool('{{ $tool->name }}', '{{ $tool->description }}', '{{ $tool->difficulty }}')"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="group block bg-white rounded-2xl p-6 border border-slate-200 hover:border-{{ $theme['accent'] }}-400 hover:shadow-xl hover:shadow-{{ $theme['accent'] }}-500/10 transition-all duration-300 cursor-pointer transform hover:-translate-y-1">

                            <!-- Tool Icon -->
                            <div
                                class="w-14 h-14 rounded-xl flex items-center justify-center mb-4 bg-gradient-to-br {{ $theme['gradient'] }} shadow-lg shadow-{{ $theme['accent'] }}-500/30 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Tool Name -->
                            <h3
                                class="font-bold text-xl text-slate-900 mb-2 group-hover:text-{{ $theme['accent'] }}-600 transition-colors">
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
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
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
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-{{ $theme['accent'] }}-500 transition-colors transform group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Empty State -->
                <div x-show="filteredCount === 0" class="text-center py-16">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">No tools found</h3>
                    <p class="text-slate-500">Try adjusting your search or filter criteria.</p>
                    <button @click="searchQuery = ''; filterDifficulty = 'all'"
                        class="mt-4 px-4 py-2 bg-slate-900 text-white rounded-lg font-medium hover:bg-slate-800 transition-colors cursor-pointer">
                        Clear filters
                    </button>
                </div>
            </div>
        </section>

        <!-- Recommended Tools Section -->
        @if ($suggestedTools->count() > 0)
            <section class="py-16 bg-white border-t border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-slate-900 mb-3">You might also need</h2>
                        <p class="text-slate-500">Complementary tools from other categories</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                        @foreach ($suggestedTools as $tool)
                            @php
                                $toolTheme = $themes[$tool->category->slug] ?? [
                                    'gradient' => 'from-slate-400 to-slate-600',
                                    'accent' => 'slate',
                                ];
                            @endphp
                            <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]) }}"
                                class="group block bg-slate-50 hover:bg-white rounded-xl p-5 border border-slate-200 hover:border-{{ $toolTheme['accent'] }}-300 hover:shadow-lg transition-all duration-300 cursor-pointer">

                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center mb-3 bg-gradient-to-br {{ $toolTheme['gradient'] }}">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>

                                <h4
                                    class="font-bold text-slate-900 mb-1 group-hover:text-{{ $toolTheme['accent'] }}-600 transition-colors">
                                    {{ $tool->name }}</h4>
                                <p class="text-xs text-slate-500">{{ $tool->category->name }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Other Categories -->
        <section class="py-16 bg-slate-50 border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Explore Other Categories</h2>
                    <p class="text-slate-500">Browse tools across all product management disciplines</p>
                </div>

                <div class="flex flex-wrap justify-center gap-3">
                    @foreach ($allCategories as $cat)
                        <a href="{{ route('tools.category', $cat->slug) }}"
                            class="px-5 py-3 bg-white rounded-xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all text-slate-700 font-medium flex items-center gap-2">
                            {{ $cat->name }}
                            <span
                                class="px-2 py-0.5 bg-slate-100 rounded-md text-xs text-slate-500">{{ $cat->tools->count() }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('tools.index') }}"
                        class="inline-flex items-center gap-2 text-{{ $theme['accent'] }}-600 font-semibold hover:text-{{ $theme['accent'] }}-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to All Tools
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        function categoryPage() {
            return {
                searchQuery: '',
                filterDifficulty: 'all',
                sortBy: 'name',
                tools: @json($toolsJson),
                filteredCount: {{ $category->tools->count() }},

                filterTools() {
                    this.updateFilteredCount();
                },

                shouldShowTool(name, description, difficulty) {
                    const query = this.searchQuery.toLowerCase();
                    const matchesSearch = !query ||
                        name.toLowerCase().includes(query) ||
                        description.toLowerCase().includes(query);
                    const matchesDifficulty = this.filterDifficulty === 'all' || difficulty === this.filterDifficulty;
                    return matchesSearch && matchesDifficulty;
                },

                updateFilteredCount() {
                    const query = this.searchQuery.toLowerCase();
                    this.filteredCount = this.tools.filter(t => {
                        const matchesSearch = !query ||
                            t.name.toLowerCase().includes(query) ||
                            t.description.toLowerCase().includes(query);
                        const matchesDifficulty = this.filterDifficulty === 'all' || t.difficulty === this
                            .filterDifficulty;
                        return matchesSearch && matchesDifficulty;
                    }).length;
                }
            }
        }
    </script>
</x-layout.app>
