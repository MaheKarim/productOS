@extends('admin.layout')

@section('title', 'Edit Page - ' . $page->name)

@section('content')
    {{-- Modern Gradient Background --}}
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-violet-50 via-purple-50 to-fuchsia-50"></div>

    <div class="container-fluid px-6 py-8">
        <div class="flex gap-6">
            {{-- Sidebar Navigation --}}
            <div class="w-72 flex-shrink-0">
                <div class="sticky top-8">
                    {{-- Back Button --}}
                    <a href="{{ route('admin.pages.index') }}"
                        class="mb-4 flex items-center gap-2 px-4 py-3 rounded-xl backdrop-blur-lg bg-white/60 hover:bg-white/80 border border-white/30 text-slate-700 font-medium transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Pages</span>
                    </a>

                    {{-- Quick Navigation --}}
                    <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/30 overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-500/10 to-purple-500/10 px-4 py-3 border-b border-white/20">
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Quick Navigation</h3>
                        </div>
                        <nav class="p-3 space-y-1">
                            <a href="#settings"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-violet-100/50 text-slate-700 transition-all duration-200 cursor-pointer group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cog text-sm"></i>
                                </div>
                                <span class="font-medium">Page Settings</span>
                            </a>
                            <a href="#seo"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-100/50 text-slate-700 transition-all duration-200 cursor-pointer group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                    <i class="fas fa-search text-sm"></i>
                                </div>
                                <span class="font-medium">SEO Metadata</span>
                            </a>
                            <a href="#info"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-100/50 text-slate-700 transition-all duration-200 cursor-pointer group">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                                    <i class="fas fa-info-circle text-sm"></i>
                                </div>
                                <span class="font-medium">Page Info</span>
                            </a>
                        </nav>
                    </div>

                    {{-- All Pages List --}}
                    <div
                        class="mt-4 backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/30 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-violet-500/10 to-purple-500/10 px-4 py-3 border-b border-white/20">
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">All Pages</h3>
                        </div>
                        <nav class="p-3 space-y-1 max-h-96 overflow-y-auto">
                            @php
                                $allPages = \App\Models\Page::orderBy('menu_order')->get();
                            @endphp
                            @foreach ($allPages as $p)
                                <a href="{{ route('admin.pages.edit', $p) }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-violet-100/50 transition-all duration-200 cursor-pointer {{ $p->id === $page->id ? 'bg-violet-100 border-l-4 border-violet-500' : '' }}">
                                    <div
                                        class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ substr($p->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-slate-800 text-sm truncate">{{ $p->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $p->is_active ? '🟢' : '⚪' }}
                                            {{ $p->slug }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 min-w-0">
                {{-- Header --}}
                <div class="mb-6">
                    <div class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/20 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1
                                    class="text-3xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent mb-2">
                                    Edit Page: {{ $page->name }}
                                </h1>
                                <p class="text-slate-600 text-sm">Manage page settings and SEO optimization</p>
                            </div>
                            @if ($page->is_active)
                                <span
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-400 to-green-500 text-white font-semibold shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i>Active
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-xl bg-slate-400 text-white font-semibold shadow-lg">
                                    <i class="fas fa-times-circle mr-2"></i>Inactive
                                </span>
                            @endif
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

                @if ($errors->any())
                    <div
                        class="mb-6 backdrop-blur-lg bg-red-500/90 text-white rounded-2xl shadow-lg border border-white/20 p-4">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Page Settings Card --}}
                <div id="settings" class="mb-6 backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/30">
                    <div class="bg-gradient-to-r from-violet-500/10 to-purple-500/10 px-6 py-4 border-b border-white/20">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center text-white">
                                <i class="fas fa-cog"></i>
                            </div>
                            Page Settings
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Page Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $page->name) }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        URL Slug <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-mono">/</span>
                                        <input type="text" name="slug" value="{{ old('slug', $page->slug) }}"
                                            class="w-full pl-8 pr-4 py-3 rounded-xl border-2 border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none font-mono"
                                            required>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500">SEO-friendly URL (e.g., interview-prep)</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Laravel Route Name</label>
                                    <input type="text" name="route_name"
                                        value="{{ old('route_name', $page->route_name) }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                                    <p class="mt-1 text-xs text-slate-500">Internal route name (e.g.,
                                        interview-prep.landing)
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Menu Order</label>
                                    <input type="number" name="menu_order"
                                        value="{{ old('menu_order', $page->menu_order) }}" min="0"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                                </div>

                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Inactive Page
                                        Behavior</label>
                                    <select name="inactive_behavior"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none cursor-pointer">
                                        <option value="coming_soon"
                                            {{ $page->inactive_behavior === 'coming_soon' ? 'selected' : '' }}>Coming Soon
                                            Page</option>
                                        <option value="404" {{ $page->inactive_behavior === '404' ? 'selected' : '' }}>
                                            404 Error</option>
                                        <option value="redirect_home"
                                            {{ $page->inactive_behavior === 'redirect_home' ? 'selected' : '' }}>Redirect
                                            to
                                            Home</option>
                                        <option value="maintenance"
                                            {{ $page->inactive_behavior === 'maintenance' ? 'selected' : '' }}>Maintenance
                                            Page</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 space-y-4">
                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-200 hover:border-emerald-300 transition-all cursor-pointer group">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ $page->is_active ? 'checked' : '' }}
                                        class="w-6 h-6 rounded-lg border-2 border-slate-300 text-emerald-500 focus:ring-4 focus:ring-emerald-100 cursor-pointer">
                                    <div class="flex-1">
                                        <div
                                            class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">
                                            Page is Active</div>
                                        <div class="text-sm text-slate-600">When disabled, the page will not be accessible
                                            to users</div>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center gap-4 p-4 rounded-xl border-2 border-slate-200 hover:border-blue-300 transition-all cursor-pointer group">
                                    <input type="checkbox" name="show_in_navigation" value="1"
                                        {{ $page->show_in_navigation ? 'checked' : '' }}
                                        class="w-6 h-6 rounded-lg border-2 border-slate-300 text-blue-500 focus:ring-4 focus:ring-blue-100 cursor-pointer">
                                    <div class="flex-1">
                                        <div class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                            Show in Navigation Menu</div>
                                        <div class="text-sm text-slate-600">Display this page in the main navigation bar
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-6 pt-6 border-t border-slate-200">
                                <button type="submit"
                                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SEO Metadata Card --}}
                <div id="seo"
                    class="mb-6 backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/30">
                    <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 px-6 py-4 border-b border-white/20">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white">
                                    <i class="fas fa-search"></i>
                                </div>
                                SEO Metadata
                            </h2>
                            @if ($page->seoMetadata)
                                @php
                                    $score = $page->seoMetadata->seo_score;
                                    $scoreClass =
                                        $score >= 80
                                            ? 'from-emerald-400 to-green-500'
                                            : ($score >= 50
                                                ? 'from-amber-400 to-orange-500'
                                                : 'from-red-400 to-rose-500');
                                @endphp
                                <div
                                    class="px-6 py-3 rounded-xl bg-gradient-to-r {{ $scoreClass }} text-white font-bold text-lg shadow-lg">
                                    Score: {{ $score }}/100
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.pages.update-seo', $page) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Meta Title <span class="text-red-500">*</span>
                                        <span class="text-xs font-normal text-slate-500 ml-2">(Recommended: 50-60
                                            characters)</span>
                                    </label>
                                    <input type="text" name="title"
                                        value="{{ old('title', $page->seoMetadata?->title) }}" maxlength="60"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Meta Description <span class="text-red-500">*</span>
                                        <span class="text-xs font-normal text-slate-500 ml-2">(Recommended: 150-160
                                            characters)</span>
                                    </label>
                                    <textarea name="description" rows="3" maxlength="200"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none resize-none">{{ old('description', $page->seoMetadata?->description) }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Keywords</label>
                                        <input type="text" name="keywords"
                                            value="{{ old('keywords', $page->seoMetadata?->keywords) }}"
                                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                                        <p class="mt-1 text-xs text-slate-500">Comma-separated (e.g., PM interview, product
                                            manager)</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Focus Keyword</label>
                                        <input type="text" name="focus_keyword"
                                            value="{{ old('focus_keyword', $page->seoMetadata?->focus_keyword) }}"
                                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                                        <p class="mt-1 text-xs text-slate-500">Primary keyword for this page</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Canonical URL</label>
                                    <input type="url" name="canonical_url"
                                        value="{{ old('canonical_url', $page->seoMetadata?->canonical_url) }}"
                                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none">
                                </div>

                                @if ($page->seoMetadata && count($page->seoMetadata->seo_issues ?? []) > 0)
                                    <div class="p-4 rounded-xl bg-amber-50 border-2 border-amber-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center text-white flex-shrink-0">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-bold text-amber-900 mb-2">SEO Issues Detected</div>
                                                <ul class="space-y-1">
                                                    @foreach ($page->seoMetadata->seo_issues as $issue)
                                                        <li class="text-sm text-amber-800">• {{ $issue }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 pt-6 border-t border-slate-200">
                                <button type="submit"
                                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-bold shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer">
                                    <i class="fas fa-save mr-2"></i>Update SEO
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Page Info Card --}}
                <div id="info" class="backdrop-blur-lg bg-white/70 rounded-2xl shadow-xl border border-white/30">
                    <div class="bg-gradient-to-r from-emerald-500/10 to-green-500/10 px-6 py-4 border-b border-white/20">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-green-500 flex items-center justify-center text-white">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Page Information & Quick Actions
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Status</div>
                                @if ($page->is_active)
                                    <div class="text-emerald-600 font-bold text-lg">Active</div>
                                @else
                                    <div class="text-slate-500 font-bold text-lg">Inactive</div>
                                @endif
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Last Updated
                                </div>
                                <div class="text-slate-800 font-bold text-lg">{{ $page->updated_at->diffForHumans() }}
                                </div>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Created</div>
                                <div class="text-slate-800 font-bold text-lg">{{ $page->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                            <a href="{{ route('admin.pages.analytics', $page) }}"
                                class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-violet-300 transition-all cursor-pointer group">
                                <i
                                    class="fas fa-chart-line text-2xl text-violet-500 group-hover:scale-110 transition-transform"></i>
                                <span class="font-bold text-slate-700">View Analytics</span>
                            </a>
                            <a href="{{ route('admin.pages.versions', $page) }}"
                                class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-white hover:bg-slate-50 border-2 border-slate-200 hover:border-blue-300 transition-all cursor-pointer group">
                                <i
                                    class="fas fa-history text-2xl text-blue-500 group-hover:scale-110 transition-transform"></i>
                                <span class="font-bold text-slate-700">Version History</span>
                            </a>
                            @if ($page->route_name)
                                <a href="{{ route($page->route_name) }}" target="_blank"
                                    class="flex items-center justify-center gap-3 px-6 py-4 rounded-xl bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-bold shadow-lg hover:shadow-xl transition-all cursor-pointer">
                                    <i class="fas fa-external-link-alt text-xl"></i>
                                    <span>View Live Page</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for sidebar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(148, 163, 184, 0.1);
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(124, 58, 237, 0.3);
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(124, 58, 237, 0.5);
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>

    <script>
        // Smooth scroll to section when clicking sidebar links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@endsection
