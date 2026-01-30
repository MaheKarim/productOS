@extends('user.layout')

@section('title', 'My Roadmaps')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Your Roadmaps</h1>
                <p class="text-slate-500 mt-1">View and continue working on your roadmaps.</p>
            </div>
            <a href="{{ route('user.strategic-roadmap.index') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Roadmap
            </a>
        </div>

        @if ($sessions->count() > 0)
            <div class="space-y-3">
                @foreach ($sessions as $session)
                    <a href="{{ route('user.strategic-roadmap.results', ['id' => $session->output?->id]) }}"
                        class="block bg-white rounded-xl border border-slate-200 p-5 hover:border-blue-300 hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ $session->user_level === 'junior' ? 'bg-green-100' : ($session->user_level === 'mid' ? 'bg-blue-100' : 'bg-purple-100') }}">
                                    <svg class="w-5 h-5 {{ $session->user_level === 'junior' ? 'text-green-600' : ($session->user_level === 'mid' ? 'text-blue-600' : 'text-purple-600') }}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900 group-hover:text-blue-600">
                                        {{ $session->output?->simplified_version['title'] ?? ($session->output?->detailed_version['title'] ?? 'Strategic Roadmap') }}
                                    </h3>
                                    <div class="flex items-center gap-3 text-sm text-slate-500 mt-1">
                                        <span>{{ $session->user_level_label }}</span>
                                        <span>{{ $session->product_type_label }}</span>
                                        <span>{{ $session->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium {{ $session->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($session->status) }}</span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl border border-slate-200">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">No Roadmaps Yet</h3>
                <p class="text-slate-500 mb-4">Create your first AI-generated roadmap.</p>
                <a href="{{ route('user.strategic-roadmap.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Get
                    Started</a>
            </div>
        @endif
    </div>
@endsection
