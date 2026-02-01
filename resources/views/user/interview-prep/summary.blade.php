@extends('user.layout')

@section('title', 'Practice Complete')
@section('header', 'Session Complete')

@push('head')
    <style>
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100%) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(13, 148, 136, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(13, 148, 136, 0.6);
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes slide-up {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Custom Animations */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            top: -10px;
            animation: confetti-fall 3s ease-out forwards;
            z-index: 50;
        }

        .animate-bounce-in {
            animation: bounce-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        .animate-slide-up {
            animation: slide-up 0.5s ease-out forwards;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{
        showConfetti: true,
        animateStats: false,
        init() {
            this.createConfetti();
            setTimeout(() => this.animateStats = true, 500);
        },
        createConfetti() {
            const colors = ['#0D9488', '#2DD4BF', '#EA580C', '#FBBF24', '#8B5CF6', '#EC4899'];
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                    confetti.style.animationDuration = (2 + Math.random() * 2) + 's';
                    document.body.appendChild(confetti);
                    setTimeout(() => confetti.remove(), 4000);
                }, i * 50);
            }
        }
    }">
        {{-- Celebration Badge --}}
        <div class="text-center mb-8">
            <div class="inline-block animate-bounce-in">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-teal-400 to-teal-600 rounded-full blur-xl opacity-40 animate-pulse-glow">
                    </div>
                    <div
                        class="relative w-32 h-32 mx-auto bg-gradient-to-br from-amber-400 via-amber-500 to-orange-500 rounded-full flex items-center justify-center shadow-2xl shadow-amber-500/40 border-4 border-white">
                        <svg class="w-16 h-16 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Celebration Message --}}
        <div class="text-center mb-10 animate-slide-up opacity-0"
            style="animation-delay: 0.2s; animation-fill-mode: forwards;">
            <h1
                class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-teal-600 via-teal-500 to-emerald-500 bg-clip-text text-transparent mb-3">
                Session Completed!
            </h1>
            <p class="text-lg text-slate-600 max-w-md mx-auto">
                Great job investing in your career growth. Here's how you performed:
            </p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            {{-- Total Questions --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-lg shadow-slate-100/50 text-center animate-slide-up opacity-0"
                style="animation-delay: 0.3s; animation-fill-mode: forwards;">
                <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Total Questions</div>
                <div class="text-3xl font-black text-slate-800">{{ $interviewSession->total_questions }}</div>
            </div>

            {{-- Questions Attempted --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-lg shadow-slate-100/50 text-center animate-slide-up opacity-0"
                style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Attempted</div>
                <div class="text-3xl font-black text-blue-600">{{ $interviewSession->attempted_questions }}</div>
            </div>

            {{-- Correct Answers --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-lg shadow-slate-100/50 text-center animate-slide-up opacity-0"
                style="animation-delay: 0.5s; animation-fill-mode: forwards;">
                <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Correct</div>
                <div class="text-3xl font-black text-green-500">{{ $interviewSession->correct_answers }}</div>
            </div>

            {{-- Accuracy --}}
            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-lg shadow-slate-100/50 text-center animate-slide-up opacity-0"
                style="animation-delay: 0.6s; animation-fill-mode: forwards;">
                <div class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Accuracy</div>
                <div
                    class="text-3xl font-black {{ $interviewSession->score >= 80 ? 'text-emerald-500' : ($interviewSession->score >= 50 ? 'text-amber-500' : 'text-red-500') }}">
                    {{ number_format($interviewSession->score, 0) }}%
                </div>
            </div>
        </div>

        {{-- Duration & Quote --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 animate-slide-up opacity-0"
            style="animation-delay: 0.7s; animation-fill-mode: forwards;">
            <div
                class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-6 text-white flex items-center justify-between shadow-xl">
                <div>
                    <div class="text-slate-400 text-sm font-medium mb-1">Time Invested</div>
                    <div class="text-3xl font-mono font-bold tracking-tight">
                        {{ gmdate('i:s', $interviewSession->duration_seconds) }} <span
                            class="text-sm font-sans text-slate-500">min</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-slate-700/50 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div
                class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-3xl p-6 border border-teal-100 flex items-center justify-center text-center">
                <p class="text-slate-700 font-medium italic">
                    "Success is the sum of small efforts, repeated day in and day out."
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up opacity-0"
            style="animation-delay: 0.8s; animation-fill-mode: forwards;">
            <a href="{{ route('user.interview-prep.index') }}"
                class="w-full sm:w-auto px-8 py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-2xl shadow-xl shadow-teal-500/20 transition-all hover:scale-105 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                    </path>
                </svg>
                Practice More
            </a>
            <a href="{{ route('dashboard') }}"
                class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all hover:scale-105 flex items-center justify-center gap-2">
                Dashboard
            </a>
        </div>
    </div>
@endsection
