<x-layout.app>
    <x-slot:title>Portfolio - ProductOS</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-display font-bold text-primary mb-16 text-center">Case Studies</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @forelse($allCaseStudies as $study)
                    <a href="{{ route('portfolio.show', $study->slug) }}"
                        class="group block bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-zinc-200">
                        <div class="h-64 bg-zinc-200 relative overflow-hidden">
                            <!-- Placeholder for case study image -->
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-zinc-100 to-zinc-200 flex items-center justify-center text-zinc-400">
                                <span class="text-4xl">🖼️</span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="text-sm font-bold text-accent uppercase tracking-wider">{{ $study->industry }}</span>
                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">{{ $study->headline_metric }}</span>
                            </div>
                            <h2 class="text-2xl font-bold text-primary mb-4 group-hover:text-accent transition-colors">
                                {{ $study->title }}</h2>
                            <p class="text-zinc-500 mb-6 line-clamp-3">
                                {{ $study->problem }}
                            </p>
                            <span
                                class="text-primary font-bold flex items-center gap-2 group-hover:gap-4 transition-all">
                                Read Case Study
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 text-center py-20">
                        <p class="text-zinc-500">No case studies found. Please run the seeders.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout.app>
