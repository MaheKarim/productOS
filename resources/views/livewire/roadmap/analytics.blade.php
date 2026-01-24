<div wire:key="analytics-{{ $refreshKey ?? 0 }}-{{ $completedTopics }}"
    class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Your Progress</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Overall Key Metrics -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex flex-col items-center justify-center">
            <span class="text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $percentage }}%</span>
            <span class="text-sm text-gray-500 dark:text-gray-300">Overall Completion</span>
            <span class="text-xs text-gray-400 mt-1">{{ $completedTopics }} / {{ $totalTopics }} Topics</span>
        </div>

        <!-- Radar Chart for Skills -->
        <div class="md:col-span-2 relative h-64" x-data="analyticsChart(@js($categoryProgress))" x-init="init()">
            <canvas x-ref="radarChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('analyticsChart', (chartData) => ({
            chart: null,
            chartData: chartData,
            init() {
                this.$nextTick(() => {
                    this.renderChart();
                });
            },
            renderChart() {
                const ctx = this.$refs.radarChart;
                if (!ctx) return;

                // Destroy existing chart if any
                if (this.chart) {
                    this.chart.destroy();
                }

                this.chart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: this.chartData.map(c => c.name),
                        datasets: [{
                            label: 'Skill Proficiency (%)',
                            data: this.chartData.map(c => c.percentage),
                            fill: true,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgb(59, 130, 246)',
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(59, 130, 246)'
                        }]
                    },
                    options: {
                        elements: {
                            line: {
                                borderWidth: 3
                            }
                        },
                        scales: {
                            r: {
                                angleLines: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                pointLabels: {
                                    font: {
                                        size: 10
                                    }
                                },
                                suggestedMin: 0,
                                suggestedMax: 100
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        maintainAspectRatio: false
                    }
                });
            }
        }));
    });
</script>
