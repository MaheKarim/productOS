@extends('user.layout')

@section('title', 'ICP Generator')
@section('header', 'ICP Generator')

@section('content')
    {{-- Hero Section --}}
    <div class="relative mb-8 rounded-2xl overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-700"></div>
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzBoLTJ2LTJoMnYyem0wLTRoLTJ2LTJoMnYyem0tNC00aC0ydi0yaDJ2MnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-30">
        </div>

        {{-- Content --}}
        <div class="relative px-8 py-12 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-4">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                AI-Powered ICP Builder
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">
                Ideal Customer Profile Generator
            </h2>
            <p class="text-purple-100 text-lg mb-8 max-w-xl mx-auto">
                Build detailed buyer personas, pain points, and GTM strategies in minutes with AI.
            </p>

            {{-- CTA Button --}}
            <a href="{{ route('icp-builder.create') }}"
                class="inline-flex items-center gap-2 px-8 py-3 bg-white text-purple-700 font-bold rounded-xl hover:bg-purple-50 transition-all shadow-xl cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New ICP
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    @if (!$icps->isEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Projects</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $icps->count() }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Completed</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $icps->where('status', 'completed')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Last Created</p>
                        <p class="text-2xl font-bold text-fuchsia-600">
                            {{ $icps->first()?->created_at->diffForHumans() ?? 'N/A' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-fuchsia-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Projects List --}}
    @if ($icps->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-purple-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="1.5"></circle>
                    <circle cx="12" cy="12" r="6" stroke-width="1.5"></circle>
                    <circle cx="12" cy="12" r="2" stroke-width="1.5"></circle>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">No ICPs Created Yet</h3>
            <p class="text-slate-500 mb-6">Create your first Ideal Customer Profile to get started.</p>
            <a href="{{ route('icp-builder.create') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 text-white font-semibold rounded-lg hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Your First ICP
            </a>
        </div>
    @else
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-900">Your Projects</h3>
            <span class="text-sm text-slate-500">{{ $icps->count() }} {{ Str::plural('project', $icps->count()) }}</span>
        </div>

        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($icps as $icp)
                <a href="{{ route('icp-builder.show', $icp) }}"
                    class="group bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 cursor-pointer">

                    {{-- Card Header with Gradient --}}
                    <div class="relative h-24 bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500 p-4">
                        <div
                            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzBoLTJ2LTJoMnYyem0wLTRoLTJ2LTJoMnYyem0tNC00aC0ydi0yaDJ2MnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-30">
                        </div>
                        <div class="relative flex items-start justify-between">
                            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                    <circle cx="12" cy="12" r="6" stroke-width="2"></circle>
                                    <circle cx="12" cy="12" r="2" stroke-width="2"></circle>
                                </svg>
                            </div>
                            <span
                                class="px-2 py-1 text-xs font-bold rounded {{ $icp->status === 'completed' ? 'bg-emerald-500 text-white' : 'bg-white/20 text-white backdrop-blur' }}">
                                {{ ucfirst($icp->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-4">
                        <h3
                            class="font-semibold text-slate-900 line-clamp-1 group-hover:text-purple-600 transition-colors mb-2">
                            {{ $icp->project_name }}
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-2 mb-3">
                            {{ Str::limit($icp->input_data['product_description'] ?? 'No description provided', 80) }}
                        </p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-400">{{ $icp->created_at->format('M d, Y') }}</span>
                            <span
                                class="flex items-center gap-1 text-purple-600 font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                View
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
