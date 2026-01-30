@extends('user.layout')

@section('title', 'Strategic Roadmap Results')

@section('content')
    <div class="space-y-6" x-data="{
        progress: {{ $progress ? json_encode($progress->checkpoints_completed ?? []) : '[]' }},
        completionPercentage: {{ $progress ? $progress->completion_percentage : 0 }},
        toggleCheckpoint(id) {
            if (this.progress.includes(id)) { this.progress = this.progress.filter(x => x !== id); } else { this.progress.push(id); }
            fetch('{{ route('user.strategic-roadmap.progress') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ output_id: {{ $output->id }}, checkpoint_id: id, completed: this.progress.includes(id) })
            }).then(r => r.json()).then(d => { this.completionPercentage = d.completion_percentage; });
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
                <h1 class="text-2xl font-bold text-slate-900">{{ $roadmapData['title'] ?? 'Your Strategic Roadmap' }}</h1>
                <div class="flex items-center gap-4 text-sm text-slate-500 mt-1">
                    <span>{{ $session->user_level_label }}</span>
                    <span>{{ $session->product_type_label }}</span>
                    <span>{{ $output->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600" x-text="completionPercentage + '%'"></div>
                    <div class="text-xs text-slate-500">Progress</div>
                </div>
            </div>
        </div>

        @if (isset($roadmapData['summary']))
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                <p class="text-slate-700">{{ $roadmapData['summary'] }}</p>
            </div>
        @endif

        <!-- Phases -->
        @if (isset($roadmapData['phases']))
            <div class="space-y-4">
                @foreach ($roadmapData['phases'] as $i => $phase)
                    <div class="bg-white rounded-xl border border-slate-200 p-5" x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }">
                        <button @click="open = !open" class="w-full flex items-center justify-between text-left">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ $i + 1 }}</div>
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $phase['title'] ?? 'Phase ' . ($i + 1) }}
                                    </h3>
                                    @if (isset($phase['description']))
                                        <p class="text-sm text-slate-500">{{ $phase['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 transition-transform" :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="mt-4 space-y-4">
                            @if (isset($phase['objective']))
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <p class="text-sm font-medium text-blue-600 mb-1">Objective</p>
                                    <p class="text-slate-800">{{ $phase['objective'] }}</p>
                                </div>
                            @endif
                            @if (isset($phase['checkpoints']))
                                <div class="space-y-2">
                                    @foreach ($phase['checkpoints'] as $cp)
                                        <label
                                            class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg cursor-pointer hover:bg-slate-100">
                                            <input type="checkbox" class="mt-0.5"
                                                :checked="progress.includes('{{ $cp['id'] }}')"
                                                @change="toggleCheckpoint('{{ $cp['id'] }}')">
                                            <span class="text-slate-700"
                                                :class="{ 'line-through opacity-50': progress.includes('{{ $cp['id'] }}') }">{{ $cp['text'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @if (isset($phase['metrics']))
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($phase['metrics'] as $metric)
                                        <span
                                            class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded">{{ $metric }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (isset($roadmapData['next_steps']))
            <div class="bg-green-50 border border-green-100 rounded-xl p-5">
                <h3 class="font-semibold text-green-800 mb-3">Start Here</h3>
                <ul class="space-y-2">
                    @foreach ($roadmapData['next_steps'] as $i => $step)
                        <li class="flex items-start gap-2 text-green-700">
                            <span
                                class="w-5 h-5 rounded-full bg-green-200 text-green-800 text-xs flex items-center justify-center flex-shrink-0">{{ $i + 1 }}</span>
                            {{ $step }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex gap-3">
            <button onclick="window.print()"
                class="flex-1 px-4 py-2.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Print Roadmap</button>
            <a href="{{ route('user.strategic-roadmap.history') }}"
                class="flex-1 px-4 py-2.5 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700">View History</a>
        </div>
    </div>
@endsection
