<section id="toolkit" class="py-32 px-8 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 gradient-mesh opacity-30"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-teal-200 rounded-full blur-3xl opacity-20 animate-pulse-slow"></div>
    <div class="absolute bottom-20 left-0 w-96 h-96 bg-primary rounded-full blur-3xl opacity-20 animate-pulse-slow">
    </div>

    <div class="max-w-[1200px] mx-auto relative z-10">
        <div class="text-center mb-20 animate-fade-in-up">
            <span
                class="inline-block py-1 px-3 rounded-full bg-teal-50 text-teal-600 text-sm font-semibold mb-4 border border-teal-100">
                Playground
            </span>
            <h2 class="text-5xl font-bold text-teal-900 mb-6 tracking-tight">Product Toolkit</h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed mb-6">
                Interactive tools and calculators I use to make data-driven decisions.
                <span class="text-primary font-medium">Free for you to use.</span>
            </p>
            <a href="{{ route('tools.index') }}"
                class="inline-flex items-center text-sm font-bold text-primary hover:text-primary-dark transition-colors cursor-pointer">
                View All Tools
                <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>

        @php
            $tools = [
                [
                    'title' => 'CAC Calculator',
                    'description' =>
                        'Calculate Customer Acquisition Cost with precision. Includes blended and paid channels.',
                    'icon' => 'fa-solid fa-chart-pie',
                    'color' => 'text-blue-500',
                    'bg' => 'bg-blue-50',
                    'link' => route('tools.index') . '#cac-calculator',
                    'badge' => 'Popular',
                ],
                [
                    'title' => 'LTV/CAC Model',
                    'description' =>
                        'Project long-term value against acquisition costs to determine unit economics health.',
                    'icon' => 'fa-solid fa-infinity',
                    'color' => 'text-purple-500',
                    'bg' => 'bg-purple-50',
                    'link' => route('tools.index') . '#ltv-calculator',
                    'badge' => 'Strategic',
                ],
                [
                    'title' => 'Prioritization Matrix',
                    'description' => 'RICE and WSJF framework implementation for feature ranking and roadmap planning.',
                    'icon' => 'fa-solid fa-list-check',
                    'color' => 'text-teal-500',
                    'bg' => 'bg-teal-50',
                    'link' => route('tools.index') . '#rice-framework',
                    'badge' => 'Essential',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($tools as $index => $tool)
                <div class="glass p-8 rounded-3xl hover-lift group relative overflow-hidden transition-all duration-300 hover:shadow-glow border-white/50"
                    style="animation-delay: {{ $index * 150 }}ms">

                    <!-- Hover text gradient effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div
                                class="w-16 h-16 rounded-2xl {{ $tool['bg'] }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                <i class="{{ $tool['icon'] }} text-2xl {{ $tool['color'] }}"></i>
                            </div>
                            @if (isset($tool['badge']))
                                <span
                                    class="px-3 py-1 bg-white/50 backdrop-blur text-xs font-semibold text-slate-600 rounded-full border border-white/60">
                                    {{ $tool['badge'] }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold text-teal-900 mb-3 group-hover:text-primary transition-colors">
                            {{ $tool['title'] }}
                        </h3>
                        <p class="text-slate-600 mb-8 leading-relaxed">
                            {{ $tool['description'] }}
                        </p>

                        <a href="{{ $tool['link'] }}"
                            class="inline-flex items-center text-sm font-bold text-teal-900 group-hover:text-primary transition-colors">
                            Try Tool
                            <i
                                class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Call to Action Banner -->
        <div class="mt-20 glass-dark rounded-3xl p-12 text-center relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-teal-400 rounded-full blur-[100px] opacity-20 animate-float">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-primary rounded-full blur-[100px] opacity-20 animate-float-delayed">
            </div>

            <div class="relative z-10">
                <h3 class="text-3xl font-bold text-white mb-4">Want a custom tool built?</h3>
                <p class="text-teal-100 mb-8 text-lg max-w-xl mx-auto">
                    I build custom decision models for product teams. Let's discuss your needs.
                </p>
                <a href="#contact"
                    class="inline-block bg-white text-teal-900 font-bold px-8 py-4 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
                    Request a Tool
                </a>
            </div>
        </div>
    </div>
</section>
