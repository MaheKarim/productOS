<x-layout.app>
    <x-slot:title>ProductOS</x-slot:title>

    <!-- Hero Section with Category Filter -->
    <section x-data="toolsHub()" class="pt-28 pb-12 relative overflow-hidden"
        :class="activeCategory === 'all' ? 'min-h-[70vh]' : 'min-h-[50vh]'">
        <!-- Animated Gradient Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>

        <!-- Animated Orbs -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-3xl">
            </div>
        </div>

        <!-- Grid Pattern Overlay -->
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header Content -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <!-- Badge -->
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-blue-200 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>{{ $categories->sum(fn($c) => $c->tools->count()) }}+ Free PM Tools</span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    Data-Driven
                    <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400 bg-clip-text text-transparent">
                        Decision Making</span>
                </h1>

                <!-- Description -->
                <p class="text-lg md:text-xl text-blue-100/80 mb-10 leading-relaxed">
                    Professional calculators and frameworks used by top PMs to validate strategy, optimize metrics, and
                    prioritize what matters.
                </p>

                <!-- Search Bar - Glassmorphism -->
                <div class="relative max-w-2xl mx-auto mb-10">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity">
                        </div>
                        <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-2">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 relative">
                                    <input type="text" x-model="searchQuery" @input="filterTools()"
                                        @keydown.enter="searchQuery && jumpToFirstResult()"
                                        placeholder="Search tools (CAC, RICE, A/B Test, LTV...)"
                                        class="w-full bg-transparent pl-12 pr-4 py-4 text-white placeholder:text-blue-200/50 focus:outline-none text-lg">
                                    <svg class="w-5 h-5 text-blue-300 absolute left-4 top-1/2 -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <button @click="searchQuery && jumpToFirstResult()"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-cyan-600 transition-all hover:shadow-lg hover:shadow-blue-500/25 cursor-pointer flex items-center gap-2">
                                    <span class="hidden sm:inline">Search</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Search Results Preview -->
                    <div x-show="searchQuery.length > 0 && filteredTools.length > 0"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full left-0 right-0 mt-3 bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl overflow-hidden shadow-2xl z-50">
                        <div class="p-2 max-h-64 overflow-y-auto">
                            <template x-for="tool in filteredTools.slice(0, 5)" :key="tool.slug">
                                <a :href="`/tools/${tool.categorySlug}/${tool.slug}`"
                                    class="flex items-center gap-3 p-3 hover:bg-white/10 rounded-lg transition-colors cursor-pointer group">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-white font-medium group-hover:text-blue-300 transition-colors"
                                            x-text="tool.name"></div>
                                        <div class="text-blue-200/60 text-sm" x-text="tool.category"></div>
                                    </div>
                                    <svg class="w-4 h-4 text-blue-300 opacity-0 group-hover:opacity-100 transition-opacity"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </template>
                        </div>
                        <div x-show="filteredTools.length > 5"
                            class="px-4 py-2 bg-white/5 border-t border-white/10 text-center">
                            <span class="text-blue-200/60 text-sm">+ <span x-text="filteredTools.length - 5"></span>
                                more results</span>
                        </div>
                    </div>
                </div>

                <!-- Category Filter Buttons -->
                <div class="flex flex-wrap justify-center gap-3">
                    <!-- All Button -->
                    <button @click="setCategory('all')"
                        :class="activeCategory === 'all'
                            ?
                            'bg-gradient-to-r from-blue-500 to-cyan-500 text-white border-transparent shadow-lg shadow-blue-500/25' :
                            'bg-white/5 text-blue-200 border-white/20 hover:bg-white/10 hover:border-white/30'"
                        class="px-5 py-2.5 rounded-xl font-semibold text-sm border backdrop-blur-sm transition-all duration-300 cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        All Tools
                        <span
                            class="bg-white/20 px-2 py-0.5 rounded-md text-xs">{{ $categories->sum(fn($c) => $c->tools->count()) }}</span>
                    </button>

                    @foreach ($categories as $category)
                        <button @click="setCategory('{{ $category->slug }}')"
                            :class="activeCategory === '{{ $category->slug }}'
                                ?
                                'bg-gradient-to-r from-blue-500 to-cyan-500 text-white border-transparent shadow-lg shadow-blue-500/25' :
                                'bg-white/5 text-blue-200 border-white/20 hover:bg-white/10 hover:border-white/30'"
                            class="px-5 py-2.5 rounded-xl font-semibold text-sm border backdrop-blur-sm transition-all duration-300 cursor-pointer flex items-center gap-2">
                            @if ($category->name == 'Strategy & Validation')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @elseif($category->name == 'SaaS Metrics')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            @elseif($category->name == 'Prioritization')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                            @elseif($category->name == 'Validation & Research')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                            @elseif($category->name == 'Execution & Delivery')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            @elseif($category->name == 'Growth & Engagement')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            @endif
                            {{ $category->name }}
                            <span
                                class="bg-white/20 px-2 py-0.5 rounded-md text-xs">{{ $category->tools->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Stats Row -->
            <div class="flex flex-wrap justify-center gap-6 md:gap-12 mt-10">
                <div class="text-center px-4">
                    <div class="text-3xl md:text-4xl font-bold text-white">
                        {{ $categories->sum(fn($c) => $c->tools->count()) }}+</div>
                    <div class="text-sm text-blue-200/60 mt-1">Free Tools</div>
                </div>
                <div class="hidden md:block w-px h-12 bg-white/10"></div>
                <div class="text-center px-4">
                    <div class="text-3xl md:text-4xl font-bold text-white">{{ $categories->count() }}</div>
                    <div class="text-sm text-blue-200/60 mt-1">Categories</div>
                </div>
                <div class="hidden md:block w-px h-12 bg-white/10"></div>
                <div class="text-center px-4">
                    <div
                        class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                        100%</div>
                    <div class="text-sm text-blue-200/60 mt-1">Free Forever</div>
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

    <script>
        function toolsHub() {
            return {
                activeCategory: 'all',
                searchQuery: '',
                allTools: @json($allToolsJson),
                filteredTools: [],

                setCategory(slug) {
                    this.activeCategory = slug;
                    this.searchQuery = '';
                    this.filteredTools = [];

                    // Scroll to tools section
                    this.$nextTick(() => {
                        document.getElementById('tools-grid')?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                },

                filterTools() {
                    if (this.searchQuery.length === 0) {
                        this.filteredTools = [];
                        return;
                    }

                    const query = this.searchQuery.toLowerCase();
                    this.filteredTools = this.allTools.filter(tool =>
                        tool.name.toLowerCase().includes(query) ||
                        tool.category.toLowerCase().includes(query) ||
                        tool.description.toLowerCase().includes(query)
                    );
                },

                jumpToFirstResult() {
                    if (this.filteredTools.length > 0) {
                        const firstTool = this.filteredTools[0];
                        window.location.href = `/tools/${firstTool.categorySlug}/${firstTool.slug}`;
                    }
                }
            }
        }
    </script>

    <!-- Tools Grid Section -->
    <section id="tools-grid" class="py-16 bg-white scroll-mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Category Label when filtered -->
            <div x-show="activeCategory !== 'all'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button @click="setCategory('all')"
                            class="p-2 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <h2 class="text-2xl font-bold text-slate-900"
                            x-text="allTools.find(t => t.categorySlug === activeCategory)?.category || 'All Tools'">
                        </h2>
                    </div>
                    <span class="text-sm text-slate-500"
                        x-text="`${allTools.filter(t => t.categorySlug === activeCategory).length} tools`"></span>
                </div>
            </div>

            <div class="space-y-16">
                @forelse($categories as $category)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $category->slug }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="category-section">
                        <!-- Category Header (only show when viewing all) -->
                        <div x-show="activeCategory === 'all'" class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center
                                @if ($category->name == 'Strategy & Validation') bg-emerald-100
                                @elseif($category->name == 'SaaS Metrics') bg-blue-100
                                @elseif($category->name == 'Prioritization') bg-purple-100
                                @elseif($category->name == 'Validation & Research') bg-amber-100
                                @elseif($category->name == 'Execution & Delivery') bg-orange-100
                                @elseif($category->name == 'Growth & Engagement') bg-rose-100
                                @else bg-slate-100 @endif
                            ">
                                @if ($category->name == 'Strategy & Validation')
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($category->name == 'SaaS Metrics')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                @elseif($category->name == 'Prioritization')
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                    </svg>
                                @elseif($category->name == 'Validation & Research')
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                @elseif($category->name == 'Execution & Delivery')
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @elseif($category->name == 'Growth & Engagement')
                                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h2>
                                <p class="text-sm text-slate-500">{{ $category->tools->count() }} tools</p>
                            </div>
                        </div>

                        <!-- Tools Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($category->tools as $tool)
                                <a href="{{ route('tools.show', ['category' => $category->slug, 'tool' => $tool->slug]) }}"
                                    class="group block bg-white rounded-2xl p-6 border border-slate-200 hover:border-blue-400 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 cursor-pointer transform hover:-translate-y-1">
                                    <!-- Tool Icon -->
                                    <div
                                        class="w-12 h-12 rounded-xl flex items-center justify-center mb-4
                                        @if ($category->name == 'Strategy & Validation') bg-gradient-to-br from-emerald-400 to-emerald-600
                                        @elseif($category->name == 'SaaS Metrics') bg-gradient-to-br from-blue-400 to-blue-600
                                        @elseif($category->name == 'Prioritization') bg-gradient-to-br from-purple-400 to-purple-600
                                        @elseif($category->name == 'Validation & Research') bg-gradient-to-br from-amber-400 to-amber-600
                                        @elseif($category->name == 'Execution & Delivery') bg-gradient-to-br from-orange-400 to-orange-600
                                        @elseif($category->name == 'Growth & Engagement') bg-gradient-to-br from-rose-400 to-rose-600
                                        @else bg-gradient-to-br from-slate-400 to-slate-600 @endif
                                        shadow-lg
                                        @if ($category->name == 'Strategy & Validation') shadow-emerald-500/30
                                        @elseif($category->name == 'SaaS Metrics') shadow-blue-500/30
                                        @elseif($category->name == 'Prioritization') shadow-purple-500/30
                                        @elseif($category->name == 'Validation & Research') shadow-amber-500/30
                                        @elseif($category->name == 'Execution & Delivery') shadow-orange-500/30
                                        @elseif($category->name == 'Growth & Engagement') shadow-rose-500/30
                                        @else shadow-slate-500/30 @endif
                                    ">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>

                                    <h3
                                        class="font-bold text-lg text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        {{ $tool->name }}
                                    </h3>
                                    <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                                        {{ $tool->description }}
                                    </p>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $tool->time_estimate }}
                                            </span>
                                            <span
                                                class="inline-flex items-center text-xs font-medium px-2.5 py-1 rounded-lg
                                                @if ($tool->difficulty === 'Easy') bg-emerald-100 text-emerald-700
                                                @elseif($tool->difficulty === 'Medium') bg-amber-100 text-amber-700
                                                @else bg-red-100 text-red-700 @endif
                                            ">
                                                {{ $tool->difficulty }}
                                            </span>
                                        </div>
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-colors transform group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-slate-500 text-lg">No tools found. Please run the seeders.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layout.app>
