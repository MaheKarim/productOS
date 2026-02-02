@extends('admin.layout')

@section('title', 'Page Analytics - ' . $page->name)

@section('content')
    {{-- Modern Gradient Background --}}
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-violet-50 via-purple-50 to-fuchsia-50"></div>

    <div class="container-fluid px-6 py-8">
        {{-- Header with Glassmorphism --}}
        <div class="mb-8">
            <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <a href="{{ route('admin.pages.index') }}"
                                class="text-slate-500 hover:text-violet-600 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <h1
                                class="text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                                Analytics: {{ $page->name }}
                            </h1>
                        </div>
                        <p class="text-slate-600 text-sm ml-7">
                            Performance metrics for <span
                                class="font-mono text-violet-600 bg-violet-50 px-2 py-0.5 rounded">/{{ $page->slug }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.pages.edit', $page) }}"
                            class="px-4 py-2 rounded-xl bg-white/50 hover:bg-white/80 text-slate-700 font-medium transition-all duration-200 backdrop-blur-sm border border-white/30">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                        <button onclick="window.location.reload()"
                            class="px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-medium transition-all duration-200 shadow-lg hover:shadow-violet-500/30">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Views --}}
            <div
                class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Total Views (30d)</p>
                        <h3 class="text-4xl font-bold text-violet-600">
                            {{ number_format($analytics->sum('views')) }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Unique Visitors --}}
            <div
                class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Unique Visitors</p>
                        <h3 class="text-4xl font-bold text-blue-600">
                            {{ number_format($analytics->sum('unique_visitors')) }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Avg Time on Page --}}
            <div
                class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Avg. Duration</p>
                        <h3 class="text-4xl font-bold text-emerald-600">
                            {{ $analytics->avg('avg_time_on_page') ? round($analytics->avg('avg_time_on_page')) . 's' : '0s' }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Bounce Rate --}}
            <div
                class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Avg. Bounce Rate</p>
                        <h3 class="text-4xl font-bold text-rose-500">
                            {{ $analytics->avg('bounce_rate') ? round($analytics->avg('bounce_rate')) . '%' : '0%' }}
                        </h3>
                    </div>
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-400 to-red-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-sign-out-alt text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Analytics Table --}}
        <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-2xl border border-white/30 overflow-hidden">
            <div
                class="bg-gradient-to-r from-violet-500/10 to-purple-500/10 px-6 py-4 border-b border-white/20 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Daily Performance (Last 30 Records)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-white/50 border-b border-slate-200/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Views</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Unique</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Avg
                                Time</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Bounce Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/50">
                        @forelse($analytics as $stat)
                            <tr class="hover:bg-white/60 transition-colors duration-200">
                                <td class="px-6 py-4 text-slate-700 font-medium">
                                    {{ $stat->date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">
                                    {{ number_format($stat->views) }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">
                                    {{ number_format($stat->unique_visitors) }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-600">
                                    {{ $stat->avg_time_on_page }}s
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-1 rounded-lg {{ $stat->bounce_rate > 50 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }} text-xs font-bold">
                                        {{ $stat->bounce_rate }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                                            <i class="fas fa-chart-bar text-4xl text-slate-400"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">No analytics data recorded yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
