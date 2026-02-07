@extends('admin.layout')

@section('title', 'Feedback Analytics')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="mb-6">
            <a href="{{ route('admin.feedback.index') }}"
                class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back to Feedback List
            </a>
        </div>

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700">
                    Feedback Analytics</h1>
                <p class="text-sm text-slate-500 mt-1">Insights and trends from user feedback</p>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Feedback</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                    <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full">
                        +{{ $stats['this_month'] }} this month
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Avg Resolution Time</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-3xl font-bold text-slate-900">
                        {{ $avgResolutionTime ? number_format($avgResolutionTime, 1) . 'h' : 'N/A' }}
                    </p>
                    <i class="fa-solid fa-stopwatch text-slate-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending Review</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-3xl font-bold text-slate-900">
                        {{ $statusBreakdown['submitted'] + $statusBreakdown['under_review'] }}</p>
                    <i class="fa-solid fa-hourglass-half text-slate-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Bug Ratio</p>
                <div class="flex items-end justify-between mt-2">
                    <p class="text-3xl font-bold text-slate-900">
                        {{ $stats['total'] > 0 ? round(($typeBreakdown['bugs'] / $stats['total']) * 100) : 0 }}%
                    </p>
                    <i class="fa-solid fa-bug text-slate-200 text-2xl"></i>
                </div>
            </div>
        </div>


        <!-- AI Insights Section -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 rounded-lg">
                        <i class="fa-solid fa-robot text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">AI Insights</h3>
                        <p class="text-sm text-slate-500">Generate intelligent summaries from recent feedback</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <select id="aiProviderSelect"
                        class="text-sm border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach ($aiProviders as $provider)
                            <option value="{{ $provider->id }}" {{ $provider->is_default ? 'selected' : '' }}>
                                {{ $provider->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="generateInsightsBtn"
                        class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fa-solid fa-wand-magic-sparkles mr-2"></i>
                        Generate Insights
                    </button>
                </div>
            </div>

            <div id="aiInsightsContent" class="hidden">
                <div class="prose prose-sm max-w-none text-slate-600 bg-slate-50 p-6 rounded-xl border border-slate-100">
                    <!-- AI content will be injected here -->
                </div>
            </div>

            <div id="aiLoading" class="hidden">
                <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                    <i class="fa-solid fa-circle-notch fa-spin text-2xl mb-3 text-indigo-600"></i>
                    <p class="text-sm font-medium">Analyzing feedback data...</p>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Status Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Status Distribution</h3>
                <div class="h-64">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Type Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Feedback Types</h3>
                <div class="h-64">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Recent Activity</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Feedback</th>
                            <th class="px-6 py-4 font-semibold">User</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentFeedback as $feedback)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $feedback->title }}</div>
                                    <div class="text-xs text-slate-500">{{ ucfirst($feedback->type) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if ($feedback->user->avatar)
                                            <img src="{{ $feedback->user->avatar }}" class="w-6 h-6 rounded-full">
                                        @else
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                                {{ substr($feedback->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="text-slate-700">{{ $feedback->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $feedback->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.feedback.show', $feedback->feedback_id) }}"
                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">No recent activity</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Submitted', 'Under Review', 'Planned', 'In Progress', 'Resolved', 'Closed'],
                    datasets: [{
                        data: [
                            {{ $statusBreakdown['submitted'] }},
                            {{ $statusBreakdown['under_review'] }},
                            {{ $statusBreakdown['planned'] }},
                            {{ $statusBreakdown['in_progress'] }},
                            {{ $statusBreakdown['resolved'] }},
                            {{ $statusBreakdown['closed'] }}
                        ],
                        backgroundColor: [
                            '#94a3b8', // slate-400
                            '#fbbf24', // amber-400
                            '#60a5fa', // blue-400
                            '#818cf8', // indigo-400
                            '#34d399', // emerald-400
                            '#a1a1aa' // zinc-400
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    family: "'DM Sans', sans-serif",
                                    size: 12
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });

            // Type Chart
            const typeCtx = document.getElementById('typeChart').getContext('2d');
            new Chart(typeCtx, {
                type: 'bar',
                data: {
                    labels: ['Bugs', 'Features', 'Satisfaction'],
                    datasets: [{
                        label: 'Feedback Count',
                        data: [
                            {{ $typeBreakdown['bugs'] }},
                            {{ $typeBreakdown['features'] }},
                            {{ $typeBreakdown['satisfaction'] }}
                        ],
                        backgroundColor: [
                            '#f87171', // red-400
                            '#34d399', // emerald-400
                            '#60a5fa' // blue-400
                        ],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });

        // AI Insights Logic
        const generateBtn = document.getElementById('generateInsightsBtn');
        const providerSelect = document.getElementById('aiProviderSelect');
        const contentDiv = document.getElementById('aiInsightsContent');
        const proseDiv = contentDiv.querySelector('.prose');
        const loadingDiv = document.getElementById('aiLoading');

        generateBtn.addEventListener('click', async function() {
        const providerId = providerSelect.value;
        if (!providerId) return;

        // UI State: Loading
        generateBtn.disabled = true;
        generateBtn.classList.add('opacity-75', 'cursor-not-allowed');
        contentDiv.classList.add('hidden');
        loadingDiv.classList.remove('hidden');

        try {
            const response = await fetch("{{ route('admin.feedback.analyze') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ai_provider_id: providerId
                })
            });

            const data = await response.json();

            if (data.success) {
                // Format the output (simple markdown to HTML conversion)
                const htmlContent = marked.parse(data.analysis);
                proseDiv.innerHTML = htmlContent;
                contentDiv.classList.remove('hidden');
            } else {
                alert(data.message || 'Failed to generate insights');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An unexpected error occurred');
        } finally {
            // UI State: Reset
            loadingDiv.classList.add('hidden');
            generateBtn.disabled = false;
            generateBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
        });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush
