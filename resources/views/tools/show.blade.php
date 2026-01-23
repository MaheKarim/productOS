<x-layout.app>
    <x-slot:title>{{ $tool->name }} - ProductOS</x-slot:title>

    <div class="bg-slate-50 min-h-screen pb-24">
        <!-- Hero Header with Gradient -->
        <div class="relative overflow-hidden">
            <!-- Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>
            <div class="absolute inset-0">
                <div class="absolute top-10 left-10 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-10 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]">
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">
                <!-- Breadcrumbs -->
                <nav class="flex text-sm text-blue-200/60 mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li><a href="{{ route('tools.index') }}" class="hover:text-white transition-colors">Tools</a>
                        </li>
                        <li>
                            <svg class="w-4 h-4 text-blue-300/40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </li>
                        <li><a href="{{ route('tools.category', $tool->category->slug) }}"
                                class="hover:text-white transition-colors">{{ $tool->category->name }}</a></li>
                        <li>
                            <svg class="w-4 h-4 text-blue-300/40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </li>
                        <li class="font-medium text-white">{{ $tool->name }}</li>
                    </ol>
                </nav>

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-8">
                    <div class="max-w-2xl">
                        <div class="flex items-center gap-3 mb-6">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                {{ $tool->category->name }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-white/10 text-blue-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $tool->time_estimate }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if ($tool->difficulty == 'Easy') bg-emerald-500/20 text-emerald-300
                                @elseif($tool->difficulty == 'Medium') bg-amber-500/20 text-amber-300
                                @else bg-red-500/20 text-red-300 @endif
                            ">
                                {{ $tool->difficulty }}
                            </span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                            {{ $tool->name }}
                        </h1>
                        <p class="text-xl text-blue-100/80 leading-relaxed">
                            {{ $tool->description }}
                        </p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="flex gap-6">
                        <div class="text-center px-4">
                            <div class="text-3xl font-bold text-white">{{ $tool->time_estimate }}</div>
                            <div class="text-sm text-blue-200/60 mt-1">Time Est.</div>
                        </div>
                        <div class="w-px h-16 bg-white/10"></div>
                        <div class="text-center px-4">
                            <div class="text-3xl font-bold text-white">
                                {{ is_array($tool->faqs) ? count($tool->faqs) : 0 }}</div>
                            <div class="text-sm text-blue-200/60 mt-1">FAQs</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Wave -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                    <path
                        d="M0 60L60 55C120 50 240 40 360 35C480 30 600 30 720 35C840 40 960 50 1080 52C1200 55 1320 50 1380 47L1440 45V60H0Z"
                        fill="#F8FAFC" />
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-10">

                    <!-- Calculator Interface -->
                    <section
                        class="bg-white rounded-3xl shadow-xl border border-slate-200 p-8 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-50 to-transparent rounded-bl-full opacity-60 pointer-events-none">
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </span>
                            Calculator
                        </h2>

                        @if (View::exists('tools.calculators.' . $tool->slug))
                            @include('tools.calculators.' . $tool->slug)
                        @else
                            @include('tools.calculators.cac')
                        @endif
                    </section>

                    <!-- Decision Guidance -->
                    @if ($tool->slug !== 'tam-sam-som')
                        <section
                            class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl shadow-xl p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 blur-[120px] opacity-20"></div>
                            <h2 class="text-2xl font-bold mb-8 flex items-center gap-3 relative z-10">
                                <span
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </span>
                                Decision Guidance
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                                <div>
                                    <h3 class="font-bold text-lg mb-4 text-slate-200">What to do next?</h3>
                                    <ul class="space-y-4 text-slate-400 text-sm">
                                        <li class="flex gap-3">
                                            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>If result is healthy, scale the channel immediately.</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <svg class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            <span>If borderline, optimize conversion rates before spending more.</span>
                                        </li>
                                        <li class="flex gap-3">
                                            <svg class="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span>If poor, pause spending and analyze customer acquisition
                                                funnel.</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg mb-4 text-slate-200">Industry Benchmarks</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-slate-400">B2B SaaS</span>
                                                <span class="font-mono text-white">$250 - $1,500</span>
                                            </div>
                                            <div class="w-full bg-slate-700 rounded-full h-2">
                                                <div
                                                    class="bg-gradient-to-r from-emerald-400 to-blue-500 w-2/3 h-2 rounded-full">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-slate-400">B2C App</span>
                                                <span class="font-mono text-white">$5 - $50</span>
                                            </div>
                                            <div class="w-full bg-slate-700 rounded-full h-2">
                                                <div
                                                    class="bg-gradient-to-r from-emerald-400 to-blue-500 w-1/3 h-2 rounded-full">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex justify-between text-sm mb-1">
                                                <span class="text-slate-400">E-commerce</span>
                                                <span class="font-mono text-white">$10 - $100</span>
                                            </div>
                                            <div class="w-full bg-slate-700 rounded-full h-2">
                                                <div
                                                    class="bg-gradient-to-r from-emerald-400 to-blue-500 w-1/2 h-2 rounded-full">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- Context / Guide Content -->
                    @if ($tool->content)
                        <section class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                                <span
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </span>
                                Understanding {{ $tool->name }}
                            </h2>
                            <div
                                class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-a:text-blue-600 prose-code:bg-slate-100 prose-code:px-2 prose-code:py-0.5 prose-code:rounded">
                                {!! \Illuminate\Support\Str::markdown($tool->content) !!}
                            </div>
                        </section>
                    @endif

                    <!-- FAQ Section -->
                    @if ($tool->faqs && count($tool->faqs) > 0)
                        <section class="bg-white rounded-3xl shadow-lg border border-slate-200 p-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                                <span
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 text-white flex items-center justify-center shadow-lg shadow-cyan-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </span>
                                Frequently Asked Questions
                            </h2>
                            <div class="space-y-4" x-data="{ active: null }">
                                @foreach ($tool->faqs as $index => $faq)
                                    <div
                                        class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden hover:border-blue-200 transition-colors">
                                        <button
                                            @click="active = active === {{ $index }} ? null : {{ $index }}"
                                            class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-100/50 transition-colors cursor-pointer group">
                                            <span
                                                class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors pr-4">{{ $faq['question'] }}</span>
                                            <svg class="w-5 h-5 text-slate-400 transform transition-transform flex-shrink-0"
                                                :class="{ 'rotate-180': active === {{ $index }} }"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="active === {{ $index }}"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            class="px-6 pb-6 text-slate-600 leading-relaxed">
                                            {{ $faq['answer'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">

                    <!-- Dynamic Guidance Card -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 bg-slate-50 border-b border-slate-200">
                            <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tool Guide
                            </h3>
                        </div>
                        <div class="divide-y divide-slate-100">
                            <!-- Problem Solved -->
                            <div class="p-6">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">What Problem
                                    This Solves</h4>
                                <p class="text-slate-700 text-sm leading-relaxed">
                                    {{ $tool->problem_solved ?? 'Helps quantify important metrics for data-driven decision making and strategy validation.' }}
                                </p>
                            </div>

                            <!-- When to Use -->
                            <div class="p-6 bg-blue-50/30">
                                <h4
                                    class="text-xs font-bold uppercase tracking-wider text-blue-500 mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    When to Use
                                </h4>
                                <p class="text-slate-700 text-sm leading-relaxed">
                                    {{ $tool->when_to_use ?? 'Use when you need to validate assumptions with concrete data points.' }}
                                </p>
                            </div>

                            <!-- When NOT to Use -->
                            <div class="p-6">
                                <h4
                                    class="text-xs font-bold uppercase tracking-wider text-amber-500 mb-2 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    When NOT to Use
                                </h4>
                                <p class="text-slate-700 text-sm leading-relaxed">
                                    {{ $tool->when_not_to_use ?? 'Avoid using if you lack sufficient data or are in a pure exploration phase.' }}
                                </p>
                            </div>

                            <!-- Data Required -->
                            <div class="p-6 bg-slate-50/50">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Data You'll
                                    Need</h4>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-slate-400 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-slate-700 text-sm leading-relaxed">
                                        {{ $tool->data_required ?? 'Basic metric inputs related to the tool\'s formula.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Outcome -->
                            <div class="p-6 bg-emerald-50/30">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2">What
                                    You'll Get</h4>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <p class="text-slate-900 font-medium text-sm leading-relaxed">
                                        {{ $tool->outcome ?? 'Actionable insights to drive your strategy forward.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Tools -->
                    @if ($similarTools->count() > 0)
                        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-lg">
                            <h3 class="font-bold text-lg text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                                Similar Tools
                            </h3>
                            <div class="space-y-3">
                                @foreach ($similarTools as $simTool)
                                    <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $simTool->slug]) }}"
                                        class="block p-4 rounded-2xl bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-200 transition-all group cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h4
                                                    class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                                    {{ $simTool->name }}</h4>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span
                                                        class="text-xs text-slate-500">{{ $simTool->time_estimate }}</span>
                                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                    <span
                                                        class="text-xs
                                                        @if ($simTool->difficulty == 'Easy') text-emerald-600
                                                        @elseif($simTool->difficulty == 'Medium') text-amber-600
                                                        @else text-red-600 @endif
                                                    ">{{ $simTool->difficulty }}</span>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Back to Tools -->
                    <a href="{{ route('tools.index') }}"
                        class="flex items-center justify-center gap-2 w-full py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to All Tools
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Sticky Calculate Button -->
        <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 p-4 z-50 shadow-lg">
            <button onclick="document.querySelector('.bg-white.rounded-3xl').scrollIntoView({behavior: 'smooth'})"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg cursor-pointer">
                Calculate Now
            </button>
        </div>
    </div>
</x-layout.app>
