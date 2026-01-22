<x-layout.app>
    <x-slot:title>{{ $tool->name }} - ProductOS</x-slot:title>

    <div class="bg-zinc-50 min-h-screen pb-24">
        <!-- 1. Tool Header -->
        <div class="bg-white border-b border-zinc-200 pt-32 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumbs -->
                <nav class="flex text-sm text-zinc-500 mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('tools.index') }}" class="hover:text-primary transition-colors">Tools</a>
                        </li>
                        <li><svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg></li>
                        <li><a href="{{ route('tools.category', $tool->category->slug) }}"
                                class="hover:text-primary transition-colors">{{ $tool->category->name }}</a></li>
                        <li><svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg></li>
                        <li class="font-medium text-zinc-900">{{ $tool->name }}</li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-accent border border-blue-100 uppercase tracking-wide">
                                {{ $tool->category->name }}
                            </span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 border border-zinc-200">
                                ⏱ {{ $tool->time_estimate }}
                            </span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-display font-bold text-primary mb-4">
                            {{ $tool->name }}
                        </h1>
                        <p class="text-xl text-zinc-600 max-w-2xl leading-relaxed">
                            {{ $tool->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Main Content (Calculator + Guidance) -->
                <div class="lg:col-span-8 space-y-12">

                    <!-- 2. Calculator Interface -->
                    <section class="bg-white rounded-3xl shadow-sm border border-zinc-200 p-8 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full opacity-50 pointer-events-none">
                        </div>
                        <h2 class="text-2xl font-display font-bold text-primary mb-8 flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg bg-blue-100 text-accent flex items-center justify-center text-sm">🧮</span>
                            Calculator
                        </h2>

                        <!-- Dynamic Component Loading based on Slug -->
                        @if (View::exists('tools.calculators.' . $tool->slug))
                            @include('tools.calculators.' . $tool->slug)
                        @else
                            @include('tools.calculators.cac') <!-- Fallback for demo -->
                        @endif
                    </section>

                    <!-- 3. Decision Guidance -->
                    <section class="bg-zinc-900 text-white rounded-3xl shadow-lg p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-accent blur-[100px] opacity-20"></div>
                        <h2 class="text-2xl font-display font-bold mb-6 flex items-center gap-2 relative z-10">
                            <span class="text-accent">⚡</span> Decision Guidance
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            <div>
                                <h3 class="font-bold text-lg mb-3 text-zinc-200">What to do next?</h3>
                                <ul class="space-y-3 text-zinc-400 text-sm">
                                    <li class="flex gap-2">
                                        <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>If result is healthy, scale the channel immediately.</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <span>If borderline, optimize conversion rates before spending more.</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-3 text-zinc-200">Benchmarks</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-400">B2B SaaS</span>
                                        <span class="font-mono text-white">$250 - $1,500</span>
                                    </div>
                                    <div class="w-full bg-zinc-800 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-green-400 to-accent w-2/3 h-1.5 rounded-full">
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-400">B2C App</span>
                                        <span class="font-mono text-white">$5 - $50</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- 4. Context / Guide -->
                    <section class="prose prose-lg prose-zinc max-w-none">
                        <h2 class="text-primary font-display font-bold">Understanding {{ $tool->name }}</h2>
                        {!! \Illuminate\Support\Str::markdown($tool->content ?? 'Content coming soon...') !!}
                    </section>

                    <!-- 5. FAQ -->
                    <section class="border-t border-zinc-200 pt-12">
                        <h2 class="text-2xl font-display font-bold text-primary mb-8">Frequently Asked Questions</h2>
                        <div class="space-y-6" x-data="{ active: null }">
                            @foreach (['How often should I calculate this?', 'What is a "good" number?', 'Common mistakes to avoid?'] as $index => $question)
                                <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden">
                                    <button
                                        @click="active = active === {{ $index }} ? null : {{ $index }}"
                                        class="w-full flex items-center justify-between p-6 text-left hover:bg-zinc-50 transition-colors">
                                        <span class="font-bold text-zinc-900">{{ $question }}</span>
                                        <svg class="w-5 h-5 text-zinc-400 transform transition-transform"
                                            :class="{ 'rotate-180': active === {{ $index }} }" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="active === {{ $index }}"
                                        class="p-6 pt-0 text-zinc-600 text-sm leading-relaxed" x-collapse>
                                        This provides a senior PM perspective on {{ Str::lower($question) }}. It
                                        focuses on outcomes rather than just output.
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">

                    <!-- 7. CTA (Case Study) -->
                    <div
                        class="bg-primary text-white p-8 rounded-3xl relative overflow-hidden text-center sticky top-24">
                        <div
                            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20">
                        </div>
                        <div class="relative z-10">
                            <div class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-4">See it in action
                            </div>
                            <h3 class="text-2xl font-display font-bold mb-4">
                                How we used {{ $tool->name }} to grow by
                                {{ $relatedCaseStudy->headline_metric ?? '300%' }}
                            </h3>
                            @if ($relatedCaseStudy)
                                <a href="{{ route('portfolio.show', $relatedCaseStudy->slug) }}"
                                    class="inline-block w-full bg-white text-primary font-bold py-4 rounded-xl hover:bg-zinc-100 transition-colors shadow-lg">
                                    Read Case Study
                                </a>
                            @else
                                <a href="{{ route('contact') }}"
                                    class="inline-block w-full bg-white text-primary font-bold py-4 rounded-xl hover:bg-zinc-100 transition-colors shadow-lg">
                                    Book Advisory
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- 6. Similar Tools -->
                    <div class="bg-white border border-zinc-200 rounded-2xl p-6">
                        <h3 class="font-bold text-lg text-primary mb-4">Similar Tools</h3>
                        <div class="space-y-4">
                            @foreach ($similarTools as $simTool)
                                <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $simTool->slug]) }}"
                                    class="block p-4 rounded-xl bg-zinc-50 hover:bg-blue-50 border border-zinc-100 hover:border-blue-100 transition-all group">
                                    <h4 class="font-bold text-zinc-900 group-hover:text-accent mb-1">
                                        {{ $simTool->name }}</h4>
                                    <span class="text-xs text-zinc-500">{{ $simTool->difficulty }} •
                                        {{ $simTool->time_estimate }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Sticky Calculate Button (Optional) -->
        <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-zinc-200 p-4 z-50">
            <button @click="document.querySelector('.bg-white.rounded-3xl').scrollIntoView({behavior: 'smooth'})"
                class="w-full bg-accent text-white font-bold py-3 rounded-xl shadow-lg">
                Calculate Now
            </button>
        </div>
    </div>
</x-layout.app>
