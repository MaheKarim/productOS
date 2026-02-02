@extends('user.layout')

@section('title', 'Practice - Question ' . ($currentIndex + 1))
@section('header', 'Interview Practice')

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{
        showAnswer: false,
        selectedAnswer: null,
        isSubmitting: false,
        checkAnswer() {
            if (this.selectedAnswer && !this.showAnswer && !this.isSubmitting) {
                this.isSubmitting = true;
                fetch('{{ route('user.interview-prep.submit', $session) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            question_id: {{ $question->id }},
                            answer: this.selectedAnswer
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.showAnswer = true;
                        this.isSubmitting = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.isSubmitting = false;
                    });
            }
        }
    }">
        {{-- Progress Bar --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-600">Question {{ $currentIndex + 1 }} of
                    {{ $totalQuestions }}</span>
                <a href="{{ route('user.interview-prep.end', ['session' => $session]) }}"
                    class="text-sm text-red-500 hover:text-red-600 font-medium flex items-center gap-1 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    End Session
                </a>
            </div>
            <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-teal-500 to-teal-400 rounded-full transition-all duration-300"
                    style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"></div>
            </div>
        </div>

        {{-- Question Card --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-lg overflow-hidden mb-6">
            {{-- Question Header --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <div class="flex flex-wrap gap-2">
                    @if ($question->difficulty)
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $question->difficulty === 'easy' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $question->difficulty === 'medium' ? 'bg-amber-100 text-amber-700' : '' }}
                            {{ $question->difficulty === 'hard' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($question->difficulty) }}
                        </span>
                    @endif
                    @if ($question->marks)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            {{ $question->marks }} Marks
                        </span>
                    @endif
                    @if ($question->question_for)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                            {{ $question->question_for }}
                        </span>
                    @endif
                    @foreach ($question->categories as $cat)
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-200 text-slate-600">
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Question Body --}}
            <div class="p-8">
                {{-- Question Type Badge if CQ --}}
                @if ($question->isCq())
                    <div class="mb-4">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Written Answer
                        </span>
                    </div>
                @endif

                <h2 class="text-xl md:text-2xl font-bold text-slate-900 leading-relaxed mb-6">
                    {{ $question->question }}
                </h2>

                @if ($question->source)
                    <p class="text-sm text-slate-500 flex items-center gap-2 mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Source: {{ $question->source }}
                    </p>
                @endif

                {{-- CONDITIONAL UI BASED ON TYPE --}}
                @if ($question->isCq())
                    {{-- WRITTEN ANSWER UI --}}
                    <div x-data="{
                        userAnswer: '',
                        isGrading: false,
                        gradingResult: null,
                        error: null,
                        gradeAnswer() {
                            if (this.userAnswer.length < 5) return;
                            this.isGrading = true;
                            this.error = null;
                            this.gradingResult = null;
                    
                            fetch('{{ route('user.interview-prep.grade', $question->id) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ answer: this.userAnswer })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.error) {
                                        this.error = data.error;
                                    } else {
                                        this.gradingResult = data;
                                    }
                                })
                                .catch(err => {
                                    this.error = 'Something went wrong. Please try again.';
                                })
                                .finally(() => {
                                    this.isGrading = false;
                                });
                        }
                    }">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Write your answer here:</label>
                            <textarea x-model="userAnswer" rows="6"
                                class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm"
                                placeholder="Type your detailed answer..."></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <button @click="gradeAnswer()" :disabled="userAnswer.length < 5 || isGrading"
                                class="px-6 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2">
                                <span x-show="!isGrading">Check Answer with AI</span>
                                <span x-show="isGrading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Analyzing...
                                </span>
                            </button>
                        </div>

                        {{-- Grading Result --}}
                        <div x-show="gradingResult" class="mt-6 p-6 bg-slate-50 rounded-2xl border border-slate-200"
                            x-transition>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-slate-800">AI Evaluation</h3>
                                <div class="px-4 py-1.5 rounded-full font-bold text-sm"
                                    :class="gradingResult?.score >= 7 ? 'bg-green-100 text-green-700' :
                                        'bg-amber-100 text-amber-700'">
                                    Score: <span x-text="gradingResult?.score"></span>/10
                                </div>
                            </div>
                            <div class="prose prose-sm max-w-none text-slate-600">
                                <p x-text="gradingResult?.feedback"></p>
                            </div>

                            {{-- Show Model Answer Trigger --}}
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                <button @click="showAnswer = !showAnswer"
                                    class="text-sm font-medium text-teal-600 hover:text-teal-700 underline">
                                    <span x-text="showAnswer ? 'Hide Model Answer' : 'See Model Answer'"></span>
                                </button>
                            </div>
                        </div>

                        {{-- Error Message --}}
                        <div x-show="error" class="mt-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 text-sm"
                            x-text="error"></div>

                        {{-- Collapsible Model Answer --}}
                        <div x-show="showAnswer" x-collapse class="mt-4">
                            @if ($question->explanation)
                                <div class="p-5 bg-teal-50 rounded-2xl border border-teal-100 mt-4">
                                    <h4 class="text-sm font-bold text-teal-800 mb-2">Explanation / Model Answer</h4>
                                    <p class="text-slate-700 text-sm leading-relaxed">{{ $question->explanation }}</p>
                                </div>
                            @elseif($question->correct_answer)
                                <div class="p-5 bg-green-50 rounded-2xl border border-green-100 mt-4">
                                    <h4 class="text-sm font-bold text-green-800 mb-2">Ideal Key Points:</h4>
                                    <ul class="list-disc list-inside text-sm text-slate-700">
                                        @foreach ($question->correct_answer as $ans)
                                            <li>{{ $ans }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        {{-- Navigation for CQ --}}
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            {{-- Before Grading --}}
                            <div x-show="!gradingResult"
                                class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                {{-- Previous (Ghost) --}}
                                @if ($currentIndex > 0)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex - 1]) }}"
                                        class="order-2 sm:order-1 px-5 py-3 text-slate-500 font-medium hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </a>
                                @else
                                    <div class="order-2 sm:order-1"></div>
                                @endif

                                {{-- Skip Question (Secondary) --}}
                                @if ($currentIndex < $totalQuestions - 1)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex + 1]) }}"
                                        class="order-1 sm:order-2 px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-medium hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                        Skip Question
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            {{-- After Grading: Next/Finish --}}
                            <div x-show="gradingResult" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                {{-- Previous --}}
                                @if ($currentIndex > 0)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex - 1]) }}"
                                        class="order-2 sm:order-1 px-5 py-3 text-slate-500 font-medium hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </a>
                                @else
                                    <div class="order-2 sm:order-1"></div>
                                @endif

                                {{-- Next/Finish --}}
                                @if ($currentIndex < $totalQuestions - 1)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex + 1]) }}"
                                        class="order-1 sm:order-2 w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer">
                                        Next Question
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('user.interview-prep.end', ['session' => $session]) }}"
                                        class="order-1 sm:order-2 w-full sm:w-auto px-8 py-4 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer">
                                        Finish Session
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    {{-- MCQ UI (Interactive) --}}
                    @if ($question->answers && count($question->answers) > 0)
                        <div class="space-y-4 mb-8">
                            @foreach ($question->answers as $index => $answer)
                                @php
                                    $isCorrect = in_array($answer, $question->correct_answer ?? []);
                                    $jsonAnswer = json_encode($answer);
                                    $jsonIsCorrect = json_encode($isCorrect);
                                @endphp
                                <div @click="if(!showAnswer) selectedAnswer = {{ $jsonAnswer }}"
                                    class="relative p-5 rounded-2xl border-2 transition-all duration-200 group cursor-pointer"
                                    :class="{
                                        'border-slate-200 bg-white hover:border-indigo-200 hover:bg-slate-50': !
                                            showAnswer && selectedAnswer !== {{ $jsonAnswer }},
                                        'border-indigo-600 bg-indigo-50/50 ring-2 ring-indigo-100 ring-offset-2': !
                                            showAnswer && selectedAnswer === {{ $jsonAnswer }},
                                        'border-green-500 bg-green-50 ring-2 ring-green-100 ring-offset-2': showAnswer &&
                                            {{ $jsonIsCorrect }},
                                        'border-red-400 bg-red-50 opacity-75': showAnswer && selectedAnswer ===
                                            {{ $jsonAnswer }} && !{{ $jsonIsCorrect }},
                                        'border-slate-200 bg-slate-50 opacity-50': showAnswer && selectedAnswer !==
                                            {{ $jsonAnswer }} && !{{ $jsonIsCorrect }}
                                    }">

                                    <div class="flex items-center gap-4">
                                        {{-- Letter Badge --}}
                                        <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-colors duration-200"
                                            :class="{
                                                'bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600':
                                                    !showAnswer && selectedAnswer !== {{ $jsonAnswer }},
                                                'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30': !
                                                    showAnswer && selectedAnswer === {{ $jsonAnswer }},
                                                'bg-green-500 text-white shadow-lg shadow-green-500/30': showAnswer &&
                                                    {{ $jsonIsCorrect }},
                                                'bg-red-500 text-white': showAnswer && selectedAnswer ===
                                                    {{ $jsonAnswer }} && !{{ $jsonIsCorrect }},
                                                'bg-slate-200 text-slate-400': showAnswer && selectedAnswer !==
                                                    {{ $jsonAnswer }} && !{{ $jsonIsCorrect }}
                                            }">
                                            {{ chr(65 + $index) }}
                                        </div>

                                        {{-- Answer Text --}}
                                        <div class="flex-1">
                                            <span class="text-lg font-medium transition-colors duration-200"
                                                :class="{
                                                    'text-slate-700': !showAnswer,
                                                    'text-indigo-900': !showAnswer && selectedAnswer ===
                                                        {{ $jsonAnswer }},
                                                    'text-green-800': showAnswer && {{ $jsonIsCorrect }},
                                                    'text-red-800 line-through decoration-red-400/50': showAnswer &&
                                                        selectedAnswer === {{ $jsonAnswer }} && !
                                                        {{ $jsonIsCorrect }},
                                                    'text-slate-400': showAnswer && selectedAnswer !==
                                                        {{ $jsonAnswer }} && !{{ $jsonIsCorrect }}
                                                }">
                                                {{ $answer }}
                                            </span>
                                        </div>

                                        {{-- Status Icon --}}
                                        <div x-show="showAnswer" x-transition.opacity>
                                            @if ($isCorrect)
                                                <div
                                                    class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                    <i data-lucide="check" class="w-5 h-5"></i>
                                                </div>
                                            @else
                                                <div x-show="selectedAnswer === {{ $jsonAnswer }}"
                                                    class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                                    <i data-lucide="x" class="w-5 h-5"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Action Buttons Area --}}
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        {{-- Before Submission --}}
                        <div x-show="!showAnswer"
                            class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                            {{-- Previous Button (Ghost Style) --}}
                            @if ($currentIndex > 0)
                                <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex - 1]) }}"
                                    class="order-2 sm:order-1 px-5 py-3 text-slate-500 font-medium hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                    Previous
                                </a>
                            @else
                                <div class="order-2 sm:order-1"></div>
                            @endif

                            {{-- Submit Answer Button (Primary) --}}
                            <button @click="checkAnswer()" :disabled="!selectedAnswer || isSubmitting"
                                class="order-1 sm:order-2 w-full sm:w-auto px-8 py-4 rounded-xl font-bold text-white shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer">
                                <span x-show="!isSubmitting">Submit Answer</span>
                                <span x-show="isSubmitting" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Submitting...
                                </span>
                                <i x-show="!isSubmitting" data-lucide="send" class="w-5 h-5"></i>
                            </button>
                        </div>

                        {{-- After Submission: Result Banner + Next --}}
                        <div x-show="showAnswer" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0" class="space-y-4">

                            {{-- Navigation Row --}}
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                                {{-- Previous --}}
                                @if ($currentIndex > 0)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex - 1]) }}"
                                        class="order-2 sm:order-1 px-5 py-3 text-slate-500 font-medium hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        Previous
                                    </a>
                                @else
                                    <div class="order-2 sm:order-1"></div>
                                @endif

                                {{-- Next/Finish Button --}}
                                @if ($currentIndex < $totalQuestions - 1)
                                    <a href="{{ route('user.interview-prep.practice', ['session' => $session, 'q' => $currentIndex + 1]) }}"
                                        class="order-1 sm:order-2 w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer">
                                        Next Question
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('user.interview-prep.end', ['session' => $session]) }}"
                                        class="order-1 sm:order-2 w-full sm:w-auto px-8 py-4 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-3 cursor-pointer">
                                        Finish Session
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Explanation (MCQ) - Moved below buttons for better flow --}}
                    <div x-show="showAnswer" x-collapse class="mt-6">
                        @if ($question->explanation)
                            <div
                                class="p-6 bg-slate-50 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-1 h-full bg-teal-500"></div>
                                <h4
                                    class="text-sm font-bold text-teal-700 mb-3 flex items-center gap-2 uppercase tracking-wide">
                                    <i data-lucide="lightbulb" class="w-4 h-4"></i>
                                    Explanation
                                </h4>
                                <div class="prose prose-sm max-w-none text-slate-700">
                                    {{ $question->explanation }}
                                </div>
                            </div>
                        @elseif($question->correct_answer)
                            <div class="p-6 bg-green-50 rounded-2xl border border-green-200 shadow-sm">
                                <h4 class="text-sm font-bold text-green-800 mb-3 uppercase tracking-wide">Correct Answer
                                </h4>
                                <ul class="list-disc list-inside text-sm text-slate-700 font-medium space-y-1">
                                    @foreach ($question->correct_answer as $ans)
                                        <li>{{ $ans }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Progress Dots (Optional, visual indicator) --}}
        <div class="flex justify-center gap-1.5 mb-8">
            @for ($i = 0; $i < $totalQuestions; $i++)
                <div
                    class="w-2 h-2 rounded-full {{ $i === $currentIndex ? 'bg-indigo-600 w-6' : ($i < $currentIndex ? 'bg-indigo-300' : 'bg-slate-200') }} transition-all duration-300">
                </div>
            @endfor
        </div>
    </div>
@endsection
