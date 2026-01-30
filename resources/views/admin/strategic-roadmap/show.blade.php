@extends('admin.layout')

@section('page-title', 'Session Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.strategic-roadmap.index') }}"
            class="inline-flex items-center text-sm text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Roadmaps
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Session Info & Inputs -->
        <div class="space-y-6">
            <!-- User Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">User Details</h3>
                <div class="flex items-center mb-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                        <span
                            class="text-sm font-bold text-indigo-600">{{ substr($session->user->name ?? 'G', 0, 1) }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $session->user->name ?? 'Guest User' }}</div>
                        <div class="text-xs text-slate-500">{{ $session->user->email }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-slate-100">
                    <div>
                        <div class="text-xs text-slate-400">Status</div>
                        <div class="text-sm font-medium text-slate-900 capitalize">{{ $session->status }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Created</div>
                        <div class="text-sm font-medium text-slate-900">{{ $session->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Input Data Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Input Parameters</h3>

                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-slate-400 mb-1">Product Context</div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium">
                                {{ ucfirst($session->product_type) }}
                            </span>
                            @if ($session->product_stage)
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium">
                                    {{ ucfirst($session->product_stage) }}
                                </span>
                            @endif
                            @if ($session->level)
                                <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded text-xs font-medium">
                                    {{ ucfirst($session->level) }} Path
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($session->challenges)
                        <div>
                            <div class="text-xs text-slate-400 mb-1">Challenges</div>
                            <ul class="list-disc list-inside text-sm text-slate-700">
                                @foreach ($session->challenges as $challenge)
                                    <li>{{ ucfirst(str_replace('_', ' ', $challenge)) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($session->priorities)
                        <div>
                            <div class="text-xs text-slate-400 mb-1">Priorities</div>
                            <ol class="list-decimal list-inside text-sm text-slate-700">
                                @foreach ($session->priorities as $priority)
                                    <li>{{ ucfirst(str_replace('_', ' ', $priority)) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delete Action -->
            <div class="bg-white rounded-2xl border border-red-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-red-500 uppercase tracking-widest mb-4">Danger Zone</h3>
                <p class="text-sm text-slate-600 mb-4">Deleting this session will remove all generated content and progress
                    tracking.</p>
                <form action="{{ route('admin.strategic-roadmap.destroy', $session->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                        Delete Session
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Generated Output -->
        <div class="lg:col-span-2 space-y-6">
            @if ($session->latestOutput)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900">Generated Strategy</h3>
                        <span class="text-xs text-slate-500">Provider: {{ $session->ai_model_used ?? 'Unknown' }}</span>
                    </div>

                    <div class="p-6 space-y-8">
                        @php
                            $outputData = $session->latestOutput->getVersionForLevel($session->user_level);
                        @endphp

                        @if ($outputData)
                            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 mb-6">
                                <h4 class="font-bold text-indigo-900 mb-1">
                                    {{ $outputData['title'] ?? 'Strategic Roadmap' }}</h4>
                                <p class="text-xs text-indigo-700">Level: {{ ucfirst($session->user_level) }}</p>
                            </div>

                            <!-- Phases -->
                            @if (isset($outputData['phases']))
                                <section>
                                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Strategic
                                        Phases</h4>
                                    <div class="space-y-4">
                                        @foreach ($outputData['phases'] as $phase)
                                            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h5 class="font-bold text-slate-900">{{ $phase['title'] ?? 'Phase' }}
                                                    </h5>
                                                </div>

                                                @if (isset($phase['checkpoints']))
                                                    <ul class="space-y-2 mt-3">
                                                        @foreach ($phase['checkpoints'] as $checkpoint)
                                                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                                                <span class="text-green-500 mt-0.5">✓</span>
                                                                {{ is_array($checkpoint) ? $checkpoint['text'] ?? '' : $checkpoint }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                @if (isset($phase['initiatives']))
                                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                                                        @foreach ($phase['initiatives'] as $init)
                                                            <div
                                                                class="text-xs bg-slate-50 p-2 rounded border border-slate-100 text-slate-700">
                                                                <strong>{{ is_array($init) ? $init['title'] ?? '' : $init }}</strong>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            <!-- Metrics -->
                            @if (isset($outputData['metric_matrix']))
                                <section>
                                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Metric Matrix
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                        @foreach (['acquisition', 'activation', 'retention', 'revenue', 'referral'] as $category)
                                            @if (isset($outputData['metric_matrix'][$category]))
                                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                                    <div class="text-[10px] uppercase font-bold text-slate-400 mb-2">
                                                        {{ $category }}</div>
                                                    <div class="flex flex-col gap-1">
                                                        @foreach ($outputData['metric_matrix'][$category] as $metric)
                                                            <span
                                                                class="text-xs text-slate-700 bg-white px-1.5 py-0.5 rounded border border-slate-200">{{ $metric }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            <!-- Benchmarks -->
                            @if (isset($outputData['benchmarks']))
                                <section>
                                    <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Industry
                                        Benchmarks</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @foreach ($outputData['benchmarks'] as $key => $val)
                                            <div class="p-3 bg-white border border-slate-200 rounded-lg">
                                                <div class="text-xs font-bold text-slate-500 uppercase mb-1">
                                                    {{ str_replace('_', ' ', $key) }}</div>
                                                @if (is_array($val) && isset($val['good']))
                                                    <div class="text-xs text-emerald-600 font-bold">Good:
                                                        {{ $val['good'] }}</div>
                                                    <div class="text-xs text-amber-600">Avg: {{ $val['average'] }}</div>
                                                @else
                                                    <div class="text-sm text-slate-700">
                                                        {{ is_string($val) ? $val : json_encode($val) }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </section>
                            @endif
                        @else
                            <div class="text-center py-8 text-slate-500">
                                No generated content available for this level.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="cpu" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">No Generation Output</h3>
                    <p class="text-slate-500 max-w-sm mx-auto">This session hasn't generated a full roadmap yet, or the
                        output failed to save.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
