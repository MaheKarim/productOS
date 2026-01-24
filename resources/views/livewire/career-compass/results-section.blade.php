<div class="pt-28 pb-20 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Score Hero -->
        <div
            class="bg-gradient-to-br from-indigo-500 via-violet-500 to-purple-600 rounded-3xl p-8 md:p-12 text-center text-white mb-8 shadow-2xl shadow-indigo-500/30 relative overflow-hidden">
            <!-- Background Pattern -->
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:30px_30px]">
            </div>

            <div class="relative z-10">
                <p class="text-indigo-100 mb-2 font-medium">🎯 Your Career Impact Score</p>
                <div class="text-7xl md:text-8xl font-bold mb-2">{{ number_format($impactScore, 1) }}</div>
                <p class="text-xl text-indigo-200 mb-4">out of 96 points</p>

                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-lg font-bold
                    {{ $status === 'exceptional'
                        ? 'bg-yellow-400 text-yellow-900'
                        : ($status === 'thriving'
                            ? 'bg-emerald-400 text-emerald-900'
                            : ($status === 'growing'
                                ? 'bg-amber-400 text-amber-900'
                                : ($status === 'struggling'
                                    ? 'bg-orange-400 text-orange-900'
                                    : 'bg-red-400 text-red-900'))) }}">
                    {{ $statusLabel }}
                </div>

                <div class="mt-6 flex flex-wrap justify-center gap-8 text-sm">
                    <div>
                        <span class="text-indigo-200">Environment</span>
                        <div class="text-2xl font-bold">{{ number_format($environmentTotal, 2) }} / 12</div>
                    </div>
                    <div class="hidden sm:block w-px h-12 bg-white/20"></div>
                    <div>
                        <span class="text-indigo-200">Skills</span>
                        <div class="text-2xl font-bold">{{ number_format($skillsTotal, 2) }} / 8</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid with Chart.js + Alpine.js -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Environment Radar Chart -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-200" x-data x-init="$nextTick(() => {
                if (typeof Chart !== 'undefined') {
                    new Chart($refs.envChart.getContext('2d'), {
                        type: 'radar',
                        data: {
                            labels: ['Manager', 'Resources', 'Team', 'Scope', 'Compensation', 'Culture'],
                            datasets: [{
                                label: 'Your Scores',
                                data: [{{ $manager }}, {{ $resources }}, {{ $team }}, {{ $scope }}, {{ $compensation }}, {{ $culture }}],
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                pointBorderColor: '#fff',
                            }, {
                                label: 'Maximum',
                                data: [2, 2, 2, 2, 2, 2],
                                backgroundColor: 'rgba(148, 163, 184, 0.1)',
                                borderColor: 'rgba(148, 163, 184, 0.5)',
                                borderWidth: 1,
                                borderDash: [5, 5],
                                pointRadius: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { r: { beginAtZero: true, max: 2, ticks: { stepSize: 0.5 } } },
                            plugins: { legend: { display: false } }
                        }
                    });
                }
            })">
                <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    Environment Breakdown
                </h3>
                <div class="relative" style="height: 280px;">
                    <canvas x-ref="envChart"></canvas>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-sm text-slate-500">Total: </span>
                    <span class="text-lg font-bold text-emerald-600">{{ number_format($environmentTotal, 2) }} /
                        12</span>
                </div>
            </div>

            <!-- Skills Bar Chart -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-200" x-data x-init="$nextTick(() => {
                if (typeof Chart !== 'undefined') {
                    const data = [{{ $communication }}, {{ $leadership }}, {{ $strategy }}, {{ $execution }}];
                    const colors = data.map(v => v >= 1.5 ? 'rgba(16, 185, 129, 0.8)' : (v < 1 ? 'rgba(239, 68, 68, 0.8)' : 'rgba(245, 158, 11, 0.8)'));
                    new Chart($refs.skillsChart.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Communication', 'Leadership', 'Strategy', 'Execution'],
                            datasets: [{ label: 'Score', data: data, backgroundColor: colors, borderRadius: 8, barThickness: 40 }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { x: { beginAtZero: true, max: 2 }, y: { grid: { display: false } } },
                            plugins: { legend: { display: false } }
                        }
                    });
                }
            })">
                <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    Skills Breakdown
                </h3>
                <div class="relative" style="height: 280px;">
                    <canvas x-ref="skillsChart"></canvas>
                </div>
                <div class="mt-4 text-center">
                    <span class="text-sm text-slate-500">Total: </span>
                    <span class="text-lg font-bold text-amber-600">{{ number_format($skillsTotal, 2) }} / 8</span>
                </div>
            </div>
        </div>

        <!-- Impact Gauge -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-200 mb-8" x-data x-init="$nextTick(() => {
            if (typeof Chart !== 'undefined') {
                const score = {{ $impactScore }};
                let color = '#ef4444';
                if (score >= 81) color = '#eab308';
                else if (score >= 61) color = '#22c55e';
                else if (score >= 41) color = '#f59e0b';
                else if (score >= 21) color = '#f97316';
        
                new Chart($refs.gaugeChart.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [score, 96 - score],
                            backgroundColor: [color, 'rgba(226, 232, 240, 0.5)'],
                            borderWidth: 0,
                            circumference: 180,
                            rotation: 270
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: { legend: { display: false }, tooltip: { enabled: false } }
                    },
                    plugins: [{
                        id: 'centerText',
                        afterDraw: function(chart) {
                            const ctx = chart.ctx;
                            const centerX = chart.width / 2;
                            const centerY = chart.height - 30;
                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.font = 'bold 32px Inter, sans-serif';
                            ctx.fillStyle = '#1e293b';
                            ctx.fillText(score.toFixed(1), centerX, centerY - 10);
                            ctx.font = '12px Inter, sans-serif';
                            ctx.fillStyle = '#64748b';
                            ctx.fillText('out of 96', centerX, centerY + 15);
                            ctx.restore();
                        }
                    }]
                });
            }
        })">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center justify-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Impact Score Distribution
            </h3>
            <div class="flex items-center justify-center">
                <div class="relative" style="width: 300px; height: 180px;">
                    <canvas x-ref="gaugeChart"></canvas>
                </div>
            </div>
            <div class="flex justify-between max-w-md mx-auto mt-4 text-xs text-slate-500">
                <span>0 - Critical</span>
                <span>24 - Struggling</span>
                <span>48 - Growing</span>
                <span>72 - Thriving</span>
                <span>96 - Peak</span>
            </div>
        </div>

        <!-- Strengths -->
        @if (count($strengths) > 0)
            <div class="bg-emerald-50 rounded-2xl p-6 mb-8 border border-emerald-200">
                <h3 class="font-bold text-emerald-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    💪 Your Top Strengths
                </h3>
                <div class="grid md:grid-cols-3 gap-4">
                    @foreach ($strengths as $strength)
                        <div class="bg-white rounded-xl p-4 border border-emerald-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-emerald-700">{{ $strength['label'] }}</span>
                                <span
                                    class="text-lg font-bold text-emerald-600">{{ number_format($strength['score'], 2) }}/2</span>
                            </div>
                            <span
                                class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-medium rounded-full">
                                {{ $strength['level'] === 'excellent' ? '✨ EXCELLENT' : '✓ GOOD' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recommendations -->
        @if (count($recommendations) > 0)
            <div class="bg-white rounded-2xl p-6 mb-8 shadow-lg border border-slate-200">
                <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    🎯 Your Priority Actions
                </h3>
                <div class="space-y-6">
                    @foreach ($recommendations as $index => $rec)
                        <div
                            class="rounded-xl p-5 border-2 
                            {{ $rec['severity'] === 'critical'
                                ? 'border-red-200 bg-red-50'
                                : ($rec['severity'] === 'warning'
                                    ? 'border-orange-200 bg-orange-50'
                                    : 'border-blue-200 bg-blue-50') }}">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white shrink-0
                                    {{ $rec['severity'] === 'critical'
                                        ? 'bg-red-500'
                                        : ($rec['severity'] === 'warning'
                                            ? 'bg-orange-500'
                                            : 'bg-blue-500') }}">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h4 class="font-bold text-slate-900">{{ $rec['title'] }}</h4>
                                        <span
                                            class="px-2 py-0.5 text-xs font-medium rounded-full
                                            {{ $rec['severity'] === 'critical'
                                                ? 'bg-red-200 text-red-700'
                                                : ($rec['severity'] === 'warning'
                                                    ? 'bg-orange-200 text-orange-700'
                                                    : 'bg-blue-200 text-blue-700') }}">
                                            {{ $rec['label'] }}: {{ number_format($rec['score'], 2) }}/2
                                        </span>
                                    </div>
                                    @if (!empty($rec['actions']))
                                        <ul class="space-y-1 mb-3">
                                            @foreach ($rec['actions'] as $action)
                                                <li class="flex items-start gap-2 text-sm text-slate-700">
                                                    <span class="text-slate-400">☐</span>
                                                    {{ $action }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if (!empty($rec['timeline']))
                                        <p class="text-xs text-slate-500">
                                            <strong>Timeline:</strong> {{ $rec['timeline'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Save Prompt for Guests -->
        @guest
            <div class="bg-gradient-to-r from-indigo-50 to-violet-50 rounded-2xl p-6 mb-8 border border-indigo-200">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="font-bold text-indigo-900 text-lg mb-1">Want to track your progress over time?</h4>
                        <p class="text-indigo-700">Create a free account to save unlimited assessments, track trends, and
                            compare scores over 6-12 months.</p>
                    </div>
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors whitespace-nowrap">
                        Create Free Account
                    </a>
                </div>
            </div>
        @endguest

        <!-- Actions -->
        <div class="flex flex-wrap justify-center gap-4">
            <button wire:click="retakeAssessment"
                class="px-6 py-3 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors cursor-pointer flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Retake Assessment
            </button>
            <a href="{{ route('career-compass.index') }}"
                class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Back to Career Compass
            </a>
        </div>
    </div>
</div>
