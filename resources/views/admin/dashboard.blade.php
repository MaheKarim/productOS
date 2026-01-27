@extends('admin.layout')

@section('title', 'Dashboard')

@section('page-title', 'Overview')

@section('content')
    {{-- Top Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            $displayStats = [
                [
                    'label' => 'Total Services',
                    'count' => $stats['services'],
                    'icon' => 'zap',
                    'color' => 'amber',
                    'route' => 'admin.services.index',
                ],
                [
                    'label' => 'Directory Items',
                    'count' => $stats['directory_items'],
                    'icon' => 'folder-open',
                    'color' => 'blue',
                    'route' => 'admin.directory.index',
                ],
                [
                    'label' => 'Pending Reviews',
                    'count' => $stats['directory_pending'],
                    'icon' => 'clock',
                    'color' => 'orange',
                    'bg_class' => 'bg-orange-500/10',
                    'text_class' => 'text-orange-600',
                    'route' => 'admin.directory.index',
                ],
                [
                    'label' => 'Directory Clicks',
                    'count' => $stats['directory_clicks'],
                    'icon' => 'mouse-pointer',
                    'color' => 'emerald',
                    'route' => 'admin.directory.analytics',
                ],
            ];
        @endphp

        @foreach ($displayStats as $stat)
            <div
                class="group bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-glass transition-soft hover:-translate-y-1 hover:shadow-premium relative overflow-hidden">
                {{-- Decorative Blob --}}
                <div
                    class="absolute top-0 right-0 w-24 h-24 {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/5' : 'bg-slate-100' }} rounded-bl-full translate-x-4 -translate-y-4 transition-soft group-hover:scale-110">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div
                        class="w-12 h-12 rounded-2xl {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/10' : 'bg-slate-100' }} flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}"
                            class="{{ isset($stat['color']) ? 'text-' . $stat['color'] . '-600' : 'text-slate-500' }} w-6 h-6"></i>
                    </div>
                    <a href="{{ route($stat['route']) }}"
                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </a>
                </div>

                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stat['count'] }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Middle Section: Secondary Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Secondary Metrics & Health (Full Width now) --}}
        <div class="lg:col-span-3 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Featured Directory Items --}}
                <div
                    class="relative group bg-[#0f172a] rounded-[2rem] p-6 border border-amber-500/10 overflow-hidden hover:border-amber-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_-5px_rgba(245,158,11,0.15)]">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-amber-500/10 transition-colors">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="star" class="text-amber-500 w-6 h-6"></i>
                            </div>
                            <h4 class="text-xs font-bold text-amber-500 uppercase tracking-widest mb-1">Directory</h4>
                            <p class="text-3xl font-black text-white tracking-tight">{{ $stats['directory_featured'] }}</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Featured across platform</p>
                        </div>
                        <a href="{{ route('admin.directory.index', ['featured' => 1]) }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 hover:border-amber-500/30 transition-all group/link">
                            <span class="text-xs font-bold text-slate-300 group-hover/link:text-white">View Featured</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-500 group-hover/link:text-amber-500 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Impact Projects --}}
                <div
                    class="relative group bg-[#0f172a] rounded-[2rem] p-6 border border-emerald-500/10 overflow-hidden hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_-5px_rgba(16,185,129,0.15)]">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-emerald-500/10 transition-colors">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="briefcase" class="text-emerald-500 w-6 h-6"></i>
                            </div>
                            <h4 class="text-xs font-bold text-emerald-500 uppercase tracking-widest mb-1">Projects</h4>
                            <p class="text-3xl font-black text-white tracking-tight">{{ $stats['projects'] }}</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Active implementations</p>
                        </div>
                        <a href="{{ route('admin.projects.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 hover:border-emerald-500/30 transition-all group/link">
                            <span class="text-xs font-bold text-slate-300 group-hover/link:text-white">Manage
                                Projects</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-500 group-hover/link:text-emerald-500 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Testimonials --}}
                <div
                    class="relative group bg-[#0f172a] rounded-[2rem] p-6 border border-violet-500/10 overflow-hidden hover:border-violet-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_-5px_rgba(139,92,246,0.15)]">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-violet-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-violet-500/10 transition-colors">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="message-square" class="text-violet-500 w-6 h-6"></i>
                            </div>
                            <h4 class="text-xs font-bold text-violet-500 uppercase tracking-widest mb-1">Testimonials</h4>
                            <p class="text-3xl font-black text-white tracking-tight">{{ $stats['testimonials'] }}</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Client feedback</p>
                        </div>
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 hover:border-violet-500/30 transition-all group/link">
                            <span class="text-xs font-bold text-slate-300 group-hover/link:text-white">View All</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-500 group-hover/link:text-violet-500 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Footer Config --}}
                <div
                    class="relative group bg-[#0f172a] rounded-[2rem] p-6 border border-pink-500/10 overflow-hidden hover:border-pink-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_-5px_rgba(236,72,153,0.15)]">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-pink-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-pink-500/10 transition-colors">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-pink-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="settings-2" class="text-pink-500 w-6 h-6"></i>
                            </div>
                            <h4 class="text-xs font-bold text-pink-500 uppercase tracking-widest mb-1">Configuration</h4>
                            <p class="text-3xl font-black text-white tracking-tight">{{ $stats['footer'] }}</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">System settings</p>
                        </div>
                        <a href="{{ route('admin.footer.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 hover:border-pink-500/30 transition-all group/link">
                            <span class="text-xs font-bold text-slate-300 group-hover/link:text-white">Manage</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-500 group-hover/link:text-pink-500 transition-colors"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- AI Provider Health Section --}}
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <i data-lucide="activity" class="w-5 h-5 text-indigo-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 tracking-tight">AI Provider Health</h3>
                    </div>
                    <a href="{{ route('admin.ai-providers.health') }}"
                        class="text-xs font-bold text-indigo-600 uppercase tracking-widest px-4 py-2 bg-indigo-50 rounded-full hover:bg-indigo-100 transition-colors">
                        Full Dashboard
                    </a>
                </div>

                {{-- AI Stats Cards --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    {{-- Total Requests --}}
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="zap" class="w-4 h-4 text-indigo-500"></i>
                            <span class="text-xs font-medium text-slate-500 uppercase">Requests</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900">{{ number_format($aiStats['total_requests']) }}</p>
                        <p class="text-xs text-slate-400 mt-1">Last 24h</p>
                    </div>

                    {{-- Avg Response Time --}}
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="timer" class="w-4 h-4 text-teal-500"></i>
                            <span class="text-xs font-medium text-slate-500 uppercase">Avg Time</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900">{{ $aiStats['avg_response_time'] }}<span
                                class="text-sm text-slate-400">ms</span></p>
                        <p class="text-xs text-slate-400 mt-1">Response</p>
                    </div>

                    {{-- Error Rate --}}
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="{{ $aiStats['error_rate'] > 5 ? 'alert-triangle' : 'check-circle' }}"
                                class="w-4 h-4 {{ $aiStats['error_rate'] > 5 ? 'text-red-500' : 'text-emerald-500' }}"></i>
                            <span class="text-xs font-medium text-slate-500 uppercase">Error Rate</span>
                        </div>
                        <p
                            class="text-2xl font-bold {{ $aiStats['error_rate'] > 5 ? 'text-red-600' : 'text-slate-900' }}">
                            {{ $aiStats['error_rate'] }}<span class="text-sm text-slate-400">%</span></p>
                        <p class="text-xs text-slate-400 mt-1">{{ $aiStats['error_count'] }} errors</p>
                    </div>

                    {{-- Total Cost --}}
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-amber-500"></i>
                            <span class="text-xs font-medium text-slate-500 uppercase">Cost</span>
                        </div>
                        <p class="text-2xl font-bold text-slate-900">${{ number_format($aiStats['total_cost'], 2) }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ number_format($aiStats['total_tokens']) }} tokens</p>
                    </div>
                </div>

                {{-- Provider Performance --}}
                @if (count($providerStats) > 0)
                    <div class="border-t border-slate-100 pt-4">
                        <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-3">By Provider</h4>
                        <div class="space-y-2">
                            @foreach ($providerStats as $provider)
                                <div
                                    class="flex items-center justify-between p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm
                                            {{ $provider['slug'] === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : '' }}
                                            {{ $provider['slug'] === 'groq' ? 'bg-gradient-to-br from-orange-500 to-amber-500' : '' }}
                                            {{ $provider['slug'] === 'zai' ? 'bg-gradient-to-br from-cyan-500 to-blue-600' : '' }}
                                            {{ $provider['slug'] === 'gemini' ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : '' }}">
                                            <i data-lucide="cpu" class="w-4 h-4 text-white"></i>
                                        </div>
                                        <span class="font-semibold text-slate-700">{{ $provider['name'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm">
                                        <span class="text-slate-600">{{ $provider['total_requests'] }} req</span>
                                        <span
                                            class="font-mono text-slate-500">{{ $provider['avg_response_time'] }}ms</span>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs font-medium
                                            {{ $provider['error_rate'] > 5 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ $provider['error_rate'] }}%
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="border-t border-slate-100 pt-6 text-center">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="inbox" class="w-6 h-6 text-slate-300"></i>
                        </div>
                        <p class="text-slate-500 text-sm">No AI requests logged yet.</p>
                        <p class="text-slate-400 text-xs mt-1">Data will appear as requests are made.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Groq Neural Link Analytics (Live Connection Style - Full Width) --}}
    <div class="mt-8 mb-12" x-data="{
        refreshing: false,
        lastUpdated: '{{ now()->format('H:i:s') }}',
        selectedModel: '{{ $groqRateLimits['selectedModel'] }}',
        async switchModel(model) {
            this.refreshing = true;
            window.location.href = '{{ route('admin.dashboard') }}?model=' + model;
        },
        async refresh() {
            this.refreshing = true;
            try {
                const response = await fetch('{{ route('admin.dashboard') }}?model=' + this.selectedModel, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.ok) {
                    window.location.reload();
                }
            } finally {
                this.refreshing = false;
            }
        }
    }">

        @if ($groqRateLimits['available'])
            <div class="relative bg-[#050b14] rounded-[32px] border border-cyan-900/30 overflow-hidden shadow-[0_0_50px_-12px_rgba(6,182,212,0.15)] group"
                x-on:mouseenter="$refs.stream.style.animationDuration = '1s'"
                x-on:mouseleave="$refs.stream.style.animationDuration = '3s'">

                {{-- Background Tech Grid --}}
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: linear-gradient(#0891b2 1px, transparent 1px), linear-gradient(90deg, #0891b2 1px, transparent 1px); background-size: 40px 40px;">
                </div>

                <div
                    class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-500 to-transparent opacity-50">
                </div>

                <div class="relative z-10 p-8 md:p-12">
                    {{-- Header / Status Bar --}}
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-16">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div
                                    class="w-3 h-3 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-pulse">
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-mono font-bold text-cyan-50 tracking-widest uppercase">
                                    <span class="text-cyan-500">></span> Neural Uplink Is Active
                                </h3>
                                <p class="text-xs font-mono text-cyan-800 uppercase tracking-wider">Latency: <span
                                        class="text-emerald-400">24ms</span> // Secure Channel</p>
                            </div>
                        </div>

                        {{-- Model Tuner --}}
                        <div
                            class="flex items-center gap-2 p-1 bg-[#0f172a] rounded-lg border border-cyan-900/50 overflow-x-auto max-w-full">
                            {{-- GLOBAL OPTION REMOVED AS REQUESTED --}}
                            @foreach ($groqRateLimits['availableModels'] as $modelName)
                                <button @click="switchModel('{{ $modelName }}')"
                                    class="px-3 py-1.5 rounded-md text-[10px] font-mono font-bold uppercase transition-all whitespace-nowrap"
                                    :class="selectedModel === '{{ $modelName }}' ?
                                        'bg-cyan-900/50 text-cyan-300 shadow-[0_0_10px_rgba(6,182,212,0.2)] border border-cyan-500/30' :
                                        'text-slate-600 hover:text-cyan-400 hover:bg-white/5'">
                                    {{ Str::afterLast($modelName, '/') }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- The Connected Flow --}}
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-0 font-mono relative">

                        {{-- Node 1: ProductOS Core --}}
                        <div class="relative group z-20">
                            <div
                                class="w-24 h-24 rounded-2xl bg-[#0f172a] border border-cyan-800/50 flex items-center justify-center shadow-[0_0_30px_-5px_rgba(8,145,178,0.3)] relative overflow-hidden transition-all duration-300 group-hover:shadow-[0_0_50px_rgba(8,145,178,0.5)] group-hover:border-cyan-400">
                                <div class="absolute inset-0 bg-cyan-500/10 animate-pulse"></div>
                                <i data-lucide="cpu"
                                    class="w-10 h-10 text-cyan-400 transition-transform group-hover:scale-110 duration-300"></i>
                            </div>
                            <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 whitespace-nowrap text-center">
                                <p class="text-xs font-bold text-cyan-100 uppercase tracking-widest">System Core</p>
                                <p class="text-[10px] text-cyan-800">ProductOS v2.0</p>
                            </div>
                        </div>

                        {{-- Connection Line & Data Stream --}}
                        <div
                            class="flex-1 w-full lg:w-auto relative px-8 flex items-center justify-center min-h-[160px] lg:min-h-0">
                            {{-- The Physical Line --}}
                            <div class="absolute top-1/2 left-0 w-full h-[2px] bg-cyan-900/30 lg:block hidden"></div>
                            <div class="absolute left-1/2 top-0 h-full w-[2px] bg-cyan-900/30 lg:hidden block"></div>

                            {{-- Moving Packet Animation (CSS based) --}}
                            <div x-ref="stream"
                                class="absolute top-1/2 left-0 w-24 h-[2px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent blur-[2px] animate-[moveRight_3s_linear_infinite] lg:block hidden shadow-[0_0_15px_#22d3ee] z-0">
                            </div>

                            {{-- Metrics HUD Overlay --}}
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 w-full relative z-10">
                                {{-- RPM --}}
                                <div
                                    class="text-center bg-[#050b14] p-4 rounded-xl border border-dashed border-cyan-900/50 hover:border-cyan-500/50 transition-colors group/stat">
                                    <p
                                        class="text-[10px] text-cyan-600 uppercase mb-2 tracking-wider group-hover/stat:text-cyan-400 font-bold">
                                        REQ / MIN</p>
                                    <p class="text-3xl font-black text-white mb-2">
                                        {{ number_format($groqRateLimits['usage']['rpm']['current']) }}</p>
                                    <div class="w-full h-1 bg-cyan-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 shadow-[0_0_10px_rgba(6,182,212,0.8)]"
                                            style="width: {{ $groqRateLimits['usage']['rpm']['percent'] }}%"></div>
                                    </div>
                                </div>

                                {{-- TPM --}}
                                <div
                                    class="text-center bg-[#050b14] p-4 rounded-xl border border-dashed border-cyan-900/50 hover:border-amber-500/50 transition-colors group/stat">
                                    <p
                                        class="text-[10px] text-amber-600 uppercase mb-2 tracking-wider group-hover/stat:text-amber-400 font-bold">
                                        TOK / MIN</p>
                                    <p class="text-3xl font-black text-white mb-2">
                                        {{ number_format($groqRateLimits['usage']['tpm']['current']) }}</p>
                                    <div class="w-full h-1 bg-amber-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 shadow-[0_0_10px_rgba(245,158,11,0.8)]"
                                            style="width: {{ $groqRateLimits['usage']['tpm']['percent'] }}%"></div>
                                    </div>
                                </div>

                                {{-- RPD --}}
                                <div
                                    class="text-center bg-[#050b14] p-4 rounded-xl border border-dashed border-cyan-900/50 hover:border-indigo-500/50 transition-colors group/stat">
                                    <p
                                        class="text-[10px] text-indigo-500 uppercase mb-2 tracking-wider group-hover/stat:text-indigo-400 font-bold">
                                        REQ / DAY</p>
                                    <p class="text-3xl font-black text-white mb-2">
                                        {{ number_format($groqRateLimits['usage']['rpd']['current']) }}</p>
                                    <div class="w-full h-1 bg-indigo-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.8)]"
                                            style="width: {{ $groqRateLimits['usage']['rpd']['percent'] }}%"></div>
                                    </div>
                                </div>

                                {{-- TPD --}}
                                <div
                                    class="text-center bg-[#050b14] p-4 rounded-xl border border-dashed border-cyan-900/50 hover:border-emerald-500/50 transition-colors group/stat">
                                    <p
                                        class="text-[10px] text-emerald-600 uppercase mb-2 tracking-wider group-hover/stat:text-emerald-400 font-bold">
                                        TOK / DAY</p>
                                    <p class="text-3xl font-black text-white mb-2">
                                        {{ number_format($groqRateLimits['usage']['tpd']['current']) }}</p>
                                    <div class="w-full h-1 bg-emerald-900/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)]"
                                            style="width: {{ $groqRateLimits['usage']['tpd']['percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Node 2: Groq LPU --}}
                        <div class="relative group z-20">
                            <div
                                class="w-28 h-28 rounded-full bg-[#0f172a] border-2 border-orange-500/50 flex items-center justify-center shadow-[0_0_40px_-5px_rgba(249,115,22,0.4)] relative overflow-hidden group-hover:scale-105 transition-transform duration-500 group-hover:border-orange-400 group-hover:shadow-[0_0_60px_rgba(249,115,22,0.6)]">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-transparent animate-spin-slow">
                                </div>
                                {{-- Groq Logo --}}
                                <svg class="w-12 h-12 text-orange-500 drop-shadow-[0_0_8px_rgba(249,115,22,0.8)]"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L12 3Z" />
                                </svg>
                            </div>

                            {{-- Floating Model Label --}}
                            <div
                                class="absolute -top-3 -right-3 px-3 py-1 bg-gradient-to-r from-orange-600 to-red-600 text-white text-[10px] font-bold rounded-full shadow-lg border border-orange-400">
                                LIVE
                            </div>

                            <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 whitespace-nowrap text-center">
                                <p class="text-xs font-bold text-orange-100 uppercase tracking-widest">Groq LPU Cloud</p>
                                <p class="text-[10px] text-orange-600 font-mono mt-0.5">
                                    {{ isset($selectedModel) && $selectedModel !== 'all' ? Str::afterLast($selectedModel, '/') : 'Multi-Model Orbit' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @else
            <div
                class="flex items-center justify-center h-48 bg-[#050b14] rounded-[32px] border border-dashed border-slate-800">
                <div class="text-center">
                    <i data-lucide="power-off" class="w-10 h-10 text-slate-600 mx-auto mb-4"></i>
                    <p class="text-slate-500 font-mono text-sm">Signal Lost: Groq Provider Unconfigured</p>
                </div>
            </div>
        @endif

        <style>
            @keyframes moveRight {
                0% {
                    left: 0;
                    opacity: 0;
                    transform: scaleX(0.2);
                }

                20% {
                    opacity: 1;
                    transform: scaleX(1);
                }

                80% {
                    opacity: 1;
                    transform: scaleX(1);
                }

                100% {
                    left: 100%;
                    opacity: 0;
                    transform: scaleX(0.2);
                }
            }

            .animate-spin-slow {
                animation: spin 8s linear infinite;
            }
        </style>
    </div>
@endsection
