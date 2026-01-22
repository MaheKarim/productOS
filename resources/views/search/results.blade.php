<x-layout.app>
    <x-slot:title>Search Results - ProductOS</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-display font-bold text-primary mb-8">
                Search Results for "{{ $query }}"
            </h1>

            @if ($tools->count() > 0)
                <h2 class="text-xl font-bold text-zinc-700 mb-4">Tools</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach ($tools as $tool)
                        <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]) }}"
                            class="block bg-white p-6 rounded-2xl border border-zinc-200 hover:border-accent hover:shadow-lg transition-all">
                            <h3 class="font-bold text-lg text-primary mb-2">{{ $tool->name }}</h3>
                            <p class="text-sm text-zinc-500 line-clamp-2 mb-4">{{ $tool->description }}</p>
                            <span
                                class="inline-block bg-zinc-100 text-zinc-600 px-2 py-1 rounded text-xs">{{ $tool->category->name }}</span>
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($caseStudies->count() > 0)
                <h2 class="text-xl font-bold text-zinc-700 mb-4">Case Studies</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    @foreach ($caseStudies as $study)
                        <a href="{{ route('portfolio.show', $study->slug) }}"
                            class="block bg-white p-6 rounded-2xl border border-zinc-200 hover:border-accent hover:shadow-lg transition-all">
                            <h3 class="font-bold text-lg text-primary mb-2">{{ $study->title }}</h3>
                            <p class="text-sm text-zinc-500 mb-2">{{ $study->problem }}</p>
                            <span class="text-accent font-bold text-sm">{{ $study->headline_metric }}</span>
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($tools->count() === 0 && $caseStudies->count() === 0)
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-zinc-300">
                    <p class="text-zinc-500 text-lg">No results found for "{{ $query }}".</p>
                    <a href="{{ route('tools.index') }}"
                        class="mt-4 inline-block text-accent font-bold hover:underline">Browse all tools</a>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>
