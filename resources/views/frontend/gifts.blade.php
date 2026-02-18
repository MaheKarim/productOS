@extends('frontend.layout')

@section('title', 'Exclusive Gifts & Offers - ProductOS')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-orange-50 via-white to-purple-50 selection:bg-orange-200">

        {{-- Decorative Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-gradient-to-br from-orange-200/30 to-amber-200/20 rounded-full blur-3xl animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-gradient-to-tr from-purple-200/20 to-pink-200/20 rounded-full blur-3xl animate-float">
            </div>
            <div
                class="absolute top-1/3 right-1/4 w-[300px] h-[300px] bg-gradient-to-br from-blue-200/10 to-cyan-200/10 rounded-full blur-3xl animate-float-delayed">
            </div>
        </div>

        {{-- Hero Section --}}
        <div class="relative pt-36 pb-16 px-6">
            <div class="max-w-6xl mx-auto text-center">
                {{-- Badge --}}
                <div
                    class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-orange-100 to-amber-100 border-2 border-orange-200 text-orange-700 text-xs font-bold uppercase tracking-wider mb-8">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                        </path>
                    </svg>
                    <span>Exclusive Deals & Offers</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 tracking-tight leading-tight">
                    Unlock Premium<br />
                    <span
                        class="bg-gradient-to-r from-orange-600 via-amber-500 to-yellow-500 bg-clip-text text-transparent">Gifts
                        & Offers</span>
                </h1>

                {{-- Subheading --}}
                <p class="text-xl md:text-2xl text-slate-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Handpicked deals, exclusive discounts, and special offers from our trusted partners. Save big on tools
                    and services you love.
                </p>

                {{-- Stats --}}
                <div
                    class="inline-flex items-center gap-8 md:gap-12 px-8 py-4 bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl shadow-sm mb-4">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-black text-orange-600">{{ $gifts->count() }}</div>
                        <div class="text-xs md:text-sm text-slate-500 font-medium">Active Deals</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-black text-purple-600">Up to 90%</div>
                        <div class="text-xs md:text-sm text-slate-500 font-medium">Savings</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-black text-blue-600">Free</div>
                        <div class="text-xs md:text-sm text-slate-500 font-medium">Access</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gifts Grid Section --}}
        <div class="relative pb-24 px-6">
            <div class="max-w-7xl mx-auto">
                @if ($gifts->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($gifts as $index => $gift)
                            <a href="{{ $gift->link }}" target="_blank" rel="noopener noreferrer"
                                class="group relative bg-white border-2 border-slate-200/80 rounded-3xl overflow-hidden hover:border-orange-300 hover:shadow-2xl hover:shadow-orange-100/50 transition-all duration-300 cursor-pointer hover:-translate-y-2"
                                id="gift-card-{{ $gift->id }}">

                                {{-- Offer Badge --}}
                                <div class="absolute top-4 right-4 z-10">
                                    <div
                                        class="px-3 py-1.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-black rounded-full shadow-lg shadow-orange-500/30 uppercase tracking-wider">
                                        {{ $gift->offer_percentage }}
                                    </div>
                                </div>

                                {{-- Card Content --}}
                                <div class="p-6 pb-5">
                                    {{-- Logo Section --}}
                                    <div class="flex items-center gap-4 mb-5">
                                        <div
                                            class="w-14 h-14 rounded-2xl overflow-hidden flex-shrink-0 border-2 border-slate-100 group-hover:border-orange-200 transition-colors duration-300 bg-slate-50 flex items-center justify-center">
                                            @if ($gift->logo)
                                                <img src="{{ asset('storage/' . $gift->logo) }}"
                                                    alt="{{ $gift->website_name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center">
                                                    <span class="text-xl font-black text-orange-600">
                                                        {{ strtoupper(substr($gift->website_name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors duration-200 truncate">
                                                {{ $gift->website_name }}
                                            </h3>
                                            <p class="text-xs text-slate-400 font-medium">Partner Deal</p>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-sm text-slate-600 leading-relaxed mb-5 line-clamp-3">
                                        {{ $gift->short_description }}
                                    </p>

                                    {{-- CTA --}}
                                    <div
                                        class="flex items-center justify-between pt-4 border-t border-slate-100 group-hover:border-orange-100 transition-colors duration-300">
                                        <span
                                            class="text-sm font-bold text-orange-600 group-hover:text-orange-700 transition-colors duration-200">
                                            Grab This Deal
                                        </span>
                                        <div
                                            class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center group-hover:bg-orange-500 transition-all duration-300">
                                            <svg class="w-4 h-4 text-orange-600 group-hover:text-white transition-colors duration-300 group-hover:translate-x-0.5"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-24">
                        <div
                            class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-orange-100 to-amber-100 rounded-3xl flex items-center justify-center">
                            <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">No Offers Available Right Now</h3>
                        <p class="text-lg text-slate-500 max-w-md mx-auto">We're working on bringing you amazing deals.
                            Check back soon for exclusive offers!</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- How It Works Section --}}
        @if ($gifts->count() > 0)
            <div class="relative py-24 px-6">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
                <div class="relative max-w-6xl mx-auto">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-black text-white mb-4">How It Works</h2>
                        <p class="text-xl text-slate-400">Claiming your exclusive deals is simple</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <div
                            class="relative bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div class="text-sm font-bold text-orange-400 uppercase tracking-wider mb-2">Step 1</div>
                            <h3 class="text-2xl font-bold text-white mb-3">Browse Deals</h3>
                            <p class="text-slate-400 leading-relaxed">Explore our curated collection of exclusive offers
                                from trusted partner websites.</p>
                        </div>

                        <div
                            class="relative bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-sm font-bold text-purple-400 uppercase tracking-wider mb-2">Step 2</div>
                            <h3 class="text-2xl font-bold text-white mb-3">Click & Claim</h3>
                            <p class="text-slate-400 leading-relaxed">Click on any deal card to be redirected to the
                                partner's website with your exclusive offer.</p>
                        </div>

                        <div
                            class="relative bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/20">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-sm font-bold text-emerald-400 uppercase tracking-wider mb-2">Step 3</div>
                            <h3 class="text-2xl font-bold text-white mb-3">Save Big</h3>
                            <p class="text-slate-400 leading-relaxed">Enjoy exclusive discounts and savings on premium
                                tools, courses, and services.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (prefers-reduced-motion: reduce) {

            .animate-pulse-slow,
            .animate-float,
            .animate-float-delayed {
                animation: none;
            }

            .group:hover {
                transform: none !important;
            }
        }
    </style>
@endsection
