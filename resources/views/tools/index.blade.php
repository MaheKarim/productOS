<x-layout.app>
    <x-slot:title>ProductOS</x-slot:title>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 bg-gradient-to-br from-slate-50 via-blue-50/30 to-slate-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%232563EB"
            fill-opacity="0.03"%3E%3Cpath
            d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
            /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Content -->
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Free PM Tools
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight mb-6">
                        Data-Driven<br>
                        <span class="text-blue-600">Decision Making</span>
                    </h1>

                    <p class="text-xl text-slate-600 mb-8 leading-relaxed max-w-lg">
                        Professional calculators and frameworks used by top PMs to validate strategy, optimize metrics,
                        and prioritize what matters.
                    </p>

                    <!-- Stats Row -->
                    <div class="flex items-center gap-8 mb-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-slate-900">15+</div>
                            <div class="text-sm text-slate-500">Tools</div>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-slate-900">6</div>
                            <div class="text-sm text-slate-500">Categories</div>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-slate-900">100%</div>
                            <div class="text-sm text-slate-500">Free</div>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div class="relative max-w-md">
                        <input type="text" placeholder="Search tools (CAC, RICE, A/B Test...)"
                            class="w-full pl-12 pr-4 py-4 rounded-xl border border-slate-200 bg-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                            onkeydown="if(event.key === 'Enter') window.location.href = '/search?q=' + this.value">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Right: Interactive Demo Card -->
                <div class="hidden lg:block">
                    <div x-data="{ spend: 50000, customers: 125 }"
                        class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 relative">
                        <div
                            class="absolute -top-4 -right-4 bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                            Most Popular
                        </div>

                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">CAC Calculator</h3>
                                <p class="text-sm text-slate-500">Customer Acquisition Cost</p>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="text-sm font-medium text-slate-600 mb-1 block">Marketing Spend ($)</label>
                                <input type="number" x-model.number="spend"
                                    class="w-full bg-slate-50 rounded-lg p-3 border border-slate-100 text-xl font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600 mb-1 block">New Customers</label>
                                <input type="number" x-model.number="customers"
                                    class="w-full bg-slate-50 rounded-lg p-3 border border-slate-100 text-xl font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            </div>
                        </div>

                        <div class="bg-blue-600 rounded-xl p-4 text-center">
                            <div class="text-sm text-blue-100 mb-1">Your CAC</div>
                            <div class="text-3xl font-bold text-white">$<span
                                    x-text="customers > 0 ? (spend / customers).toFixed(0) : '0'"></span></div>
                        </div>

                        <a href="{{ route('tools.show', ['category' => 'saas-metrics', 'tool' => 'cac']) }}"
                            class="mt-6 flex items-center justify-center gap-2 w-full py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 hover:shadow-xl hover:shadow-blue-200 transition-all transform hover:-translate-y-1 active:scale-95 cursor-pointer">
                            Try Full Framework
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tools Grid Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-16">
                @forelse($categories as $category)
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                @if ($category->name == 'Strategy & Validation')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
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
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($category->tools as $tool)
                                <a href="{{ route('tools.show', ['category' => $category->slug, 'tool' => $tool->slug]) }}"
                                    class="group block bg-white rounded-xl p-6 border border-slate-200 hover:border-blue-300 hover:shadow-lg transition-all duration-200 cursor-pointer">
                                    <h3
                                        class="font-bold text-lg text-slate-900 mb-2 group-hover:text-blue-600 transition-colors">
                                        {{ $tool->name }}
                                    </h3>
                                    <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                                        {{ $tool->description }}
                                    </p>

                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $tool->time_estimate }}
                                        </span>
                                        <span
                                            class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">
                                            {{ $tool->difficulty }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <p class="text-slate-500">No tools found. Please run the seeders.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layout.app>
