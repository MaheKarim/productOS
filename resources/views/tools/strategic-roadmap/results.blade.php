@extends('user.layout')

@section('title', 'Strategic Roadmap Results')

@section('content')
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
    <div class="space-y-8" x-data="{
        progress: {{ $progress ? json_encode($progress->checkpoints_completed ?? []) : '[]' }},
        completionPercentage: {{ $progress ? $progress->completion_percentage : 0 }},
        toggleCheckpoint(id) {
            if (this.progress.includes(id)) {
                this.progress = this.progress.filter(x => x !== id);
            } else {
                this.progress.push(id);
            }
            fetch('{{ route('user.strategic-roadmap.progress') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ output_id: {{ $output->id }}, checkpoint_id: id, completed: this.progress.includes(id) })
            }).then(r => r.json()).then(d => { this.completionPercentage = d.completion_percentage; });
        },
        copyToClipboard(text) {
            navigator.clipboard.writeText(JSON.stringify(text, null, 2));
            alert('Raw JSON copied to clipboard!');
        }
    }">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <a href="{{ route('user.strategic-roadmap.index') }}"
                    class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 text-sm mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Create Another Roadmap
                </a>
                <h1 class="text-3xl font-bold text-slate-900">{{ $roadmapData['title'] ?? 'Strategic Roadmap' }}</h1>
                <div class="flex items-center gap-4 text-sm text-slate-500 mt-2">
                    <span
                        class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 font-medium">{{ $session->user_level_label }}</span>
                    <span
                        class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700">{{ $session->product_type_label }}</span>
                    <span>{{ $output->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-center bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                    <div class="text-2xl font-bold text-blue-600" x-text="completionPercentage + '%'"></div>
                    <div class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Progress</div>
                </div>
                <button @click="copyToClipboard({{ json_encode($roadmapData) }})"
                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Copy Raw JSON">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Metric Matrix (Universal) -->
        @if (isset($roadmapData['metric_matrix']))
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h2 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z">
                            </path>
                        </svg>
                        Interactive Metric Matrix
                    </h2>
                    <div class="text-sm text-slate-500">
                        Framework: <span
                            class="font-semibold text-indigo-600">{{ $roadmapData['metric_matrix']['primary_framework'] ?? 'Standard' }}</span>
                    </div>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                    @foreach (['acquisition', 'activation', 'retention', 'revenue', 'referral'] as $category)
                        @if (isset($roadmapData['metric_matrix'][$category]))
                            <div class="p-5 hover:bg-slate-50 transition-colors group">
                                <h3
                                    class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 group-hover:text-indigo-500 transition-colors">
                                    {{ ucfirst($category) }}</h3>
                                <ul class="space-y-2">
                                    @foreach ($roadmapData['metric_matrix'][$category] as $metric)
                                        <li class="text-sm text-slate-700 flex items-start gap-2">
                                            <div class="mt-1.5 w-1.5 h-1.5 rounded-full bg-indigo-400 flex-shrink-0"></div>
                                            {{ $metric }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Benchmarks Section (New Promise Fulfillment) -->
        @if (isset($benchmarks['industry']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach ($benchmarks['industry'] as $metricName => $ranges)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110">
                        </div>
                        <h3 class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-2 relative z-10">
                            {{ ucwords(str_replace('_', ' ', $metricName)) }}</h3>
                        <div class="space-y-3 relative z-10">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-emerald-600 font-medium">Good</span>
                                <span class="font-bold text-slate-700">{{ $ranges['good'] }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 80%"></div>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-amber-600 font-medium">Average</span>
                                <span class="text-slate-600">{{ $ranges['average'] }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-red-500 font-medium">Poor</span>
                                <span class="text-slate-500">{{ $ranges['poor'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Senior / Strategic View -->
        @if ($level === 'senior' && isset($roadmapData['vision']))
            <div class="bg-indigo-900 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg mb-8">
                <!-- ... (existing senior view code) ... -->
                <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h3 class="text-indigo-200 font-semibold mb-2">North Star Vision</h3>
                <p class="text-3xl font-bold leading-tight max-w-3xl">{{ $roadmapData['vision'] }}</p>

                @if (isset($roadmapData['metrics_portfolio']['north_star']))
                    <div
                        class="mt-8 inline-flex items-center bg-indigo-800/50 rounded-lg px-4 py-2 border border-indigo-700">
                        <span class="text-indigo-300 text-sm mr-2">Key Metric:</span>
                        <span
                            class="font-mono font-bold">{{ is_string($roadmapData['metrics_portfolio']['north_star']) ? $roadmapData['metrics_portfolio']['north_star'] : $roadmapData['metrics_portfolio']['north_star']['metric'] ?? 'N/A' }}</span>
                    </div>
                @endif
            </div>

            <!-- Financials & Org (Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- ... (existing financial/org code) ... -->
                @if (isset($roadmapData['org_design']))
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Org Design Evolution
                        </h3>
                        <ul class="space-y-3">
                            @foreach ($roadmapData['org_design'] as $item)
                                <li class="flex gap-3 text-sm text-slate-600">
                                    <span class="text-blue-500 font-bold">•</span>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (isset($roadmapData['financial_projections']))
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Financial Projections
                        </h3>
                        <ul class="space-y-3">
                            @foreach ($roadmapData['financial_projections'] as $item)
                                <li class="flex gap-3 text-sm text-slate-600">
                                    <span class="text-green-500 font-bold">$</span>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <!-- Best Practices / Pro Tips (Dynamic AI) -->
        @if (isset($roadmapData['best_practices']) && is_array($roadmapData['best_practices']))
            <div
                class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-2xl p-6 border border-teal-100 flex gap-4 mb-8">
                <div
                    class="shrink-0 w-12 h-12 bg-white rounded-full flex items-center justify-center text-teal-500 shadow-sm font-bold text-xl">
                    💡</div>
                <div>
                    <h3 class="font-bold text-teal-900 mb-1">Pro Tips for {{ ucwords($level) }} PMs</h3>
                    <p class="text-sm text-teal-700/80 mb-3">AI-curated advice for your specific product context.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($roadmapData['best_practices'] as $practice)
                            <div class="flex gap-2 items-start text-sm text-teal-800">
                                <span class="text-teal-500 mt-0.5 font-bold">✓</span>
                                {{ $practice }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Roadmap Journey Map (Vertical Timeline) -->
        <div class="relative py-8">
            <!-- Background Atmosphere -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
                <div
                    class="absolute top-0 left-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl mix-blend-multiply filter opacity-50 animate-blob">
                </div>
                <div
                    class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl mix-blend-multiply filter opacity-50 animate-blob animation-delay-2000">
                </div>
                <div
                    class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-400/20 rounded-full blur-3xl mix-blend-multiply filter opacity-50 animate-blob animation-delay-4000">
                </div>
            </div>

            <!-- Timeline Line -->
            <div
                class="absolute left-8 top-12 bottom-12 w-0.5 bg-gradient-to-b from-blue-500 via-purple-500 to-pink-500 hidden md:block">
            </div>

            <div class="space-y-12">
                @foreach ($roadmapData['phases'] as $i => $phase)
                    <div class="relative pl-0 md:pl-24" x-data="{ open: true }">

                        <!-- Timeline Node (Desktop) -->
                        <div
                            class="hidden md:absolute md:left-5 md:top-8 w-6 h-6 rounded-full bg-white border-4 border-blue-500 z-10 shadow-[0_0_15px_rgba(59,130,246,0.5)] transform transition-transform hover:scale-125 duration-300">
                        </div>

                        <!-- Glass Card -->
                        <div
                            class="group relative bg-white/70 backdrop-blur-xl border border-white/40 shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_0_rgba(31,38,135,0.1)] hover:border-white/60">

                            <!-- Phase Header -->
                            <button @click="open = !open"
                                class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg text-white transform group-hover:rotate-3 transition-transform duration-300">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider opacity-80">Phase</span>
                                        <span
                                            class="text-xl font-bold font-heading leading-none">{{ $i + 1 }}</span>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-xl font-bold text-slate-900 tracking-tight group-hover:text-blue-700 transition-colors">
                                            {{ $phase['title'] ?? 'Phase ' . ($i + 1) }}</h3>
                                        @if (isset($phase['goal']) || isset($phase['objective']))
                                            <p class="text-sm font-medium text-slate-500 mt-1 max-w-2xl">
                                                {{ $phase['goal'] ?? ($phase['objective'] ?? '') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 transition-all duration-300 group-hover:bg-blue-100"
                                    :class="{ 'rotate-180': open }">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </button>

                            <!-- Phase Content -->
                            <div x-show="open" x-collapse class="px-8 pb-8">
                                <hr class="border-slate-200/60 mb-6">

                                <!-- MID LEVEL: OKRs -->
                                @if (isset($phase['key_results']))
                                    <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach ($phase['key_results'] as $kr)
                                            <div
                                                class="relative bg-gradient-to-br from-indigo-50/50 to-white border border-indigo-100/50 rounded-xl p-5 hover:shadow-md transition-shadow">
                                                <div
                                                    class="absolute top-0 right-0 px-3 py-1 bg-indigo-100/50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider rounded-bl-xl rounded-tr-xl">
                                                    Key Result</div>
                                                <p class="font-semibold text-slate-800 pr-4">{{ $kr['text'] ?? $kr }}</p>
                                                <div
                                                    class="mt-3 flex items-center gap-2 text-sm text-indigo-600 font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    Target: {{ $kr['target'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- MID LEVEL: Initiatives & Stakeholders -->
                                @if (isset($phase['initiatives']))
                                    <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                        Strategic Initiatives
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                        @foreach ($phase['initiatives'] as $init)
                                            <div
                                                class="group/card bg-white border border-slate-100 rounded-xl p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all relative overflow-hidden">
                                                <div
                                                    class="absolute top-0 right-0 w-16 h-16 bg-blue-50/50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover/card:scale-125">
                                                </div>
                                                <h5
                                                    class="font-bold text-slate-900 mb-3 group-hover/card:text-blue-600 transition-colors relative z-10">
                                                    {{ $init['title'] ?? $init }}</h5>
                                                @if (is_array($init))
                                                    <div
                                                        class="flex flex-wrap gap-2 text-[10px] font-bold uppercase tracking-wider relative z-10">
                                                        @if (isset($init['impact']))
                                                            <span
                                                                class="px-2 py-1 bg-green-50 text-green-700 border border-green-100 rounded-md flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                                </svg>
                                                                Impact: {{ $init['impact'] }}
                                                            </span>
                                                        @endif
                                                        @if (isset($init['effort']))
                                                            <span
                                                                class="px-2 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-md flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                    </path>
                                                                </svg>
                                                                Effort: {{ $init['effort'] }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- JUNIOR LEVEL: Checkpoints -->
                                @if (isset($phase['checkpoints']))
                                    <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                        <span
                                            class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </span>
                                        Execution Plan
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($phase['checkpoints'] as $cp)
                                            @php
                                                $cpId = is_array($cp)
                                                    ? $cp['id'] ?? Str::slug($cp['text'] ?? 'cp-' . $i)
                                                    : Str::slug($cp);
                                                $cpText = is_array($cp) ? $cp['text'] ?? 'Action Item' : $cp;
                                            @endphp
                                            <label
                                                class="flex items-center gap-4 p-4 bg-slate-50/50 border border-slate-100 rounded-xl cursor-pointer hover:bg-white hover:shadow-md hover:border-blue-100 hover:scale-[1.01] transition-all duration-200 group/item">
                                                <div class="relative flex items-center justify-center">
                                                    <input type="checkbox"
                                                        class="peer h-6 w-6 cursor-pointer appearance-none rounded-lg border-2 border-slate-300 transition-all checked:border-blue-500 checked:bg-blue-500 hover:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                                        :checked="progress.includes('{{ $cpId }}')"
                                                        @change="toggleCheckpoint('{{ $cpId }}')">
                                                    <svg class="pointer-events-none absolute w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity transform scale-50 peer-checked:scale-100 duration-200"
                                                        viewBox="0 0 14 14" fill="none">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <span
                                                    class="text-slate-700 font-medium group-hover/item:text-slate-900 transition-colors"
                                                    :class="{
                                                        'line-through text-slate-400 opacity-60': progress.includes(
                                                            '{{ $cpId }}')
                                                    }">
                                                    {{ $cpText }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Risks (Universal if present) -->
                                @if (isset($phase['risks']))
                                    <div class="mt-8 pt-6 border-t border-red-100/50">
                                        <div
                                            class="flex items-start gap-4 p-4 bg-red-50/50 rounded-xl border border-red-100">
                                            <div class="p-2 bg-red-100 rounded-lg text-red-600 shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-red-700 uppercase tracking-wide mb-1">
                                                    Risk Assessment</h4>
                                                <ul class="list-disc list-inside text-sm text-red-600/80 space-y-1">
                                                    @foreach ($phase['risks'] as $risk)
                                                        <li>{{ is_array($risk) ? $risk['risk'] ?? 'Unknown Risk' : $risk }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex gap-4 pt-8 border-t border-slate-200 print:hidden">
            <button onclick="window.print()"
                class="flex-1 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print Roadmap
            </button>
            <a href="{{ route('user.strategic-roadmap.history') }}"
                class="flex-1 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                View History
            </a>
        </div>
    </div>
@endsection
