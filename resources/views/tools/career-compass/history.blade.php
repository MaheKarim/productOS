@extends('user.layout')

@section('title', 'Career Compass History')
@section('header', 'Career Compass History')

@section('content')
    <div class="space-y-6">
        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Impact Trend Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-chart-line text-blue-600 text-sm"></i>
                    </div>
                    Impact Score Trend
                </h3>

                <div class="relative h-64 w-full">
                    <canvas id="impactTrendChart"></canvas>
                </div>
            </div>

            <!-- Summary Card -->
            <div
                class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg shadow-blue-500/20">
                <h3 class="font-bold text-lg mb-1">Latest Assessment</h3>
                <p class="text-blue-100 text-sm mb-6">
                    {{ $latestAssessment ? $latestAssessment->created_at->format('M d, Y') : 'No assessments yet' }}
                </p>

                @if ($latestAssessment)
                    <div class="mb-6">
                        <div class="text-4xl font-bold mb-1">{{ number_format($latestAssessment->impact_score, 1) }}
                        </div>
                        <div
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 border border-white/20 backdrop-blur-sm">
                            {{ $latestAssessment->status_label }}
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-blue-100">Environment</span>
                            <span
                                class="font-bold">{{ number_format($latestAssessment->environment_total, 1) }}/{{ \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE }}</span>
                        </div>
                        <div class="w-full bg-black/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5"
                                style="width: {{ ($latestAssessment->environment_total / \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE) * 100 }}%">
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm pt-2">
                            <span class="text-blue-100">Skills</span>
                            <span
                                class="font-bold">{{ number_format($latestAssessment->skills_total, 1) }}/{{ \App\Models\CareerAssessment::MAX_SKILLS_SCORE }}</span>
                        </div>
                        <div class="w-full bg-black/20 rounded-full h-1.5">
                            <div class="bg-white rounded-full h-1.5"
                                style="width: {{ ($latestAssessment->skills_total / \App\Models\CareerAssessment::MAX_SKILLS_SCORE) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('career-compass.results', $latestAssessment->id) }}"
                        class="mt-6 block w-full py-2.5 bg-white text-blue-700 text-center text-sm font-bold rounded-xl hover:bg-blue-50 transition-colors">
                        View Details
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center h-48">
                        <p class="text-blue-100 text-center mb-4">Start your first assessment to see your impact score.</p>
                        <a href="{{ route('career-compass.assess') }}"
                            class="px-4 py-2 bg-white text-blue-600 font-bold rounded-lg text-sm hover:bg-blue-50 transition-colors">
                            Start Assessment
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-900">Assessment History</h3>
                <a href="{{ route('career-compass.assess') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    + New Assessment
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase text-slate-500 font-semibold tracking-wider">
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Impact Score</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Environment</th>
                            <th class="px-6 py-4">Skills</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($assessments as $assessment)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $assessment->created_at->format('M d, Y') }}
                                    <span
                                        class="text-xs text-slate-400 block">{{ $assessment->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="font-bold text-slate-900">{{ number_format($assessment->impact_score, 1) }}</span>
                                        <span class="text-xs text-slate-400">/
                                            {{ \App\Models\CareerAssessment::MAX_IMPACT_SCORE }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $assessment->status_color }}">
                                        {{ $assessment->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ number_format($assessment->environment_total, 1) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ number_format($assessment->skills_total, 1) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('career-compass.results', $assessment->id) }}"
                                        class="text-sm font-medium text-slate-400 hover:text-blue-600 transition-colors">
                                        View Results <i
                                            class="fa-solid fa-arrow-right ml-1 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <i class="fa-regular fa-folder-open text-2xl text-slate-300"></i>
                                        <p>No assessments found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $assessments->links() }}
            </div>
        </div>
    </div>

    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('impactTrendChart');
            if (!ctx) return;

            // Prepare data (reverse to show oldest to newest)
            const assessments = @json($chartAssessments->reverse()->values());

            const labels = assessments.map(a => new Date(a.created_at).toLocaleDateString(undefined, {
                month: 'short',
                day: 'numeric'
            }));
            const impactScores = assessments.map(a => a.impact_score);
            const envScores = assessments.map(a => (a.environment_score /
                {{ \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE }}) * 100); // Normalized to percentage
            const skillScores = assessments.map(a => (a.skills_score /
                {{ \App\Models\CareerAssessment::MAX_SKILLS_SCORE }}) * 100); // Normalized to percentage

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Impact Score',
                        data: impactScores,
                        borderColor: '#4f46e5', // Indigo 600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: '#f1f5f9', // Slate 100
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    family: "'DM Sans', sans-serif",
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'DM Sans', sans-serif",
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: {
                                family: "'DM Sans', sans-serif",
                                size: 13
                            },
                            bodyFont: {
                                family: "'DM Sans', sans-serif",
                                size: 12
                            },
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Score: ' + context.parsed.y.toFixed(1);
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
@endsection
