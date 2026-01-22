<x-layout.app>
    <x-slot:title>{{ $caseStudy->title }} - Case Study</x-slot:title>

    <div class="py-24 bg-zinc-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('portfolio.index') }}" class="text-zinc-500 hover:text-primary mb-8 inline-block">&larr;
                Back to Portfolio</a>

            <div class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">
                <div class="p-8 md:p-12 border-b border-zinc-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span
                            class="bg-blue-100 text-accent px-4 py-1.5 rounded-full text-sm font-bold">{{ $caseStudy->industry }}</span>
                        <span
                            class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-sm font-bold">{{ $caseStudy->headline_metric }}</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-display font-bold text-primary mb-6">{{ $caseStudy->title }}
                    </h1>
                    <p class="text-xl text-zinc-500 leading-relaxed">
                        {{ $caseStudy->problem }}
                    </p>
                </div>

                <div class="p-8 md:p-12 space-y-12">
                    <section>
                        <h2 class="text-2xl font-bold text-primary mb-4">The Strategy</h2>
                        <div class="prose prose-lg prose-zinc max-w-none">
                            <p>{{ $caseStudy->strategy }}</p>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-2xl font-bold text-primary mb-4">Implementation</h2>
                        <ul class="space-y-4">
                            @foreach ($caseStudy->implementation ?? [] as $step)
                                <li class="flex items-start gap-3">
                                    <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-zinc-600">{{ $step }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <section class="bg-zinc-50 rounded-2xl p-8 border border-zinc-200">
                        <h2 class="text-2xl font-bold text-primary mb-6">Results</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($caseStudy->results ?? [] as $result)
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-zinc-100">
                                    <span class="font-bold text-zinc-900 block">{{ $result }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>

            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-primary mb-6">Ready to achieve similar results?</h3>
                <a href="{{ route('contact') }}"
                    class="inline-block px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-zinc-800 transition-all shadow-lg hover:shadow-xl">
                    Get in Touch
                </a>
            </div>
        </div>
    </div>
</x-layout.app>
