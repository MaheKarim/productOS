@extends('admin.layout')

@section('title', 'Dashboard')

@section('page-title', 'Overview')

@section('content')
    {{-- Top Stats Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-6 md:mb-10">
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
                class="group bg-white rounded-2xl md:rounded-[2rem] p-4 md:p-8 border border-slate-200/60 shadow-glass transition-soft hover:-translate-y-1 hover:shadow-premium relative overflow-hidden">
                {{-- Decorative Blob --}}
                <div
                    class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/5' : 'bg-slate-100' }} rounded-bl-full translate-x-4 -translate-y-4 transition-soft group-hover:scale-110">
                </div>

                <div class="flex items-center justify-between mb-3 md:mb-6">
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/10' : 'bg-slate-100' }} flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}"
                            class="{{ isset($stat['color']) ? 'text-' . $stat['color'] . '-600' : 'text-slate-500' }} w-5 h-5 md:w-6 md:h-6"></i>
                    </div>
                    <a href="{{ route($stat['route']) }}"
                        class="hidden md:block p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </a>
                </div>

                <div>
                    <p class="text-xs md:text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">
                        {{ $stat['label'] }}</p>
                    <h3 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $stat['count'] }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Middle Section: Secondary Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-8">
        {{-- Secondary Metrics & Health (Full Width now) --}}
        <div class="lg:col-span-3 space-y-4 md:space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                {{-- Featured Directory Items --}}
                <div
                    class="relative group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200 shadow-sm overflow-hidden hover:border-amber-300 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-amber-100 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 opacity-50">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="star" class="text-amber-600 w-6 h-6"></i>
                            </div>
                            <h4 class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Directory</h4>
                            <p class="text-3xl font-black text-slate-800 tracking-tight">{{ $stats['directory_featured'] }}
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Featured across platform</p>
                        </div>
                        <a href="{{ route('admin.directory.index', ['featured' => 1]) }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-slate-50 hover:bg-amber-50 border border-slate-100 hover:border-amber-200 transition-all group/link">
                            <span class="text-xs font-bold text-slate-600 group-hover/link:text-amber-700">View
                                Featured</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-400 group-hover/link:text-amber-600 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Impact Projects --}}
                <div
                    class="relative group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200 shadow-sm overflow-hidden hover:border-emerald-300 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-emerald-100 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 opacity-50">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-3 md:mb-4">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="briefcase" class="text-emerald-600 w-5 h-5 md:w-6 md:h-6"></i>
                            </div>
                            <h4 class="text-[10px] md:text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">
                                Projects</h4>
                            <p class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">
                                {{ $stats['projects'] }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Active implementations</p>
                        </div>
                        <a href="{{ route('admin.projects.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-slate-50 hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 transition-all group/link">
                            <span class="text-xs font-bold text-slate-600 group-hover/link:text-emerald-700">Manage
                                Projects</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-400 group-hover/link:text-emerald-600 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Testimonials --}}
                <div
                    class="relative group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200 shadow-sm overflow-hidden hover:border-violet-300 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-violet-100 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 opacity-50">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-3 md:mb-4">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-violet-100 flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="message-square" class="text-violet-600 w-5 h-5 md:w-6 md:h-6"></i>
                            </div>
                            <h4 class="text-[10px] md:text-xs font-bold text-violet-600 uppercase tracking-widest mb-1">
                                Testimonials</h4>
                            <p class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">
                                {{ $stats['testimonials'] }}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">Client feedback</p>
                        </div>
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-slate-50 hover:bg-violet-50 border border-slate-100 hover:border-violet-200 transition-all group/link">
                            <span class="text-xs font-bold text-slate-600 group-hover/link:text-violet-700">View All</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-400 group-hover/link:text-violet-600 transition-colors"></i>
                        </a>
                    </div>
                </div>

                {{-- Footer Config --}}
                <div
                    class="relative group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200 shadow-sm overflow-hidden hover:border-pink-300 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-pink-100 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 opacity-50">
                    </div>

                    <div class="relative z-10 flex flex-col h-full justify-between">
                        <div class="mb-3 md:mb-4">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-pink-100 flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i data-lucide="settings-2" class="text-pink-600 w-5 h-5 md:w-6 md:h-6"></i>
                            </div>
                            <h4 class="text-[10px] md:text-xs font-bold text-pink-600 uppercase tracking-widest mb-1">
                                Configuration</h4>
                            <p class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">{{ $stats['footer'] }}
                            </p>
                            <p class="text-xs text-slate-500 font-medium mt-1">System settings</p>
                        </div>
                        <a href="{{ route('admin.footer.index') }}"
                            class="flex items-center justify-between w-full p-2 rounded-lg bg-slate-50 hover:bg-pink-50 border border-slate-100 hover:border-pink-200 transition-all group/link">
                            <span class="text-xs font-bold text-slate-600 group-hover/link:text-pink-700">Manage</span>
                            <i data-lucide="arrow-right"
                                class="w-4 h-4 text-slate-400 group-hover/link:text-pink-600 transition-colors"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- AI Provider Health Section --}}
            <div
                class="bg-white rounded-2xl md:rounded-[2.5rem] p-4 md:p-8 border border-slate-200/60 shadow-sm overflow-hidden relative">
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
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-4 md:mb-6">
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

    {{-- Analytics & Charts Section --}}
    <div class="mt-6 md:mt-8 space-y-6 md:space-y-8">
        {{-- Summary Metrics Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-emerald-500/10 flex items-center justify-center">
                        <i data-lucide="users" class="w-4 h-4 md:w-5 md:h-5 text-emerald-600"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold text-emerald-600 bg-emerald-50 px-1.5 md:px-2 py-0.5 md:py-1 rounded-full">Active</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-slate-500 mb-1">Active Users</p>
                <p id="activeUsersCount" class="text-xl md:text-3xl font-black text-slate-900">-</p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-slate-500/10 flex items-center justify-center">
                        <i data-lucide="user-x" class="w-4 h-4 md:w-5 md:h-5 text-slate-600"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold text-slate-600 bg-slate-100 px-1.5 md:px-2 py-0.5 md:py-1 rounded-full">Inactive</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-slate-500 mb-1">Inactive Users</p>
                <p id="inactiveUsersCount" class="text-xl md:text-3xl font-black text-slate-900">-</p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-indigo-500/10 flex items-center justify-center">
                        <i data-lucide="coins" class="w-4 h-4 md:w-5 md:h-5 text-indigo-600"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold text-indigo-600 bg-indigo-50 px-1.5 md:px-2 py-0.5 md:py-1 rounded-full">Credits</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-slate-500 mb-1">Total Credits</p>
                <p id="totalCreditsInCirculation" class="text-xl md:text-3xl font-black text-slate-900">-</p>
            </div>

            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200/60 shadow-sm">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-amber-500/10 flex items-center justify-center">
                        <i data-lucide="wallet" class="w-4 h-4 md:w-5 md:h-5 text-amber-600"></i>
                    </div>
                    <span
                        class="text-[10px] md:text-xs font-bold text-amber-600 bg-amber-50 px-1.5 md:px-2 py-0.5 md:py-1 rounded-full">Avg</span>
                </div>
                <p class="text-xs md:text-sm font-medium text-slate-500 mb-1">Avg Credits/User</p>
                <p id="averageCreditsPerUser" class="text-xl md:text-3xl font-black text-slate-900">-</p>
            </div>
        </div>

        {{-- Charts Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8">
            {{-- Monthly User Registration Trend --}}
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 border border-slate-200/60 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 md:mb-6 gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight">User Registration Trend</h3>
                        <p class="text-xs md:text-sm text-slate-500 mt-1">Monthly user growth analysis</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <select onchange="changeYear(this.value)"
                            class="px-2 md:px-3 py-1.5 md:py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="{{ now()->year }}">{{ now()->year }}</option>
                            <option value="{{ now()->year - 1 }}">{{ now()->year - 1 }}</option>
                            <option value="{{ now()->year - 2 }}">{{ now()->year - 2 }}</option>
                        </select>
                        <button onclick="exportChartData('userRegistrationChart')"
                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                            title="Export CSV">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </button>
                        <button onclick="exportChart('userRegistrationChart', 'png')"
                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                            title="Export PNG">
                            <i data-lucide="image" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div id="peakMonthsInfo" class="mb-4">
                    <div class="flex items-center gap-2">
                        <i data-lucide="loader-2" class="w-4 h-4 text-slate-400 animate-spin"></i>
                        <span class="text-sm text-slate-500">Loading...</span>
                    </div>
                </div>

                <div class="h-64 md:h-80 relative">
                    <canvas id="userRegistrationChart"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-3 md:gap-4 mt-4 md:mt-6">
                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <p class="text-[10px] md:text-xs font-medium text-slate-500 mb-1">Current Year</p>
                        <p id="currentYearRegistrations" class="text-xl md:text-2xl font-bold text-slate-900">-</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <p class="text-[10px] md:text-xs font-medium text-slate-500 mb-1">Previous Year</p>
                        <p id="previousYearRegistrations" class="text-xl md:text-2xl font-bold text-slate-900">-</p>
                    </div>
                </div>
            </div>

            {{-- Feature-Wise Credit Consumption (Pie Chart) --}}
            <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 border border-slate-200/60 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 md:mb-6 gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight">Credit Distribution</h3>
                        <p class="text-xs md:text-sm text-slate-500 mt-1">Credits consumed by feature</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="exportChartData('creditPieChart')"
                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                            title="Export CSV">
                            <i data-lucide="download" class="w-4 h-4"></i>
                        </button>
                        <button onclick="exportChart('creditPieChart', 'png')"
                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                            title="Export PNG">
                            <i data-lucide="image" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="h-64 md:h-80 relative flex items-center justify-center">
                    <canvas id="creditPieChart"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-3 md:gap-4 mt-4 md:mt-6">
                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <p class="text-[10px] md:text-xs font-medium text-slate-500 mb-1">Total Credits</p>
                        <p id="totalCreditsConsumed" class="text-xl md:text-2xl font-bold text-slate-900">-</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg md:rounded-xl p-3 md:p-4">
                        <p class="text-[10px] md:text-xs font-medium text-slate-500 mb-1">Active Users</p>
                        <p id="totalCreditsUsers" class="text-xl md:text-2xl font-bold text-slate-900">-</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Credit Consumption Bar Chart --}}
        <div class="bg-white rounded-xl md:rounded-2xl p-4 md:p-8 border border-slate-200/60 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 md:mb-6 gap-3">
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight">Credit Consumption Analysis</h3>
                    <p class="text-xs md:text-sm text-slate-500 mt-1">Detailed breakdown by feature</p>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <div class="flex bg-slate-100 rounded-lg p-1 overflow-x-auto max-w-full">
                        <button onclick="changePeriod('all')" data-period="all"
                            class="px-2 md:px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-indigo-600 text-white whitespace-nowrap">All
                            Time</button>
                        <button onclick="changePeriod('month')" data-period="month"
                            class="px-2 md:px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-slate-100 text-slate-700 hover:bg-slate-200 whitespace-nowrap">This
                            Month</button>
                        <button onclick="changePeriod('week')" data-period="week"
                            class="px-2 md:px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-slate-100 text-slate-700 hover:bg-slate-200 whitespace-nowrap">This
                            Week</button>
                        <button onclick="changePeriod('today')" data-period="today"
                            class="px-2 md:px-3 py-1.5 text-xs font-medium rounded-md transition-all bg-slate-100 text-slate-700 hover:bg-slate-200 whitespace-nowrap">Today</button>
                    </div>
                    <button onclick="exportChartData('creditConsumptionChart')"
                        class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                        title="Export CSV">
                        <i data-lucide="download" class="w-4 h-4"></i>
                    </button>
                    <button onclick="exportChart('creditConsumptionChart', 'png')"
                        class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors"
                        title="Export PNG">
                        <i data-lucide="image" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div class="h-64 md:h-96 relative">
                <canvas id="creditBarChart"></canvas>
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

@push('scripts')
    <script>
        // Global chart instances
        let userRegistrationChart = null;
        let creditConsumptionChart = null;
        let creditPieChart = null;

        // Fetch and initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadDashboardMetrics();
        });

        async function initializeCharts() {
            await loadUserRegistrationChart();
            await loadCreditConsumptionChart();
        }

        // User Registration Chart
        async function loadUserRegistrationChart(year = null) {
            const url = year ?
                `{{ route('admin.analytics.user-registrations') }}?year=${year}` :
                '{{ route('admin.analytics.user-registrations') }}';

            try {
                const response = await fetch(url);
                const data = await response.json();

                const ctx = document.getElementById('userRegistrationChart').getContext('2d');

                if (userRegistrationChart) {
                    userRegistrationChart.destroy();
                }

                userRegistrationChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                                label: `Current Year (${data.year})`,
                                data: data.current_year.data,
                                borderColor: '#6366F1',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 3,
                                pointBackgroundColor: '#6366F1',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            },
                            {
                                label: `Previous Year (${data.prev_year})`,
                                data: data.previous_year.data,
                                borderColor: '#94A3B8',
                                backgroundColor: 'rgba(148, 163, 184, 0.1)',
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2,
                                borderDash: [5, 5],
                                pointRadius: 3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    font: {
                                        family: 'DM Sans',
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.1)'
                                },
                                ticks: {
                                    font: {
                                        family: 'DM Sans'
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: 'DM Sans'
                                    }
                                }
                            }
                        }
                    }
                });

                // Update peak months info
                updatePeakMonthsInfo(data.current_year.peak_months, data.current_year.peak_count);
                updateRegistrationStats(data);

            } catch (error) {
                console.error('Error loading user registration chart:', error);
            }
        }

        function updatePeakMonthsInfo(peakMonths, peakCount) {
            const peakInfo = document.getElementById('peakMonthsInfo');
            if (peakMonths.length > 0) {
                peakInfo.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-4 h-4 text-emerald-500"></i>
                        <span class="text-sm font-medium text-slate-700">
                            Peak: ${peakMonths.join(', ')} (${peakCount} users)
                        </span>
                    </div>
                `;
            } else {
                peakInfo.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i data-lucide="minus" class="w-4 h-4 text-slate-400"></i>
                        <span class="text-sm text-slate-500">No registrations yet</span>
                    </div>
                `;
            }
            lucide.createIcons();
        }

        function updateRegistrationStats(data) {
            document.getElementById('currentYearRegistrations').textContent = data.current_year.total;
            document.getElementById('previousYearRegistrations').textContent = data.previous_year.total;
        }

        // Credit Consumption Chart
        async function loadCreditConsumptionChart(period = 'all') {
            const url = `{{ route('admin.analytics.credit-consumption') }}?period=${period}`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                // Update pie chart
                updateCreditPieChart(data);

                // Update bar chart
                updateCreditBarChart(data);

                // Update stats
                updateCreditStats(data);

            } catch (error) {
                console.error('Error loading credit consumption chart:', error);
            }
        }

        function updateCreditPieChart(data) {
            const ctx = document.getElementById('creditPieChart').getContext('2d');

            if (creditPieChart) {
                creditPieChart.destroy();
            }

            creditPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.credits,
                        backgroundColor: [
                            '#6366F1', // Indigo
                            '#10B981', // Emerald
                            '#F59E0B', // Amber
                            '#EC4899', // Pink
                            '#8B5CF6' // Violet
                        ],
                        borderWidth: 0,
                        hoverOffset: 10
                    }],
                    percentages: data.percentages,
                    users: data.users,
                    avg_credits_per_user: data.avg_credits_per_user
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    family: 'DM Sans',
                                    size: 12
                                },
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            const percentage = data.percentages[i];
                                            return {
                                                text: `${label}: ${value} (${percentage}%)`,
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const percentage = data.percentages[context.dataIndex] || 0;
                                    const users = data.users[context.dataIndex] || 0;
                                    const avgCredits = data.avg_credits_per_user[context.dataIndex] || 0;
                                    return [
                                        `${label}: ${value} credits`,
                                        `Percentage: ${percentage}%`,
                                        `Users: ${users}`,
                                        `Avg per user: ${avgCredits} credits`
                                    ];
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        function updateCreditBarChart(data) {
            const ctx = document.getElementById('creditBarChart').getContext('2d');

            if (creditConsumptionChart) {
                creditConsumptionChart.destroy();
            }

            creditConsumptionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                            label: 'Credits Consumed',
                            data: data.credits,
                            backgroundColor: 'rgba(99, 102, 241, 0.8)',
                            borderColor: '#6366F1',
                            borderWidth: 2,
                            borderRadius: 8,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Users',
                            data: data.users,
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            borderColor: '#10B981',
                            borderWidth: 2,
                            borderRadius: 8,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    family: 'DM Sans',
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(148, 163, 184, 0.1)'
                            },
                            ticks: {
                                font: {
                                    family: 'DM Sans'
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                font: {
                                    family: 'DM Sans'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'DM Sans'
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateCreditStats(data) {
            document.getElementById('totalCreditsConsumed').textContent = data.total_credits;
            document.getElementById('totalCreditsUsers').textContent = data.total_users;
        }

        // Dashboard Metrics
        async function loadDashboardMetrics() {
            try {
                const response = await fetch('{{ route('admin.analytics.metrics') }}');
                const data = await response.json();

                updateMetricsCards(data);

            } catch (error) {
                console.error('Error loading dashboard metrics:', error);
            }
        }

        function updateMetricsCards(data) {
            // User stats
            document.getElementById('activeUsersCount').textContent = data.users.active;
            document.getElementById('inactiveUsersCount').textContent = data.users.inactive;
            document.getElementById('totalUsersCount').textContent = data.users.total;

            // Credit stats
            document.getElementById('totalCreditsInCirculation').textContent = data.credits.total_in_circulation;
            document.getElementById('averageCreditsPerUser').textContent = data.credits.average_per_user;
        }

        function updateFeatureStatus(features) {
            const container = document.getElementById('featureStatusContainer');
            container.innerHTML = features.map(feature => `
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full ${feature.is_active ? 'bg-emerald-500' : 'bg-slate-300'}"></div>
                        <span class="text-sm font-medium text-slate-700">${feature.name}</span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-500">${feature.credits_consumed} credits used</p>
                        <p class="text-xs ${feature.credit_cost == -1 ? 'text-green-500 font-medium' : 'text-slate-400'}">${feature.credit_cost == -1 ? 'Unlimited' : feature.credit_cost + ' credits/cost'}</p>
                    </div>
                </div>
            `).join('');
        }

        // Export functionality
        function exportChart(chartId, format) {
            const canvas = document.getElementById(chartId);
            const link = document.createElement('a');

            if (format === 'png') {
                link.download = `${chartId}-${new Date().toISOString().split('T')[0]}.png`;
                link.href = canvas.toDataURL('image/png');
            } else if (format === 'jpg') {
                link.download = `${chartId}-${new Date().toISOString().split('T')[0]}.jpg`;
                link.href = canvas.toDataURL('image/jpeg', 0.9);
            }

            link.click();
        }

        function exportChartData(chartId) {
            let data, filename;

            if (chartId === 'userRegistrationChart' && userRegistrationChart) {
                data = userRegistrationChart.data;
                filename = 'user-registrations.csv';
            } else if (chartId === 'creditConsumptionChart' && creditConsumptionChart) {
                data = creditConsumptionChart.data;
                filename = 'credit-consumption.csv';
            } else if (chartId === 'creditPieChart' && creditPieChart) {
                data = creditPieChart.data;
                filename = 'credit-distribution.csv';
            } else {
                return;
            }

            let csv = 'Label,' + data.datasets.map(ds => ds.label).join(',') + '\n';
            data.labels.forEach((label, i) => {
                csv += label + ',' + data.datasets.map(ds => ds.data[i]).join(',') + '\n';
            });

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
            link.click();
        }

        // Year selector for registration chart
        function changeYear(year) {
            loadUserRegistrationChart(year);
        }

        // Period selector for credit chart
        function changePeriod(period) {
            loadCreditConsumptionChart(period);

            // Update active button
            document.querySelectorAll('[data-period]').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-slate-100', 'text-slate-700');
            });
            document.querySelector(`[data-period="${period}"]`).classList.remove('bg-slate-100', 'text-slate-700');
            document.querySelector(`[data-period="${period}"]`).classList.add('bg-indigo-600', 'text-white');
        }

        // Auto-refresh (every 5 minutes)
        setInterval(() => {
            loadDashboardMetrics();
        }, 300000);
    </script>
@endpush
