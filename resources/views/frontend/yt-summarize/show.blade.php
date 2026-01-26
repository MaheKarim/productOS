@extends('frontend.layout')

@section('title', $video->title . ' - YT Summarize')

@section('content')
    <section class="pt-32 pb-16 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute top-0 left-0 w-full h-96 overflow-hidden pointer-events-none">
            <div class="absolute -top-48 -left-48 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
            <div class="absolute -top-24 right-0 w-80 h-80 bg-blue-200/30 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Link --}}
            <a href="{{ route('yt-summarize.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-teal-600 mb-6 cursor-pointer transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Summaries
            </a>

            {{-- Video Header Card (Glassmorphism) --}}
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden mb-8 border border-white/50">
                {{-- Thumbnail with Play Button --}}
                <div class="relative aspect-video bg-slate-200">
                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                    <a href="{{ $video->youtube_url }}" target="_blank"
                        class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/40 transition-colors cursor-pointer group">
                        <div
                            class="w-24 h-24 rounded-full bg-red-600 flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-12 h-12 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </a>
                    <div
                        class="absolute bottom-4 right-4 px-4 py-2 bg-black/80 text-white font-mono rounded-xl backdrop-blur-sm">
                        {{ $video->duration }}
                    </div>
                    {{-- Access Badge --}}
                    <div class="absolute top-4 left-4">
                        <span
                            class="px-4 py-2 {{ $video->access_level === 'premium' ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gradient-to-r from-teal-400 to-teal-600' }} text-white text-sm font-bold rounded-xl shadow-lg uppercase tracking-wide">
                            {{ $video->access_level }}
                        </span>
                    </div>
                </div>

                {{-- Video Meta Info --}}
                <div class="p-8">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                        {{ $video->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-slate-500">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-slate-200 overflow-hidden">
                                @if ($video->channel_logo)
                                    <img src="{{ $video->channel_logo }}" alt="{{ $video->channel_name }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <span class="font-semibold text-slate-700">{{ $video->channel_name }}</span>
                        </div>
                        <span class="text-slate-300">|</span>
                        <span>{{ number_format($video->view_count) }} views</span>
                        <span class="text-slate-300">|</span>
                        <span>{{ $video->upload_date->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            @if ($video->aiOutput)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Main Content (2/3) --}}
                    <div class="lg:col-span-2 space-y-8">
                        {{-- Executive Summary --}}
                        <div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-100">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-900">Executive Summary</h2>
                            </div>
                            <p class="text-lg text-slate-700 leading-relaxed">{{ $video->aiOutput->summary_english }}
                            </p>
                        </div>

                        {{-- Bangla Summary --}}
                        @if ($video->aiOutput->summary_bangla)
                            <div
                                class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-2xl p-8 border-l-4 border-teal-500">
                                <h2 class="text-xl font-bold text-teal-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                        </path>
                                    </svg>
                                    Bangla Translation
                                </h2>
                                <p class="text-teal-800 leading-relaxed text-lg font-bengali">
                                    {{ $video->aiOutput->summary_bangla }}</p>
                            </div>
                        @endif

                        {{-- Key Insights --}}
                        @if ($video->aiOutput->key_insights)
                            <div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-100">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-slate-900">Key Insights</h2>
                                </div>
                                <ul class="space-y-4">
                                    @foreach ($video->aiOutput->key_insights as $insight)
                                        <li
                                            class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                                            <span
                                                class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center font-bold shadow-md">
                                                {{ $loop->iteration }}
                                            </span>
                                            <div>
                                                <p class="text-slate-800 font-medium">
                                                    {{ $insight['insight'] ?? $insight }}</p>
                                                @if (isset($insight['timestamp']))
                                                    <span
                                                        class="inline-block mt-2 px-3 py-1 bg-white text-slate-600 text-sm font-mono rounded-lg border border-slate-200">{{ $insight['timestamp'] }}</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Skills + FAQ Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Actionable Skills --}}
                            @if ($video->aiOutput->actionable_skills)
                                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Actionable Skills
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach ($video->aiOutput->actionable_skills as $skill)
                                            <div
                                                class="p-4 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border border-violet-100">
                                                <div class="font-semibold text-violet-900">
                                                    {{ $skill['skill'] ?? 'Skill' }}</div>
                                                <div class="text-sm text-violet-700 mt-1">{{ $skill['context'] ?? '' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- FAQ --}}
                            @if ($video->aiOutput->faqs)
                                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        FAQ
                                    </h3>
                                    <div class="space-y-4">
                                        @foreach ($video->aiOutput->faqs as $faq)
                                            <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                                                <div class="font-medium text-blue-900 text-sm">Q:
                                                    {{ $faq['question'] ?? '' }}</div>
                                                <div class="text-blue-700 text-sm mt-2">A: {{ $faq['answer'] ?? '' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Sidebar (1/3) --}}
                    <div class="space-y-6">
                        {{-- Why Watch --}}
                        @if ($video->aiOutput->read_reason)
                            <div
                                class="bg-gradient-to-br from-violet-500 via-purple-600 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
                                <h3 class="text-sm font-bold uppercase tracking-wider mb-3 opacity-80">Why Watch This?
                                </h3>
                                <p class="text-lg font-medium leading-relaxed">{{ $video->aiOutput->read_reason }}</p>
                            </div>
                        @endif

                        {{-- Premium Signup Banner (for guests) --}}
                        @guest
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200">
                                <div class="flex items-center gap-3 mb-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-amber-900">Unlock Premium</h3>
                                </div>
                                <p class="text-sm text-amber-800 mb-4">Get access to exclusive premium summaries with
                                    deeper insights and actionable frameworks.</p>
                                <a href="{{ route('register') }}"
                                    class="block w-full py-3 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-center font-bold rounded-xl hover:from-amber-500 hover:to-orange-600 transition-all duration-300 shadow-lg cursor-pointer">
                                    Sign Up Free
                                </a>
                                <a href="{{ route('login') }}"
                                    class="block w-full py-2 text-center text-amber-700 text-sm font-medium mt-2 hover:text-amber-900 cursor-pointer">
                                    Already have an account? Sign In
                                </a>
                            </div>
                        @endguest

                        {{-- Watch on YouTube --}}
                        <a href="{{ $video->youtube_url }}" target="_blank"
                            class="flex items-center justify-center gap-3 w-full py-4 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all duration-300 shadow-lg cursor-pointer">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                            Watch on YouTube
                        </a>

                        {{-- Share --}}
                        <div class="bg-white rounded-2xl p-6 shadow-lg border border-slate-100">
                            <h3 class="font-bold text-slate-900 mb-4">Share this summary</h3>
                            <div class="flex gap-3">
                                <button
                                    onclick="navigator.clipboard.writeText(window.location.href); this.innerText='Copied!'"
                                    class="flex-1 py-2 px-4 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors cursor-pointer">
                                    Copy Link
                                </button>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($video->title) }}"
                                    target="_blank"
                                    class="py-2 px-4 bg-sky-100 text-sky-700 rounded-lg hover:bg-sky-200 transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50 rounded-2xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-amber-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-amber-800 mb-2">AI Summary Not Available</h3>
                    <p class="text-amber-700">This video's AI analysis is still processing or hasn't been generated yet.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- Suggested Content Section --}}
    @php
        $suggestedVideos = \App\Models\Video::where('processing_status', 'completed')
            ->where('access_level', 'free')
            ->where('id', '!=', $video->id)
            ->with('aiOutput')
            ->inRandomOrder()
            ->take(4)
            ->get();
    @endphp

    @if ($suggestedVideos->count() > 0)
        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-8">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($suggestedVideos as $suggested)
                        <a href="{{ route('yt-summarize.show', $suggested) }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer border border-slate-100 hover:border-teal-200 hover:-translate-y-1">
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                <img src="{{ $suggested->thumbnail_url }}" alt="{{ $suggested->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div
                                    class="absolute bottom-2 right-2 px-2 py-1 bg-black/70 text-white text-xs font-mono rounded">
                                    {{ $suggested->duration }}
                                </div>
                            </div>
                            <div class="p-4">
                                <h3
                                    class="font-semibold text-slate-900 line-clamp-2 group-hover:text-teal-600 transition-colors text-sm">
                                    {{ $suggested->title }}
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">{{ $suggested->channel_name }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Premium Content Banner (for guests viewing free content) --}}
    @guest
        <section class="py-16 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
            </div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 mb-6">
                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z" />
                    </svg>
                    <span class="text-white/80 text-sm font-medium">Premium Content</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Want More Premium Summaries?</h2>
                <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">
                    Unlock exclusive in-depth analysis, actionable frameworks, and expert insights from our premium
                    collection.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-gradient-to-r from-teal-500 to-blue-600 text-white font-bold rounded-xl hover:from-teal-600 hover:to-blue-700 transition-all duration-300 shadow-xl hover:shadow-2xl cursor-pointer">
                        Create Free Account
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-8 py-4 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 border border-white/20 cursor-pointer">
                        Sign In
                    </a>
                </div>
            </div>
        </section>
    @endguest
@endsection
