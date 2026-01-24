<div class="min-h-screen bg-gradient-to-br from-slate-50 to-indigo-50">
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
                                Part 1 of 3: Your Work Environment
                            @elseif($currentStep == 3)
                                Part 2 of 3: Your Skills
                            @elseif($currentStep == 4)
                                Part 3 of 3: Review Your Scores
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
                        @foreach ([['Start', 1], ['Environment', 2], ['Skills', 3], ['Review', 4]] as $step)
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
                <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                    <!-- Step 1: Intro -->
                    @if ($currentStep == 1)
                        <div class="p-8 md:p-12 text-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-500/30">
                                <span class="text-4xl">🧭</span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">PM Career Compass</h1>
                            <p class="text-lg text-slate-600 mb-8 max-w-xl mx-auto">
                                Rate 10 factors on a scale of 0-2 to calculate your Impact Score and get personalized
                                career recommendations.
                            </p>

                            <div class="bg-indigo-50 rounded-xl p-6 mb-8 max-w-md mx-auto border border-indigo-100">
                                <p class="text-sm text-indigo-700 mb-3 font-medium">Scoring Guide</p>
                                <div class="space-y-2 text-sm text-left">
                                    <div class="flex items-center gap-2">
                                        <span class="w-12 font-mono font-bold text-red-600">0-0.75</span>
                                        <span class="text-slate-600">Poor / Problematic</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-12 font-mono font-bold text-amber-600">1.0</span>
                                        <span class="text-slate-600">Neutral / Average</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-12 font-mono font-bold text-emerald-600">1.25-2</span>
                                        <span class="text-slate-600">Good / Excellent</span>
                                    </div>
                                </div>
                            </div>

                            <button wire:click="nextStep"
                                class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-bold text-lg rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30 cursor-pointer inline-flex items-center gap-3">
                                <span>Start Assessment</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Step 2: Environment -->
                    @elseif($currentStep == 2)
                        <div class="p-8 md:p-12">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Work Environment</h2>
                                    <p class="text-slate-500">Rate these 6 external factors (max 12 points)</p>
                                </div>
                            </div>

                            <div class="space-y-8">
                                @foreach (['manager', 'resources', 'team', 'scope', 'compensation', 'culture'] as $variable)
                                    @php $config = $environmentConfig[$variable] ?? []; @endphp
                                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h3 class="font-bold text-slate-900 mb-1">
                                                    {{ $config['label'] ?? ucfirst($variable) }}</h3>
                                                <p class="text-sm text-slate-600">{{ $config['question'] ?? '' }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span
                                                    class="text-2xl font-bold text-indigo-600">{{ number_format($$variable, 2) }}</span>
                                                <span class="text-sm text-slate-400">/2</span>
                                            </div>
                                        </div>
                                        <input type="range" wire:model.live="{{ $variable }}" min="0"
                                            max="2" step="0.25"
                                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                        <div class="flex justify-between mt-2 text-xs text-slate-400">
                                            <span>Poor</span>
                                            <span>Average</span>
                                            <span>Excellent</span>
                                        </div>
                                        @if (!empty($config['why_matters']))
                                            <p
                                                class="mt-3 text-xs text-slate-500 bg-white rounded-lg p-3 border border-slate-100">
                                                <strong>Why this matters:</strong> {{ $config['why_matters'] }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Environment Total -->
                            <div class="mt-8 bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-emerald-800">Environment Total</span>
                                    <span
                                        class="text-2xl font-bold text-emerald-600">{{ number_format($environmentTotal, 2) }}
                                        <span class="text-base font-normal text-emerald-500">/ 12</span></span>
                                </div>
                                <div class="mt-3 h-3 bg-emerald-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                                        style="width: {{ ($environmentTotal / 12) * 100 }}%"></div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between mt-8">
                                <button wire:click="previousStep"
                                    class="px-6 py-3 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors cursor-pointer flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Back
                                </button>
                                <button wire:click="nextStep"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-medium rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all cursor-pointer flex items-center gap-2">
                                    Continue to Skills
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Skills -->
                    @elseif($currentStep == 3)
                        <div class="p-8 md:p-12">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Your Skills</h2>
                                    <p class="text-slate-500">Rate these 4 skill areas (max 8 points)</p>
                                </div>
                            </div>

                            <div class="space-y-8">
                                @foreach (['communication', 'leadership', 'strategy', 'execution'] as $variable)
                                    @php $config = $skillsConfig[$variable] ?? []; @endphp
                                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h3 class="font-bold text-slate-900 mb-1">
                                                    {{ $config['label'] ?? ucfirst($variable) }}</h3>
                                                <p class="text-sm text-slate-600">{{ $config['question'] ?? '' }}</p>
                                                @if (!empty($config['examples']))
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach ($config['examples'] as $example)
                                                            <span
                                                                class="text-xs bg-white px-2 py-1 rounded-md text-slate-500 border border-slate-200">{{ $example }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-right ml-4">
                                                <span
                                                    class="text-2xl font-bold text-amber-600">{{ number_format($$variable, 2) }}</span>
                                                <span class="text-sm text-slate-400">/2</span>
                                            </div>
                                        </div>
                                        <input type="range" wire:model.live="{{ $variable }}" min="0"
                                            max="2" step="0.25"
                                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-600">
                                        <div class="flex justify-between mt-2 text-xs text-slate-400">
                                            <span>Needs Work</span>
                                            <span>Competent</span>
                                            <span>Expert</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Skills Total -->
                            <div class="mt-8 bg-amber-50 rounded-xl p-6 border border-amber-200">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-amber-800">Skills Total</span>
                                    <span
                                        class="text-2xl font-bold text-amber-600">{{ number_format($skillsTotal, 2) }}
                                        <span class="text-base font-normal text-amber-500">/ 8</span></span>
                                </div>
                                <div class="mt-3 h-3 bg-amber-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full transition-all duration-300"
                                        style="width: {{ ($skillsTotal / 8) * 100 }}%"></div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between mt-8">
                                <button wire:click="previousStep"
                                    class="px-6 py-3 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors cursor-pointer flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Back
                                </button>
                                <button wire:click="nextStep"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-medium rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all cursor-pointer flex items-center gap-2">
                                    Review My Scores
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Review -->
                    @elseif($currentStep == 4)
                        <div class="p-8 md:p-12">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-slate-900">Review Your Assessment</h2>
                                    <p class="text-slate-500">Confirm your scores before calculating results</p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <!-- Environment Summary -->
                                <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                                    <h3 class="font-bold text-emerald-800 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                        Environment Scores
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach (['manager' => 'Manager', 'resources' => 'Resources', 'team' => 'Team', 'scope' => 'Scope', 'compensation' => 'Compensation', 'culture' => 'Culture'] as $key => $label)
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700">{{ $label }}</span>
                                                <span
                                                    class="font-mono font-bold {{ $$key >= 1.5 ? 'text-emerald-600' : ($$key < 1 ? 'text-red-500' : 'text-amber-600') }}">{{ number_format($$key, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div
                                        class="mt-4 pt-4 border-t border-emerald-200 flex items-center justify-between">
                                        <span class="font-bold text-emerald-800">Total</span>
                                        <span
                                            class="text-xl font-bold text-emerald-600">{{ number_format($environmentTotal, 2) }}
                                            / 12</span>
                                    </div>
                                </div>

                                <!-- Skills Summary -->
                                <div class="bg-amber-50 rounded-xl p-6 border border-amber-200">
                                    <h3 class="font-bold text-amber-800 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                            </path>
                                        </svg>
                                        Skills Scores
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach (['communication' => 'Communication', 'leadership' => 'Leadership', 'strategy' => 'Strategy', 'execution' => 'Execution'] as $key => $label)
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700">{{ $label }}</span>
                                                <span
                                                    class="font-mono font-bold {{ $$key >= 1.5 ? 'text-emerald-600' : ($$key < 1 ? 'text-red-500' : 'text-amber-600') }}">{{ number_format($$key, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-amber-200 flex items-center justify-between">
                                        <span class="font-bold text-amber-800">Total</span>
                                        <span
                                            class="text-xl font-bold text-amber-600">{{ number_format($skillsTotal, 2) }}
                                            / 8</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Impact Preview -->
                            <div
                                class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl p-8 text-center text-white mb-8">
                                <p class="text-indigo-100 mb-2">Your Projected Impact Score</p>
                                <div class="text-5xl font-bold mb-2">{{ number_format($impactScore, 1) }}</div>
                                <p class="text-indigo-200">out of 96 points</p>
                                <p class="text-sm mt-4 text-indigo-100">
                                    Formula: {{ number_format($environmentTotal, 2) }} ×
                                    {{ number_format($skillsTotal, 2) }} = {{ number_format($impactScore, 2) }}
                                </p>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-between">
                                <button wire:click="previousStep"
                                    class="px-6 py-3 bg-slate-100 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition-colors cursor-pointer flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Edit Scores
                                </button>
                                <button wire:click="calculateResults"
                                    class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-bold text-lg rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30 cursor-pointer flex items-center gap-3">
                                    <span>Calculate My Impact Score</span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
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
                wire:click="closeLoginModal"></div>

            <!-- Modal -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
                    <!-- Close button -->
                    <button wire:click="closeLoginModal"
                        class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <div class="p-8 text-center">
                        <!-- Icon -->
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-500/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>

                        <!-- Title -->
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Get Your Full Results</h3>
                        <p class="text-slate-600 mb-6">
                            Login or create a free account to see your complete breakdown, personalized recommendations,
                            and save your assessment for future tracking.
                        </p>

                        <!-- Benefits -->
                        <div class="bg-indigo-50 rounded-xl p-4 mb-6 text-left border border-indigo-100">
                            <p class="text-sm font-medium text-indigo-800 mb-3">With an account you can:</p>
                            <ul class="space-y-2 text-sm text-indigo-700">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save unlimited assessments
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Track progress over time
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Compare trends over 6-12 months
                                </li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <a href="{{ route('login') }}"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Login to View Results
                            </a>
                            <a href="{{ route('register') }}"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl hover:bg-slate-200 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Create Free Account
                            </a>
                        </div>

                        <!-- Continue as Guest -->
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <button wire:click="continueAsGuest"
                                class="text-sm text-slate-500 hover:text-indigo-600 transition-colors cursor-pointer underline">
                                Continue as guest (limited features)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
