@extends('admin.layout')

@section('page-title', 'Session Details')

@section('content')
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
                @php
                    $content = $session->latestOutput->content;
                    // Decode if JSON string
                    if (is_string($content)) {
                        $content = json_decode($content, true);
                    }
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-900">Generated Strategy</h3>
                        <span class="text-xs text-slate-500">Provider: {{ $session->latestOutput->ai_model }}</span>
                    </div>

                    <div class="p-6 space-y-8">
                        @if (isset($content['executive_summary']))
                            <section>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">Executive Summary</h4>
                                <p class="text-slate-600 leading-relaxed">{{ $content['executive_summary'] }}</p>
                            </section>
                        @endif

                        @if (isset($content['phases']))
                            <section>
                                <h4 class="text-lg font-bold text-slate-900 mb-4">Strategic Phases</h4>
                                <div class="space-y-4">
                                    @foreach ($content['phases'] as $phase)
                                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                            <div class="flex items-center justify-between mb-2">
                                                <h5 class="font-bold text-indigo-700">{{ $phase['title'] ?? 'Phase' }}</h5>
                                                <span
                                                    class="text-xs font-medium bg-white px-2 py-1 rounded border border-slate-200">
                                                    {{ $phase['duration'] ?? 'Duration N/A' }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-slate-600 mb-3">{{ $phase['objective'] ?? '' }}</p>

                                            @if (isset($phase['action_items']))
                                                <div class="space-y-1">
                                                    @foreach ($phase['action_items'] as $item)
                                                        <div class="flex items-start gap-2 text-sm text-slate-700">
                                                            <i data-lucide="check"
                                                                class="w-4 h-4 text-green-500 mt-0.5 shrink-0"></i>
                                                            <span>{{ $item }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        @if (isset($content['metrics']))
                            <section>
                                <h4 class="text-lg font-bold text-slate-900 mb-4">Key Metrics</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($content['metrics'] as $metric)
                                        <div class="flex items-start gap-3 p-3 bg-white border border-slate-100 rounded-lg">
                                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900">{{ $metric['name'] ?? 'Metric' }}
                                                </div>
                                                <div class="text-xs text-slate-500">{{ $metric['description'] ?? '' }}
                                                </div>
                                                <div class="mt-1 text-xs font-bold text-indigo-600">Target:
                                                    {{ $metric['target'] ?? '-' }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
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
