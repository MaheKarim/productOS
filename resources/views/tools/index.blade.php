<x-layout.app>
    <x-slot:title>PM Toolkit</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl md:text-5xl font-display font-bold text-primary mb-6">
                    Product Manager Toolkit
                </h1>
                <p class="text-xl text-zinc-600">
                    A collection of calculators, frameworks, and decision models to help you build better products.
                </p>

                <!-- Search Input -->
                <div class="mt-8 relative max-w-xl mx-auto">
                    <input type="text" placeholder="Search for tools (e.g. 'CAC', 'RICE', 'A/B Test')"
                        class="w-full pl-12 pr-4 py-4 rounded-xl border border-zinc-200 shadow-sm focus:border-accent focus:ring-accent transition-all"
                        @keydown.enter="window.location.href = '/search?q=' + $el.value">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-zinc-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="space-y-20">
                @forelse($categories as $category)
                    <section class="mb-20">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="p-3 bg-white rounded-xl shadow-sm border border-zinc-100">
                                <span class="text-2xl">
                                    @if ($category->name == 'Strategy & Validation')
                                        🎯
                                    @elseif($category->name == 'SaaS Metrics')
                                        📊
                                    @elseif($category->name == 'Prioritization')
                                        ⚖️
                                    @elseif($category->name == 'Validation & Research')
                                        🔬
                                    @else
                                        🛠
                                    @endif
                                </span>
                            </div>
                            <h2 class="text-3xl font-display font-bold text-primary">{{ $category->name }}</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($category->tools as $tool)
                                <a href="{{ route('tools.show', ['category' => $category->slug, 'tool' => $tool->slug]) }}"
                                    class="group block bg-white rounded-2xl p-6 border border-zinc-200 hover:border-accent hover:shadow-xl hover:shadow-zinc-900/5 transition-all duration-300 relative overflow-hidden">
                                    <div
                                        class="absolute top-0 right-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-2 group-hover:translate-x-0">
                                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </div>

                                    <h3
                                        class="font-bold text-lg text-primary mb-2 group-hover:text-accent transition-colors">
                                        {{ $tool->name }}
                                    </h3>
                                    <p class="text-sm text-zinc-500 mb-4 line-clamp-2">
                                        {{ $tool->description }}
                                    </p>

                                    <div class="flex items-center gap-3 mt-auto">
                                        <div
                                            class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 bg-zinc-50 px-2.5 py-1 rounded-md border border-zinc-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $tool->time_estimate }}
                                        </div>
                                        <div
                                            class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 bg-zinc-50 px-2.5 py-1 rounded-md border border-zinc-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            {{ $tool->difficulty }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="text-center py-20">
                        <p class="text-zinc-500">No tools found. Please run the seeders.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout.app>
