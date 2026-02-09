@extends('admin.layout')

@section('title', 'Page & Credit Management')
@section('page-title', 'Page & Credit Management')

@section('content')
    {{-- Modern Gradient Background --}}
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-violet-50 via-purple-50 to-fuchsia-50"></div>

    <div class="container-fluid px-6 py-8" x-data="{ tab: 'pages' }">
        {{-- Header with Glassmorphism --}}
        <div class="mb-8">
            <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent mb-2">
                            Management Console
                        </h1>
                        <p class="text-slate-600 text-sm">Manage frontend pages, SEO, and feature credit costs</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="bg-slate-100/50 p-1 rounded-xl flex items-center border border-white/30 backdrop-blur-sm">
                            <button @click="tab = 'pages'"
                                :class="{ 'bg-white shadow-sm text-violet-600': tab === 'pages', 'text-slate-500 hover:text-slate-700': tab !== 'pages' }"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                                <i class="fas fa-file-alt mr-2"></i>Pages
                            </button>
                            <button @click="tab = 'features'"
                                :class="{ 'bg-white shadow-sm text-violet-600': tab === 'features', 'text-slate-500 hover:text-slate-700': tab !== 'features' }"
                                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200">
                                <i class="fas fa-coins mr-2"></i>Credits
                            </button>
                        </div>
                        <button onclick="window.location.reload()"
                            class="px-4 py-2 rounded-xl bg-white/50 hover:bg-white/80 text-slate-700 font-medium transition-all duration-200 backdrop-blur-sm border border-white/30 cursor-pointer">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 backdrop-blur-lg bg-emerald-500/90 text-white rounded-2xl shadow-lg border border-white/20 p-4 animate-fade-in">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- PAGES TAB --}}
        <div x-show="tab === 'pages'" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">
            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Active Pages --}}
                <div
                    class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Active Pages</p>
                            <h3 class="text-4xl font-bold text-emerald-600">
                                {{ $pages->where('is_active', true)->count() }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Inactive Pages --}}
                <div
                    class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Inactive Pages</p>
                            <h3 class="text-4xl font-bold text-slate-500">
                                {{ $pages->where('is_active', false)->count() }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-400 to-slate-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-times-circle text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Avg SEO Score --}}
                <div
                    class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Avg SEO Score</p>
                            <h3 class="text-4xl font-bold text-violet-600">
                                {{ round($pages->avg(fn($p) => $p->seoMetadata?->seo_score ?? 0)) }}
                                <span class="text-xl text-slate-400">/100</span>
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-search text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                {{-- In Navigation --}}
                <div
                    class="group backdrop-blur-lg bg-white/60 hover:bg-white/80 rounded-2xl shadow-lg hover:shadow-2xl border border-white/30 p-6 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">In Navigation</p>
                            <h3 class="text-4xl font-bold text-blue-600">
                                {{ $pages->where('show_in_navigation', true)->count() }}
                            </h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bars text-white text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pages Table with Glassmorphism --}}
            <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-2xl border border-white/30 overflow-hidden">
                {{-- Table Header --}}
                <div class="bg-gradient-to-r from-violet-500/10 to-purple-500/10 px-6 py-4 border-b border-white/20">
                    <h3 class="text-lg font-bold text-slate-800">All Pages</h3>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/50 border-b border-slate-200/50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Page Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Navigation
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    SEO Score
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Views (30d)
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/50">
                            @forelse($pages as $page)
                                <tr class="hover:bg-white/60 transition-colors duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">
                                                {{ substr($page->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $page->name }}</div>
                                                <div class="text-xs text-slate-500">Order: {{ $page->menu_order }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <code class="px-3 py-1.5 rounded-lg bg-slate-100 text-violet-600 text-sm font-mono">
                                            /{{ $page->slug }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.pages.toggle', $page) }}" method="POST"
                                            class="inline-flex items-center justify-center">
                                            @csrf
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer"
                                                    {{ $page->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                                                <div
                                                    class="w-14 h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-emerald-400 peer-checked:to-green-500 shadow-lg">
                                                </div>
                                            </label>
                                        </form>
                                        @if ($page->is_active)
                                            <span class="block mt-2 text-xs font-semibold text-emerald-600">Active</span>
                                        @else
                                            <span class="block mt-2 text-xs font-semibold text-slate-500">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($page->show_in_navigation)
                                            <div
                                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-100 text-blue-700">
                                                <i class="fas fa-eye text-sm"></i>
                                                <span class="text-xs font-semibold">Visible</span>
                                            </div>
                                        @else
                                            <div
                                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500">
                                                <i class="fas fa-eye-slash text-sm"></i>
                                                <span class="text-xs font-semibold">Hidden</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $score = $page->seoMetadata?->seo_score ?? 0;
                                            $scoreClass =
                                                $score >= 80
                                                    ? 'from-emerald-400 to-green-500 text-white'
                                                    : ($score >= 50
                                                        ? 'from-amber-400 to-orange-500 text-white'
                                                        : 'from-red-400 to-rose-500 text-white');
                                        @endphp
                                        <div class="inline-flex flex-col items-center gap-1">
                                            <div
                                                class="px-4 py-2 rounded-xl bg-gradient-to-r {{ $scoreClass }} font-bold text-lg shadow-lg">
                                                {{ $score }}
                                            </div>
                                            @if ($page->seoMetadata && count($page->seoMetadata->seo_issues ?? []) > 0)
                                                <div class="flex items-center gap-1 text-amber-600 text-xs">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <span>{{ count($page->seoMetadata->seo_issues) }} issues</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xl font-bold text-slate-700">
                                            {{ number_format($page->analytics_count ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.pages.edit', $page) }}"
                                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-medium transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <a href="{{ route('admin.pages.edit', $page) }}#seo"
                                                class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-medium transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                                                <i class="fas fa-search mr-1"></i>SEO
                                            </a>
                                            <a href="{{ route('admin.pages.analytics', $page) }}"
                                                class="px-4 py-2 rounded-xl bg-white/80 hover:bg-white text-slate-700 font-medium transition-all duration-200 shadow-md hover:shadow-lg border border-slate-200 cursor-pointer">
                                                <i class="fas fa-chart-line mr-1"></i>Stats
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center">
                                                <i class="fas fa-inbox text-4xl text-slate-400"></i>
                                            </div>
                                            <p class="text-slate-500 font-medium">No pages found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- FEATURES TAB --}}
        <div x-show="tab === 'features'" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100">

            {{-- Info Card --}}
            <div class="mb-6 backdrop-blur-lg bg-blue-50/50 border border-blue-100 rounded-2xl p-6 flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Credit Cost System</h3>
                    <p class="text-slate-600 text-sm">
                        Manage credit consumption for AI features. Set the cost to <code
                            class="font-mono bg-slate-100 px-1 py-0.5 rounded text-blue-600">-1</code> for unlimited access
                        (free).
                        Disabling a feature will hide it from the user dashboard completely.
                    </p>
                </div>
            </div>

            {{-- Features Table --}}
            <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-2xl border border-white/30 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 px-6 py-4 border-b border-white/20">
                    <h3 class="text-lg font-bold text-slate-800">Feature Costs & Status</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-white/50 border-b border-slate-200/50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Feature
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Credit Cost
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/50">
                            @foreach ($features as $feature)
                                <tr class="hover:bg-white/60 transition-colors duration-200">
                                    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($feature->icon)
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 text-white flex items-center justify-center shadow-md">
                                                        <i class="{{ $feature->icon }}"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-bold text-slate-800">{{ $feature->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $feature->key ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-slate-600 text-sm max-w-xs">{{ $feature->description }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                @if ($feature->credit_cost == -1)
                                                    <div class="w-8 flex justify-center">
                                                        <i class="fa-solid fa-infinity text-emerald-500"></i>
                                                    </div>
                                                @else
                                                    <div class="w-8 flex justify-center">
                                                        <i class="fa-solid fa-coins text-amber-500"></i>
                                                    </div>
                                                @endif
                                                <input type="number" name="credit_cost"
                                                    value="{{ $feature->credit_cost }}" min="-1"
                                                    class="w-24 px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all {{ $feature->credit_cost == -1 ? 'text-emerald-600 font-bold' : 'text-slate-700' }}">
                                            </div>
                                            <p class="text-xs text-slate-400 mt-1 ml-10">Set -1 for unlimited</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="hidden" name="is_active" value="0">
                                                <input type="checkbox" name="is_active" value="1"
                                                    class="sr-only peer" {{ $feature->is_active ? 'checked' : '' }}>
                                                <div
                                                    class="w-14 h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-sm">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button type="submit"
                                                class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                                Save
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Smooth toggle transitions */
        input[type="checkbox"]:checked+div {
            background: linear-gradient(to right, #34D399, #10B981);
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endsection
