@extends('frontend.layout')

@section('title', $title . ' - Directory')

@section('content')
    <div class="relative min-h-screen bg-[#030712] text-white selection:bg-indigo-500/30 overflow-hidden">
        {{-- Futuristic Background Mesh --}}
        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-0 right-0 w-[60%] h-[60%] bg-indigo-900/10 rounded-full blur-[120px] animate-pulse-slow">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[40%] h-[40%] bg-blue-900/10 rounded-full blur-[120px] animate-pulse-slow delay-2000">
            </div>
            {{-- Grid Pattern Overlay --}}
            <div
                class="absolute inset-0 opacity-[0.02] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:60px_60px]">
            </div>
        </div>

        {{-- Header Section --}}
        <div class="relative z-10 pt-40 pb-16 border-b border-white/5 bg-white/[0.02] backdrop-blur-sm">
            <div class="max-w-[1400px] mx-auto px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-12">
                    <div class="flex-1 animate-fade-in-up">
                        <nav
                            class="flex items-center space-x-3 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 mb-6">
                            <a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Core</a>
                            <i class="fa-solid fa-chevron-right text-[8px] text-white/10"></i>
                            <a href="{{ route('directory.index') }}"
                                class="hover:text-indigo-400 transition-colors">Directory</a>
                            <i class="fa-solid fa-chevron-right text-[8px] text-white/10"></i>
                            <span class="text-indigo-400 shadow-[0_0_10px_rgba(129,140,248,0.3)]">{{ $title }}</span>
                        </nav>

                        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-none mb-6">
                            {{ $title }} <br />
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 opacity-80 uppercase text-[0.4em] font-black tracking-[0.5em]">Entity
                                Registry</span>
                        </h1>

                        <p class="text-lg text-slate-400 font-light max-w-2xl leading-relaxed">
                            A specialized matrix of verified tools and intelligence units curated for the <span
                                class="text-white font-medium italic underline decoration-indigo-500/50 underline-offset-4">{{ strtolower($title) }}</span>
                            sector.
                        </p>
                    </div>

                    <div class="animate-fade-in-up delay-100">
                        <a href="{{ route('directory.index') }}"
                            class="group inline-flex items-center px-8 py-4 bg-white/[0.03] border border-white/10 rounded-2xl text-slate-400 text-xs font-black uppercase tracking-[0.2em] hover:bg-white/[0.07] hover:border-indigo-500/30 hover:text-white transition-all duration-300 backdrop-blur-md">
                            <i class="fa-solid fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform"></i>
                            Return to Index
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Interaction Matrix --}}
        <div class="relative z-10 max-w-[1400px] mx-auto px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                {{-- Side Panel: Filters --}}
                <div class="lg:col-span-3 sticky top-32 animate-fade-in-up delay-200">
                    <div class="relative group">
                        {{-- Neo Glow Border --}}
                        <div
                            class="absolute -inset-0.5 bg-gradient-to-b from-indigo-500/20 to-transparent rounded-[2.5rem] blur opacity-0 group-hover:opacity-100 transition duration-700">
                        </div>

                        <div
                            class="relative bg-white/[0.03] backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-8 shadow-2xl">
                            <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/5">
                                <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em]">Query Filters
                                </h4>
                                <div class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                            </div>

                            <div class="space-y-2 futuristic-filters">
                                <livewire:directory.directory-filters :type="$type" />
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Stat Box --}}
                    <div
                        class="mt-8 bg-gradient-to-br from-indigo-600/10 to-transparent border border-white/5 rounded-[2rem] p-6 backdrop-blur-xl group hover:border-indigo-500/20 transition-all duration-500">
                        <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">Total Capacity
                        </div>
                        <div class="text-3xl font-black text-white group-hover:text-indigo-400 transition-colors">128+ <span
                                class="text-sm font-light text-slate-500 uppercase">Tools</span></div>
                    </div>
                </div>

                {{-- Main Viewport: Intelligence Listings --}}
                <div class="lg:col-span-9 animate-fade-in-up delay-300">
                    <livewire:directory.directory-list :type="$type" />
                </div>
            </div>
        </div>

        {{-- Background Tech Text --}}
        <div class="fixed bottom-10 right-10 z-0 pointer-events-none opacity-[0.05] select-none text-[8vw] font-black text-white uppercase tracking-tighter leading-none whitespace-nowrap orientation-vertical"
            style="writing-mode: vertical-rl;">
            {{ $title }} // ENTITY_DATA
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.1;
                transform: scale(1);
            }

            50% {
                opacity: 0.2;
                transform: scale(1.1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        /* Nav Override */
        nav {
            background: rgba(3, 7, 18, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            backdrop-blur: 20px !important;
        }

        nav a.text-slate-600 {
            color: #94a3b8 !important;
        }

        nav a.text-slate-600:hover,
        nav a.text-blue-600 {
            color: white !important;
        }

        nav .text-slate-900 {
            color: white !important;
        }

        /* Icon Gradients */
        .fa-solid,
        .fa-brands,
        .fa-regular {
            background: linear-gradient(135deg, #a5b4fc 0%, #6366f1 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        /* Fix for Livewire styles in dark mode if needed */
        .futuristic-filters select,
        .futuristic-filters input {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 1rem !important;
        }
    </style>
@endpush
