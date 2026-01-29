@extends('user.layout')

@section('title', 'Career Assessment Results')
@section('header', 'Assessment Results')

@section('content')
    <div class="pt-10 pb-20 px-4 font-open-sans">
        <div class="max-w-5xl mx-auto">
            <!-- Score Hero -->
            <div
                class="bg-gradient-to-br from-blue-700 via-indigo-700 to-violet-800 rounded-[3rem] p-10 md:p-16 text-center text-white mb-12 shadow-2xl shadow-indigo-500/30 relative overflow-hidden group">
                <!-- Background Elements -->
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
                </div>
                <div
                    class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl transition-transform group-hover:scale-110 duration-700">
                </div>
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl transition-transform group-hover:scale-110 duration-700">
                </div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <span
                            class="text-indigo-200 text-sm font-bold uppercase tracking-widest">{{ $assessment->created_at->format('M d, Y') }}</span>
                        @auth
                            <a href="{{ route('career-compass.history') }}"
                                class="text-white/80 hover:text-white text-sm font-bold flex items-center gap-2 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i> Back to History
                            </a>
                        @endauth
                    </div>

                    <p class="text-indigo-100 mb-6 font-bold uppercase tracking-[0.3em] text-xs">Career Velocity Index</p>
                    <div class="flex items-center justify-center gap-6 mb-4">
                        <div class="h-px w-10 bg-white/20"></div>
                        <div
                            class="text-8xl md:text-9xl font-black font-poppins tracking-tighter drop-shadow-2xl tabular-nums">
                            {{ number_format($assessment->impact_score, 0) }}
                        </div>
                        <div class="h-px w-10 bg-white/20"></div>
                    </div>
                    <p class="text-xl text-indigo-200 mb-10 font-medium">Impact Score <span class="opacity-40">/
                            {{ \App\Models\CareerAssessment::MAX_IMPACT_SCORE }}</span>
                    </p>

                    <div
                        class="inline-flex items-center gap-4 px-8 py-4 rounded-3xl text-xl font-black font-poppins shadow-inner-white backdrop-blur-xl border border-white/20
                    {{ $assessment->status === 'exceptional'
                        ? 'bg-yellow-400 text-yellow-950'
                        : ($assessment->status === 'thriving'
                            ? 'bg-emerald-400 text-emerald-950'
                            : ($assessment->status === 'growing'
                                ? 'bg-amber-400 text-amber-950'
                                : ($assessment->status === 'struggling'
                                    ? 'bg-orange-400 text-orange-950'
                                    : 'bg-red-400 text-red-950'))) }}">
                        <i
                            class="fa-solid {{ $assessment->status === 'exceptional' ? 'fa-trophy' : ($assessment->status === 'thriving' ? 'fa-arrow-trend-up' : 'fa-chart-simple') }} w-6 h-6"></i>
                        {{ $assessment->status_label }}
                    </div>

                    <div class="mt-12 flex flex-wrap justify-center gap-12">
                        <div class="group/item cursor-help">
                            <span
                                class="text-indigo-200 text-xs font-black uppercase tracking-widest block mb-2 opacity-60">Environment</span>
                            <div
                                class="text-3xl font-black font-poppins tabular-nums group-hover/item:text-emerald-400 transition-colors">
                                {{ number_format($assessment->environment_total, 1) }} <span
                                    class="text-sm font-bold opacity-40">/
                                    {{ \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE }}</span>
                            </div>
                        </div>
                        <div class="hidden sm:block w-px h-16 bg-white/10"></div>
                        <div class="group/item cursor-help">
                            <span
                                class="text-indigo-200 text-xs font-black uppercase tracking-widest block mb-2 opacity-60">Skills</span>
                            <div
                                class="text-3xl font-black font-poppins tabular-nums group-hover/item:text-amber-400 transition-colors">
                                {{ number_format($assessment->skills_total, 1) }} <span
                                    class="text-sm font-bold opacity-40">/
                                    {{ \App\Models\CareerAssessment::MAX_SKILLS_SCORE }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid with Chart.js + Alpine.js -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Environment Radar Chart -->
                <div
                    class="glass-card bg-white rounded-[2.5rem] p-8 shadow-xl shadow-blue-500/5 transition-all hover:shadow-2xl hover:shadow-blue-500/10">
                    <div class="flex items-center justify-between mb-8">
                        <h3
                            class="font-black text-slate-900 flex items-center gap-3 font-poppins uppercase tracking-wider text-sm">
                            <div
                                class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shadow-inner">
                                <i class="fa-regular fa-building w-5 h-5"></i>
                            </div>
                            Environment Analysis
                        </h3>
                        <div
                            class="bg-blue-50 px-3 py-1 rounded-full text-[10px] font-black text-blue-600 uppercase tracking-widest border border-blue-100">
                            Max {{ \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE }} pts
                        </div>
                    </div>

                    <div class="relative" style="height: 300px;">
                        <canvas id="envChart"></canvas>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Aggregate</span>
                        <span
                            class="text-2xl font-black text-blue-600 font-poppins">{{ number_format($assessment->environment_total, 1) }}
                            <span class="text-xs font-bold text-slate-300">/
                                {{ \App\Models\CareerAssessment::MAX_ENVIRONMENT_SCORE }}</span></span>
                    </div>
                </div>

                <!-- Skills Bar Chart -->
                <div
                    class="glass-card bg-white rounded-[2.5rem] p-8 shadow-xl shadow-amber-500/5 transition-all hover:shadow-2xl hover:shadow-amber-500/10">
                    <div class="flex items-center justify-between mb-8">
                        <h3
                            class="font-black text-slate-900 flex items-center gap-3 font-poppins uppercase tracking-wider text-sm">
                            <div
                                class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shadow-inner">
                                <i class="fa-solid fa-wand-magic-sparkles w-5 h-5"></i>
                            </div>
                            Skill Proficiency
                        </h3>
                        <div
                            class="bg-amber-50 px-3 py-1 rounded-full text-[10px] font-black text-amber-600 uppercase tracking-widest border border-amber-100">
                            Max {{ \App\Models\CareerAssessment::MAX_SKILLS_SCORE }} pts
                        </div>
                    </div>

                    <div class="relative" style="height: 300px;">
                        <canvas id="skillsChart"></canvas>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Aggregate</span>
                        <span
                            class="text-2xl font-black text-amber-600 font-poppins">{{ number_format($assessment->skills_total, 1) }}
                            <span class="text-xs font-bold text-slate-300">/
                                {{ \App\Models\CareerAssessment::MAX_SKILLS_SCORE }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Impact Gauge -->
            <div class="glass-card bg-white rounded-[2.5rem] p-10 shadow-xl shadow-indigo-500/5 mb-12">
                <h3
                    class="font-black text-slate-900 mb-10 flex items-center justify-center gap-3 font-poppins uppercase tracking-wider text-sm">
                    <i class="fa-solid fa-bolt w-5 h-5 text-yellow-500"></i>
                    Impact Potential Gauge
                </h3>
                <div class="flex items-center justify-center">
                    <div class="relative" style="width: 400px; height: 220px;">
                        <canvas id="gaugeChart"></canvas>
                    </div>
                </div>
                <div
                    class="flex justify-between max-w-lg mx-auto mt-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                    <span>Critical</span>
                    <span class="hidden sm:inline">Struggling</span>
                    <span>Growing</span>
                    <span class="hidden sm:inline">Thriving</span>
                    <span>Peak</span>
                </div>
            </div>

            <!-- Strengths -->
            @if (count($strengths) > 0)
                <div
                    class="glass-card bg-white rounded-[2.5rem] p-10 mb-12 border border-emerald-100 shadow-xl shadow-emerald-500/5 relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>
                    <h3
                        class="font-black text-emerald-800 mb-8 flex items-center gap-3 font-poppins uppercase tracking-wider text-sm">
                        <i class="fa-solid fa-award w-5 h-5"></i>
                        Competitive Strengths
                    </h3>
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($strengths as $strength)
                            <div
                                class="bg-white/50 backdrop-blur-md rounded-2xl p-6 border border-emerald-100/50 shadow-sm group hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="font-bold text-slate-900 font-poppins">{{ $strength['label'] }}</span>
                                    <div
                                        class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center font-black tabular-nums">
                                        {{ number_format($strength['score'], 1) }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1 bg-emerald-100/80 text-emerald-700 text-[9px] font-black rounded-lg uppercase tracking-wider">
                                        {{ $strength['level'] === 'excellent' ? '✨ ELITE' : '✓ PRO' }}
                                    </span>
                                    <div class="flex-1 h-1 bg-emerald-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full"
                                            style="width: {{ ($strength['score'] / 2) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recommendations -->
            @if (count($recommendations) > 0)
                <div
                    class="glass-card bg-white rounded-[2.5rem] p-10 mb-12 border border-blue-100 shadow-xl shadow-blue-500/5">
                    <h3
                        class="font-black text-slate-900 mb-10 flex items-center gap-3 font-poppins uppercase tracking-wider text-sm">
                        <i class="fa-solid fa-map w-5 h-5 text-blue-600"></i>
                        Personalized Growth Roadmap
                    </h3>
                    <div class="space-y-8">
                        @foreach ($recommendations as $index => $rec)
                            <div
                                class="group relative bg-white/40 backdrop-blur-md rounded-[2rem] p-8 border border-white/40 shadow-sm hover:shadow-xl transition-all duration-300">
                                <div class="flex flex-col md:flex-row items-start gap-8">
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center font-black text-xl text-white shrink-0 shadow-lg {{ $rec['severity'] === 'critical' ? 'bg-rose-500 shadow-rose-500/20' : ($rec['severity'] === 'warning' ? 'bg-orange-500 shadow-orange-500/20' : 'bg-blue-600 shadow-blue-500/20') }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-4 mb-4">
                                            <h4 class="text-xl font-black text-slate-900 font-poppins">{{ $rec['title'] }}
                                            </h4>
                                            <span
                                                class="px-3 py-1 text-[10px] font-black rounded-xl uppercase tracking-widest {{ $rec['severity'] === 'critical' ? 'bg-rose-100 text-rose-700' : ($rec['severity'] === 'warning' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') }}">
                                                {{ $rec['label'] }}: {{ number_format($rec['score'], 1) }} / 2.0
                                            </span>
                                        </div>
                                        @if (!empty($rec['actions']))
                                            <div class="grid sm:grid-cols-2 gap-4 mb-6">
                                                @foreach ($rec['actions'] as $action)
                                                    <div
                                                        class="flex items-start gap-3 p-4 bg-white/60 rounded-2xl border border-slate-100">
                                                        <i
                                                            class="fa-solid fa-circle-arrow-right w-4 h-4 text-slate-300 mt-0.5"></i>
                                                        <p class="text-sm font-medium text-slate-600">{{ $action }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if (!empty($rec['timeline']))
                                            <div
                                                class="flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl w-fit border border-slate-100 shadow-inner">
                                                <i class="fa-regular fa-clock w-3.5 h-3.5 text-slate-400"></i>
                                                <span
                                                    class="text-xs font-bold text-slate-500 tracking-tighter uppercase">{{ $rec['timeline'] }}
                                                    <span class="opacity-50 font-medium lowercase">strategy</span></span>
                                            </div>
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
                <div
                    class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-[2.5rem] p-10 mb-12 text-white shadow-2xl shadow-blue-500/20 relative overflow-hidden group">
                    <div
                        class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl transition-transform group-hover:scale-125">
                    </div>
                    <div class="flex flex-col md:flex-row items-center gap-10 relative">
                        <div
                            class="w-20 h-20 bg-white/15 backdrop-blur-md rounded-3xl flex items-center justify-center shrink-0 border border-white/10 shadow-xl">
                            <i class="fa-solid fa-history w-10 h-10 text-white"></i>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-2xl font-black font-poppins mb-2 tracking-tight">Preserve Your Assessment History
                            </h4>
                            <p class="text-blue-100 font-medium leading-relaxed">Join 2,000+ PMs and unlock long-term
                                trajectory tracking, peer benchmarks, and a permanent record of your growth journey.</p>
                        </div>
                        <a href="{{ route('register') }}"
                            class="px-10 py-5 bg-white text-blue-700 font-black rounded-2xl hover:shadow-2xl hover:scale-105 transition-all whitespace-nowrap shadow-xl">
                            Create Free Account
                        </a>
                    </div>
                </div>
            @endguest

            <!-- Actions -->
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ route('career-compass.download-pdf', $assessment->id ?? null) }}" target="_blank"
                    class="px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl hover:bg-slate-50 border border-slate-200 transition-all flex items-center gap-3 shadow-md hover:shadow-lg active:scale-95">
                    <i class="fa-solid fa-file-pdf w-5 h-5 text-blue-600"></i>
                    Download PDF
                </a>
                <a href="{{ route('career-compass.assess') }}"
                    class="px-8 py-4 bg-slate-100 text-slate-700 font-bold rounded-2xl hover:bg-slate-200 transition-all cursor-pointer flex items-center gap-3 shadow-sm hover:shadow-md active:scale-95">
                    <i class="fa-solid fa-rotate w-5 h-5"></i>
                    New Assessment
                </a>
                <a href="{{ route('career-compass.index') }}"
                    class="px-10 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-black rounded-2xl hover:shadow-2xl hover:shadow-blue-500/30 transition-all flex items-center gap-3 active:scale-95 shadow-lg shadow-blue-500/20">
                    <i class="fa-solid fa-table-columns w-5 h-5"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart === 'undefined') return;

            // Environment Radar Chart
            new Chart(document.getElementById('envChart').getContext('2d'), {
                type: 'radar',
                data: {
                    labels: ['Manager', 'Resources', 'Team', 'Scope', 'Compensation', 'Culture'],
                    datasets: [{
                        label: 'Your Scores',
                        data: [
                            {{ $assessment->manager_score }},
                            {{ $assessment->resources_score }},
                            {{ $assessment->team_score }},
                            {{ $assessment->scope_score }},
                            {{ $assessment->compensation_score }},
                            {{ $assessment->culture_score }}
                        ],
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6,
                    }, {
                        label: 'Maximum',
                        data: [2, 2, 2, 2, 2, 2],
                        backgroundColor: 'transparent',
                        borderColor: 'rgba(148, 163, 184, 0.2)',
                        borderWidth: 1,
                        borderDash: [5, 5],
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 2,
                            ticks: {
                                display: false,
                                stepSize: 0.5
                            },
                            grid: {
                                color: 'rgba(148, 163, 184, 0.1)'
                            },
                            angleLines: {
                                color: 'rgba(148, 163, 184, 0.1)'
                            },
                            pointLabels: {
                                font: {
                                    family: 'Poppins',
                                    size: 10,
                                    weight: '600'
                                }
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

            // Skills Bar Chart
            const skillsData = [
                {{ $assessment->communication_score }},
                {{ $assessment->leadership_score }},
                {{ $assessment->strategy_score }},
                {{ $assessment->execution_score }}
            ];
            const skillsColors = skillsData.map(v => v >= 1.5 ? 'rgba(245, 158, 11, 0.8)' : (v < 1 ?
                'rgba(239, 68, 68, 0.8)' : 'rgba(251, 191, 36, 0.8)'));

            new Chart(document.getElementById('skillsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Communication', 'Leadership', 'Strategy', 'Execution'],
                    datasets: [{
                        label: 'Score',
                        data: skillsData,
                        backgroundColor: skillsColors,
                        borderRadius: 12,
                        barThickness: 32
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 2,
                            display: false
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Poppins',
                                    weight: '600',
                                    size: 11
                                },
                                color: '#1e293b'
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

            // Impact Gauge
            const score = {{ $assessment->impact_score }};
            let color = '#3b82f6';
            if (score >= 81) color = '#7c3aed';
            else if (score >= 61) color = '#10b981';
            else if (score >= 41) color = '#f59e0b';
            else if (score >= 21) color = '#f97316';
            else color = '#ef4444';

            new Chart(document.getElementById('gaugeChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [score, 96 - score],
                        backgroundColor: [color, 'rgba(226, 232, 240, 0.4)'],
                        borderWidth: 0,
                        circumference: 180,
                        rotation: 270,
                        borderRadius: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '82%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    }
                },
                plugins: [{
                    id: 'centerText',
                    afterDraw: function(chart) {
                        const ctx = chart.ctx;
                        const centerX = chart.width / 2;
                        const centerY = chart.height - 30;
                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.font = 'black 48px Poppins, sans-serif';
                        ctx.fillStyle = '#1e293b';
                        ctx.fillText(score.toFixed(0), centerX, centerY - 10);
                        ctx.font = 'bold 10px Poppins, sans-serif';
                        ctx.fillStyle = '#94a3b8';
                        ctx.letterSpacing = '2px';
                        // Dynamic max score label
                        ctx.fillText(
                            'OUT OF {{ \App\Models\CareerAssessment::MAX_IMPACT_SCORE }}',
                            centerX, centerY + 15);
                        ctx.restore();
                    }
                }]
            });
        });
    </script>
@endsection
