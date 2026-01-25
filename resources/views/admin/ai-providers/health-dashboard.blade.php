@extends('admin.layout')

@section('title', 'AI Provider Health Dashboard')
@section('page-title', 'Health Dashboard')

@section('content')
    <div x-data="healthDashboard()" x-init="init()">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">AI Provider Health</h1>
                <p class="mt-1 text-slate-500">Monitor performance, costs, and usage across all providers.</p>
            </div>
            <div class="flex items-center gap-3">
                <select x-model="timeRange" @change="refreshData()"
                    class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                    <option value="24">Last 24 Hours</option>
                    <option value="72">Last 3 Days</option>
                    <option value="168">Last 7 Days</option>
                </select>
                <a href="{{ route('admin.ai-providers.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                    Manage Providers
                </a>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Requests --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <i data-lucide="activity" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 uppercase">Last 24h</span>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ number_format($stats['total_requests']) }}</p>
                <p class="text-sm text-slate-500 mt-1">Total Requests</p>
            </div>

            {{-- Avg Response Time --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center">
                        <i data-lucide="timer" class="w-6 h-6 text-teal-600"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500 uppercase">Avg</span>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $stats['avg_response_time'] }}<span
                        class="text-lg text-slate-400">ms</span></p>
                <p class="text-sm text-slate-500 mt-1">Response Time</p>
            </div>

            {{-- Error Rate --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 rounded-xl {{ $stats['error_rate'] > 5 ? 'bg-red-50' : 'bg-emerald-50' }} flex items-center justify-center">
                        <i data-lucide="{{ $stats['error_rate'] > 5 ? 'alert-triangle' : 'check-circle' }}"
                            class="w-6 h-6 {{ $stats['error_rate'] > 5 ? 'text-red-600' : 'text-emerald-600' }}"></i>
                    </div>
                    <span class="text-xs font-medium {{ $stats['error_rate'] > 5 ? 'text-red-500' : 'text-emerald-500' }}">
                        {{ $stats['error_count'] }} errors
                    </span>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $stats['error_rate'] }}<span
                        class="text-lg text-slate-400">%</span></p>
                <p class="text-sm text-slate-500 mt-1">Error Rate</p>
            </div>

            {{-- Total Cost --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-amber-600"></i>
                    </div>
                    <span class="text-xs font-medium text-slate-500">{{ number_format($stats['total_tokens']) }}
                        tokens</span>
                </div>
                <p class="text-3xl font-bold text-slate-900">${{ number_format($stats['total_cost'], 4) }}</p>
                <p class="text-sm text-slate-500 mt-1">Total Cost</p>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Response Time Chart --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Response Times</h3>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        <span>Avg ms per hour</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="responseTimeChart"></canvas>
                </div>
            </div>

            {{-- Request Volume Chart --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Request Volume</h3>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <div class="w-2 h-2 rounded-full bg-teal-500"></div>
                        <span>Requests per hour</span>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="requestVolumeChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Provider Stats & Error Rate --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Provider Stats Table --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Provider Performance</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Provider</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Requests</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Avg Time</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Error Rate</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                    Cost</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($providerStats as $provider)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm
                                                {{ $provider['slug'] === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : '' }}
                                                {{ $provider['slug'] === 'groq' ? 'bg-gradient-to-br from-orange-500 to-amber-500' : '' }}
                                                {{ $provider['slug'] === 'zai' ? 'bg-gradient-to-br from-cyan-500 to-blue-600' : '' }}
                                                {{ $provider['slug'] === 'gemini' ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : '' }}">
                                                <i data-lucide="cpu" class="w-5 h-5 text-white"></i>
                                            </div>
                                            <span class="font-semibold text-slate-900">{{ $provider['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-700">
                                        {{ number_format($provider['total_requests']) }}</td>
                                    <td class="px-6 py-4 text-right font-mono text-slate-600">
                                        {{ $provider['avg_response_time'] }}ms</td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $provider['error_rate'] > 5 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ $provider['error_rate'] }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-slate-700">
                                        ${{ number_format($provider['total_cost'], 4) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        <i data-lucide="inbox" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                                        <p>No request data available yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Error Rate Donut --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Success Rate</h3>
                </div>
                <div class="h-48">
                    <canvas id="errorRateChart"></canvas>
                </div>
                <div class="mt-4 flex items-center justify-center gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-slate-600">Success</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-slate-600">Error</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Requests by Model --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Requests by Model</h3>
                <p class="text-sm text-slate-500 mt-1">Top 10 most used models in the last 24 hours</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Model
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Provider</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Requests</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">Avg
                                Time</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">
                                Tokens</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">Cost
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($modelStats as $model)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                            <i data-lucide="sparkles" class="w-4 h-4 text-slate-500"></i>
                                        </div>
                                        <span class="font-mono text-sm text-slate-900">{{ $model['model'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $model['provider_name'] }}</td>
                                <td class="px-6 py-4 text-right font-medium text-slate-700">
                                    {{ number_format($model['request_count']) }}</td>
                                <td class="px-6 py-4 text-right font-mono text-slate-600">
                                    {{ $model['avg_response_time'] }}ms</td>
                                <td class="px-6 py-4 text-right text-slate-600">
                                    {{ number_format($model['total_tokens']) }}</td>
                                <td class="px-6 py-4 text-right font-medium text-slate-700">
                                    ${{ number_format($model['total_cost'], 4) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <i data-lucide="layers" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                                    <p>No model data available yet.</p>
                                    <p class="text-sm mt-1">Data will appear once AI requests are made.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cost Trend Chart --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Cost Trend</h3>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <span>USD per hour</span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="costTrendChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function healthDashboard() {
            return {
                timeRange: 24,
                charts: {},

                init() {
                    this.initCharts();
                    // Refresh data every 60 seconds
                    setInterval(() => this.refreshData(), 60000);
                },

                async refreshData() {
                    try {
                        const response = await fetch(
                            `{{ route('admin.ai-providers.health.data') }}?hours=${this.timeRange}`);
                        const data = await response.json();
                        this.updateCharts(data);
                    } catch (error) {
                        console.error('Failed to refresh data:', error);
                    }
                },

                initCharts() {
                    // Response Time Chart
                    const rtCtx = document.getElementById('responseTimeChart')?.getContext('2d');
                    if (rtCtx) {
                        this.charts.responseTime = new Chart(rtCtx, {
                            type: 'line',
                            data: {
                                datasets: []
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    }
                                },
                                scales: {
                                    x: {
                                        type: 'category',
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'ms'
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Request Volume Chart
                    const rvCtx = document.getElementById('requestVolumeChart')?.getContext('2d');
                    if (rvCtx) {
                        this.charts.requestVolume = new Chart(rvCtx, {
                            type: 'bar',
                            data: {
                                datasets: []
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true,
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    // Error Rate Donut
                    const erCtx = document.getElementById('errorRateChart')?.getContext('2d');
                    if (erCtx) {
                        this.charts.errorRate = new Chart(erCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Success', 'Error'],
                                datasets: [{
                                    data: [{{ $stats['successful_requests'] }},
                                        {{ $stats['error_count'] }}
                                    ],
                                    backgroundColor: ['#10b981', '#ef4444'],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '70%',
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                }
                            }
                        });
                    }

                    // Cost Trend Chart
                    const ctCtx = document.getElementById('costTrendChart')?.getContext('2d');
                    if (ctCtx) {
                        this.charts.costTrend = new Chart(ctCtx, {
                            type: 'line',
                            data: {
                                datasets: []
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    }
                                },
                                scales: {
                                    x: {
                                        type: 'category',
                                        grid: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'USD'
                                        }
                                    }
                                },
                                elements: {
                                    line: {
                                        fill: true,
                                        tension: 0.4
                                    }
                                }
                            }
                        });
                    }

                    // Initial data load
                    this.refreshData();
                },

                updateCharts(data) {
                    const colors = {
                        'OpenRouter': {
                            line: '#8b5cf6',
                            fill: 'rgba(139, 92, 246, 0.1)'
                        },
                        'Groq': {
                            line: '#f59e0b',
                            fill: 'rgba(245, 158, 11, 0.1)'
                        },
                        'Z.AI': {
                            line: '#06b6d4',
                            fill: 'rgba(6, 182, 212, 0.1)'
                        },
                        'Gemini / Google AI Studio': {
                            line: '#6366f1',
                            fill: 'rgba(99, 102, 241, 0.1)'
                        }
                    };

                    // Update Response Time Chart
                    if (this.charts.responseTime && data.responseTimeData) {
                        const datasets = Object.entries(data.responseTimeData).map(([provider, points]) => ({
                            label: provider,
                            data: points.map(p => p.y),
                            borderColor: colors[provider]?.line || '#64748b',
                            backgroundColor: colors[provider]?.fill || 'rgba(100, 116, 139, 0.1)',
                            tension: 0.4
                        }));

                        const labels = Object.values(data.responseTimeData)[0]?.map(p => {
                            const date = new Date(p.x);
                            return date.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }) || [];

                        this.charts.responseTime.data = {
                            labels,
                            datasets
                        };
                        this.charts.responseTime.update();
                    }

                    // Update Request Volume Chart
                    if (this.charts.requestVolume && data.requestVolumeData) {
                        const datasets = Object.entries(data.requestVolumeData).map(([provider, points]) => ({
                            label: provider,
                            data: points.map(p => p.y),
                            backgroundColor: colors[provider]?.line || '#64748b'
                        }));

                        const labels = Object.values(data.requestVolumeData)[0]?.map(p => {
                            const date = new Date(p.x);
                            return date.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }) || [];

                        this.charts.requestVolume.data = {
                            labels,
                            datasets
                        };
                        this.charts.requestVolume.update();
                    }

                    // Update Cost Trend Chart
                    if (this.charts.costTrend && data.costTrendData) {
                        const datasets = Object.entries(data.costTrendData).map(([provider, points]) => ({
                            label: provider,
                            data: points.map(p => p.y),
                            borderColor: colors[provider]?.line || '#64748b',
                            backgroundColor: colors[provider]?.fill || 'rgba(100, 116, 139, 0.1)',
                            fill: true,
                            tension: 0.4
                        }));

                        const labels = Object.values(data.costTrendData)[0]?.map(p => {
                            const date = new Date(p.x);
                            return date.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }) || [];

                        this.charts.costTrend.data = {
                            labels,
                            datasets
                        };
                        this.charts.costTrend.update();
                    }
                }
            }
        }
    </script>
@endsection
