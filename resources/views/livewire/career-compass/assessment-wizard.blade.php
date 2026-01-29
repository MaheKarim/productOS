@push('head')
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .font-open-sans {
            font-family: 'Open Sans', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 font-open-sans">
    @if (!$showResults)
        <!-- Assessment Wizard -->
        <div class="pt-28 pb-20 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-slate-600">
                            @if ($currentStep == 1)
                                Getting Started
                            @elseif($currentStep == 2)
                                Part 1 of 2: Your Work Environment
                            @elseif($currentStep == 3)
                                Part 2 of 2: Your Skills
                            @endif
                        </span>
                        <span class="text-sm font-medium text-indigo-600">{{ $progressPercentage }}% Complete</span>
                    </div>
                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-600 rounded-full transition-all duration-500"
                            style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <!-- Step Indicators -->
                    <div class="flex justify-between mt-4">
                        @foreach ([['Start', 1], ['Environment', 2], ['Skills', 3]] as $step)
                            <button wire:click="goToStep({{ $step[1] }})"
                                class="flex flex-col items-center gap-1 cursor-pointer group {{ $currentStep >= $step[1] ? '' : 'opacity-50' }}">
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all
                                    {{ $currentStep == $step[1] ? 'bg-indigo-600 text-white' : ($currentStep > $step[1] ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500') }}">
                                    @if ($currentStep > $step[1])
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        {{ $step[1] }}
                                    @endif
                                </div>
                                <span class="text-xs text-slate-500 hidden sm:block">{{ $step[0] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Step Content -->
                <div
                    class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-500/10 overflow-hidden transition-all duration-500">
                    <!-- Step 1: Intro -->
                    @if ($currentStep == 1)
                        <div class="p-8 md:p-16 text-center">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-500/30 transform hover:scale-105 transition-transform duration-300">
                                <i data-lucide="compass" class="w-12 h-12 text-white"></i>
                            </div>
                            <h1
                                class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 font-poppins tracking-tight">
                                PM Career Compass</h1>
                            <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                                Unlock your professional potential. Rate 10 critical factors to calculate your <span
                                    class="font-bold text-blue-600">Impact Score</span> and receive a tailor-made career
                                roadmap.
                            </p>

                            <div
                                class="bg-white/50 backdrop-blur-md rounded-2xl p-8 mb-10 max-w-lg mx-auto border border-blue-100/50 shadow-sm">
                                <p
                                    class="text-sm text-blue-800 mb-5 font-bold uppercase tracking-wider font-poppins text-left">
                                    Scoring Guide</p>
                                <div class="space-y-4 text-sm text-left">
                                    <div class="flex items-center gap-4 group">
                                        <div class="w-12 h-1 text-red-500 bg-red-500 rounded-full"></div>
                                        <span
                                            class="w-20 font-mono font-bold text-red-600 bg-red-50 px-2 py-1 rounded">0
                                            - 0.75</span>
                                        <span class="text-slate-600 font-medium italic">Critical Improvement
                                            Needed</span>
                                    </div>
                                    <div class="flex items-center gap-4 group">
                                        <div class="w-12 h-1 text-amber-500 bg-amber-500 rounded-full"></div>
                                        <span
                                            class="w-20 font-mono font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">1.0</span>
                                        <span class="text-slate-600 font-medium italic">Standard / Baseline</span>
                                    </div>
                                    <div class="flex items-center gap-4 group">
                                        <div class="w-12 h-1 text-emerald-500 bg-emerald-500 rounded-full"></div>
                                        <span
                                            class="w-20 font-mono font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">1.25
                                            - 2</span>
                                        <span class="text-slate-600 font-medium italic">Exceptional Performance</span>
                                    </div>
                                </div>
                            </div>

                            <button wire:click="nextStep"
                                class="group px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold text-xl rounded-2xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all cursor-pointer inline-flex items-center gap-4 active:scale-95 shadow-lg shadow-blue-500/20">
                                <span>Begin Assessment</span>
                                <i data-lucide="arrow-right"
                                    class="w-6 h-6 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>

                        <!-- Step 2: Environment -->
                    @elseif($currentStep == 2)
                        <div class="p-8 md:p-12">
                            <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100/50">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-inner">
                                        <i data-lucide="building-2" class="w-8 h-8"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-3xl font-bold text-slate-900 font-poppins">Work Environment</h2>
                                        <p class="text-slate-500 font-medium">Quantify your primary external growth
                                            factors</p>
                                    </div>
                                </div>
                                <div
                                    class="hidden sm:flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-full border border-slate-100 text-slate-400 font-mono text-sm font-bold">
                                    12 pts max
                                </div>
                            </div>

                            <div class="space-y-10">
                                @foreach (['manager', 'resources', 'team', 'scope', 'compensation', 'culture'] as $variable)
                                    @php $config = $environmentConfig[$variable] ?? []; @endphp
                                    <div class="group relative">
                                        <div class="flex items-start justify-between mb-5">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2">
                                                    <h3
                                                        class="text-lg font-bold text-slate-900 font-poppins group-hover:text-blue-600 transition-colors">
                                                        {{ $config['label'] ?? ucfirst($variable) }}</h3>
                                                </div>
                                                <p class="text-slate-500 font-medium leading-relaxed">
                                                    {{ $config['question'] ?? '' }}</p>
                                            </div>
                                            <div class="text-right ml-4">
                                                <div
                                                    class="inline-flex items-baseline gap-1 bg-white px-3 py-1 rounded-xl shadow-sm border border-slate-100">
                                                    <span
                                                        class="text-3xl font-black text-blue-600 leading-none tabular-nums">{{ number_format($$variable, 2) }}</span>
                                                    <span
                                                        class="text-xs font-bold text-slate-300 uppercase tracking-tighter">/
                                                        2.0</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative px-1">
                                            <input type="range" wire:model.live="{{ $variable }}" min="0"
                                                max="2" step="0.25"
                                                class="w-full h-2.5 bg-slate-100 rounded-full appearance-none cursor-pointer accent-blue-600 hover:accent-indigo-600 transition-all">
                                            <div
                                                class="flex justify-between mt-3 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                                <span>Poor</span>
                                                <span class="text-slate-300">|</span>
                                                <span>Baseline</span>
                                                <span class="text-slate-300">|</span>
                                                <span>Elite</span>
                                            </div>
                                        </div>

                                        @if (!empty($config['why_matters']))
                                            <div
                                                class="mt-5 p-4 bg-blue-50/50 rounded-2xl border border-blue-100/30 flex gap-3 shadow-inner">
                                                <i data-lucide="info" class="w-4 h-4 text-blue-500 shrink-0 mt-0.5"></i>
                                                <p class="text-xs text-blue-800 leading-relaxed italic">
                                                    {{ $config['why_matters'] }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Environment Total Card -->
                            <div
                                class="mt-12 p-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl text-white shadow-xl shadow-blue-500/20 relative overflow-hidden group">
                                <div
                                    class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl transition-all group-hover:scale-150">
                                </div>
                                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                                            <i data-lucide="calculator" class="w-8 h-8"></i>
                                        </div>
                                        <div>
                                            <p class="text-blue-100 font-bold uppercase tracking-widest text-xs mb-1">
                                                Current Section Progress</p>
                                            <h4 class="text-2xl font-black font-poppins">Environment Score</h4>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex flex-col items-end">
                                            <div class="flex items-baseline gap-2">
                                                <span
                                                    class="text-5xl font-black tracking-tighter tabular-nums">{{ number_format($environmentTotal, 1) }}</span>
                                                <span class="text-blue-200 font-bold opacity-60">/ 12.0</span>
                                            </div>
                                            <div
                                                class="mt-4 w-48 h-2.5 bg-white/20 rounded-full overflow-hidden backdrop-blur-md">
                                                <div class="h-full bg-white rounded-full shadow-[0_0_10px_white] transition-all duration-700 ease-out"
                                                    style="width: {{ ($environmentTotal / 12) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between mt-12 pt-8 border-t border-slate-100/50">
                                <button wire:click="previousStep"
                                    class="px-8 py-3.5 bg-white text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all cursor-pointer flex items-center gap-3 border border-slate-200">
                                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                                    Previous
                                </button>
                                <button wire:click="nextStep"
                                    class="group px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-2xl hover:shadow-lg hover:shadow-blue-500/30 transition-all cursor-pointer flex items-center gap-3 shadow-md shadow-blue-500/10">
                                    Continue to Skills
                                    <i data-lucide="chevron-right"
                                        class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Skills -->
                    @elseif($currentStep == 3)
                        <div class="p-8 md:p-12">
                            <div class="flex items-center justify-between mb-10 pb-6 border-b border-slate-100/50">
                                <div class="flex items-center gap-5">
                                    <div
                                        class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-inner">
                                        <i data-lucide="sparkles" class="w-8 h-8"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-3xl font-bold text-slate-900 font-poppins">Professional Skills
                                        </h2>
                                        <p class="text-slate-500 font-medium">Quantify your core product management
                                            competencies</p>
                                    </div>
                                </div>
                                <div
                                    class="hidden sm:flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-full border border-slate-100 text-slate-400 font-mono text-sm font-bold">
                                    8 pts max
                                </div>
                            </div>

                            <div class="space-y-10">
                                @foreach (['communication', 'leadership', 'strategy', 'execution'] as $variable)
                                    @php $config = $skillsConfig[$variable] ?? []; @endphp
                                    <div class="group relative">
                                        <div class="flex items-start justify-between mb-5">
                                            <div class="flex-1">
                                                <h3
                                                    class="text-lg font-bold text-slate-900 font-poppins group-hover:text-amber-600 transition-colors">
                                                    {{ $config['label'] ?? ucfirst($variable) }}</h3>
                                                <p class="text-slate-500 font-medium leading-relaxed">
                                                    {{ $config['question'] ?? '' }}</p>

                                                @if (!empty($config['examples']))
                                                    <div class="mt-3 flex flex-wrap gap-2">
                                                        @foreach ($config['examples'] as $example)
                                                            <span
                                                                class="text-[10px] font-bold uppercase tracking-wider bg-white px-2.5 py-1 rounded-lg text-slate-400 border border-slate-100 shadow-sm transition-all hover:border-amber-200 hover:text-amber-500">
                                                                {{ $example }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-right ml-4">
                                                <div
                                                    class="inline-flex items-baseline gap-1 bg-white px-3 py-1 rounded-xl shadow-sm border border-slate-100">
                                                    <span
                                                        class="text-3xl font-black text-amber-600 leading-none tabular-nums">{{ number_format($$variable, 2) }}</span>
                                                    <span
                                                        class="text-xs font-bold text-slate-300 uppercase tracking-tighter">/
                                                        2.0</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative px-1">
                                            <input type="range" wire:model.live="{{ $variable }}"
                                                min="0" max="2" step="0.25"
                                                class="w-full h-2.5 bg-slate-100 rounded-full appearance-none cursor-pointer accent-amber-600 hover:accent-orange-500 transition-all">
                                            <div
                                                class="flex justify-between mt-3 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                                <span>Building</span>
                                                <span class="text-slate-300">|</span>
                                                <span>Proficient</span>
                                                <span class="text-slate-300">|</span>
                                                <span>Expert</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Skills Total Card -->
                            <div
                                class="mt-12 p-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl text-white shadow-xl shadow-amber-500/20 relative overflow-hidden group">
                                <div
                                    class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl transition-all group-hover:scale-150">
                                </div>
                                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-white/20 rounded-2xl backdrop-blur-md">
                                            <i data-lucide="award" class="w-8 h-8"></i>
                                        </div>
                                        <div>
                                            <p class="text-amber-100 font-bold uppercase tracking-widest text-xs mb-1">
                                                Current Section Progress</p>
                                            <h4 class="text-2xl font-black font-poppins">Skills Score</h4>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex flex-col items-end">
                                            <div class="flex items-baseline gap-2">
                                                <span
                                                    class="text-5xl font-black tracking-tighter tabular-nums">{{ number_format($skillsTotal, 1) }}</span>
                                                <span class="text-amber-100 font-bold opacity-60">/ 8.0</span>
                                            </div>
                                            <div
                                                class="mt-4 w-48 h-2.5 bg-white/20 rounded-full overflow-hidden backdrop-blur-md">
                                                <div class="h-full bg-white rounded-full shadow-[0_0_10px_white] transition-all duration-700 ease-out"
                                                    style="width: {{ ($skillsTotal / 8) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between mt-12 pt-8 border-t border-slate-100/50">
                                <button wire:click="previousStep" wire:loading.attr="disabled"
                                    class="px-8 py-3.5 bg-white text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all cursor-pointer flex items-center gap-3 border border-slate-200 disabled:opacity-50">
                                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                                    Back
                                </button>
                                <button x-data="{ loading: false }"
                                    x-on:click="
                                        if (!loading) {
                                            loading = true;
                                            $wire.calculateResults().finally(() => { loading = false; });
                                        }
                                    "
                                    x-bind:disabled="loading" x-bind:class="loading ? 'opacity-75 cursor-wait' : ''"
                                    class="group px-10 py-4 bg-gradient-to-r from-orange-500 to-rose-600 text-white font-black rounded-2xl hover:shadow-2xl hover:shadow-orange-500/40 transition-all cursor-pointer flex items-center gap-4 shadow-lg shadow-orange-500/20 active:scale-95 disabled:opacity-75">
                                    <span x-show="!loading">Generate My Roadmap</span>
                                    <span x-show="loading" x-cloak>Generating...</span>
                                    <i data-lucide="rocket" x-show="!loading"
                                        class="w-6 h-6 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                                    <svg x-show="loading" x-cloak class="animate-spin w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Results Dashboard -->
        @include('livewire.career-compass.results-section', [
            'impactScore' => $impactScore,
            'environmentTotal' => $environmentTotal,
            'skillsTotal' => $skillsTotal,
            'status' => $status,
            'statusLabel' => $statusLabel,
            'statusColor' => $statusColor,
            'recommendations' => $recommendations,
            'strengths' => $strengths,
            'manager' => $manager,
            'resources' => $resources,
            'team' => $team,
            'scope' => $scope,
            'compensation' => $compensation,
            'culture' => $culture,
            'communication' => $communication,
            'leadership' => $leadership,
            'strategy' => $strategy,
            'execution' => $execution,
        ])
    @endif

    <!-- Login Modal for Guest Users -->
    @if ($showLoginModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity"
                wire:click="closeLoginModal">
            </div>

            <!-- Modal -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative glass-card rounded-[2.5rem] shadow-2xl w-full max-w-md transform transition-all overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-indigo-600/5 -z-10"></div>

                    <!-- Close button -->
                    <button wire:click="closeLoginModal"
                        class="absolute top-6 right-6 p-2 text-slate-400 hover:text-slate-900 transition-colors cursor-pointer z-10">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>

                    <div class="p-10 text-center">
                        <!-- Icon -->
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-500/20 transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                            <i data-lucide="user-check" class="w-10 h-10 text-white"></i>
                        </div>

                        <!-- Title -->
                        <h3 class="text-3xl font-black text-slate-900 mb-3 font-poppins tracking-tight">Access Your
                            Full
                            Roadmap</h3>
                        <p class="text-slate-500 font-medium mb-8 leading-relaxed">
                            Join 2,000+ PMs tracking their career velocity. Sign in to unlock your personalized growth
                            strategy.
                        </p>

                        <!-- Benefits -->
                        <div
                            class="bg-blue-50/50 backdrop-blur-md rounded-2xl p-6 mb-8 text-left border border-blue-100/50">
                            <p class="text-xs font-black text-blue-800 mb-4 uppercase tracking-widest font-poppins">
                                Premium
                                Benefits</p>
                            <ul class="space-y-4">
                                <li class="flex items-center gap-3">
                                    <div
                                        class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                        <i data-lucide="save" class="w-3 h-3 text-blue-600"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">Save assessments & track
                                        trends</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div
                                        class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                        <i data-lucide="trending-up" class="w-3 h-3 text-blue-600"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">Progress velocity reports (6-12
                                        mo)</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div
                                        class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center shrink-0">
                                        <i data-lucide="gift" class="w-3 h-3 text-blue-600"></i>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">Exclusive PM career
                                        resources</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-4">
                            <a href="{{ route('login') }}"
                                class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-2xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                                <i data-lucide="log-in" class="w-5 h-5"></i>
                                Login to View Results
                            </a>
                            <a href="{{ route('register') }}"
                                class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all border border-slate-200">
                                <i data-lucide="user-plus" class="w-5 h-5"></i>
                                Create Free Account
                            </a>
                        </div>

                        <!-- Continue as Guest -->
                        <div class="mt-8 pt-6 border-t border-slate-100/50">
                            <button wire:click="continueAsGuest"
                                class="group text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors cursor-pointer flex items-center justify-center mx-auto gap-2">
                                <span>Continue as guest</span>
                                <i data-lucide="arrow-right"
                                    class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        // Initialize Lucide icons as soon as possible
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        // Re-initialize after any Livewire update
        document.addEventListener('livewire:initialized', () => {
            lucide.createIcons();

            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                lucide.createIcons();
            });

            Livewire.on('stepChanged', () => {
                setTimeout(() => {
                    lucide.createIcons();
                }, 50);
            });

            Livewire.on('resultsShown', () => {
                setTimeout(() => {
                    lucide.createIcons();
                }, 100);
            });
        });
    </script>
@endpush
