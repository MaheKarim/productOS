<x-layout.app>
    <x-slot:title>{{ $category->name }} Tools - ProductOS</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <a href="{{ route('tools.index') }}"
                    class="text-zinc-500 hover:text-primary mb-4 inline-block text-sm font-medium">&larr; Back to
                    Toolkit</a>
                <h1 class="text-4xl font-display font-bold text-primary mb-2">{{ $category->name }}</h1>
                <p class="text-zinc-600">Calculators and frameworks for {{ Str::lower($category->name) }}.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($category->tools as $tool)
                    <a href="{{ route('tools.show', ['category' => $category->slug, 'tool' => $tool->slug]) }}"
                        class="group block bg-white rounded-2xl p-6 border border-zinc-200 hover:border-accent hover:shadow-xl hover:shadow-zinc-900/5 transition-all duration-300 relative overflow-hidden">
                        <h3 class="font-bold text-lg text-primary mb-2 group-hover:text-accent transition-colors">
                            {{ $tool->name }}
                        </h3>
                        <p class="text-sm text-zinc-500 mb-4 line-clamp-2">
                            {{ $tool->description }}
                        </p>

                        <div class="flex items-center gap-3 mt-auto">
                            <div
                                class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 bg-zinc-50 px-2.5 py-1 rounded-md border border-zinc-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $tool->time_estimate }}
                            </div>
                            <div
                                class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 bg-zinc-50 px-2.5 py-1 rounded-md border border-zinc-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                {{ $tool->difficulty }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layout.app>
