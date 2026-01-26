@extends('frontend.layout')

@section('title', 'YT Summarize - Free Video Summaries')

@section('content')
    {{-- Enhanced Hero Section with Glassmorphism --}}
    <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden pt-24 pb-16">
        {{-- Animated Background --}}
        <div class="absolute inset-0 gradient-mesh">
            <div class="absolute top-20 left-10 w-72 h-72 bg-teal-400/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl animate-float-delayed">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-violet-300/20 rounded-full blur-3xl animate-pulse-slow">
            </div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Badge --}}
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-white/40 shadow-lg mb-6 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-sm font-medium text-slate-700">AI-Powered Summaries</span>
            </div>

            {{-- Main Title --}}
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 leading-tight animate-fade-in-up"
                style="animation-delay: 100ms;">
                Learn <span
                    class="bg-gradient-to-r from-teal-500 via-blue-500 to-violet-500 bg-clip-text text-transparent">Faster</span>
                with
                <br class="hidden md:block">
                YouTube Summaries
            </h1>

            {{-- Subtitle --}}
            <p class="text-xl md:text-2xl text-slate-600 mb-10 max-w-3xl mx-auto animate-fade-in-up"
                style="animation-delay: 200ms;">
                Get the key insights from any YouTube video in seconds. No fluff, just actionable knowledge.
            </p>

            {{-- Search Bar (Glassmorphism) --}}
            <form action="{{ route('yt-summarize.index') }}" method="GET" class="max-w-2xl mx-auto animate-fade-in-up"
                style="animation-delay: 300ms;">
                <div class="relative group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-teal-500 via-blue-500 to-violet-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity duration-300">
                    </div>
                    <div
                        class="relative flex items-center bg-white/80 backdrop-blur-xl rounded-2xl border border-white/50 shadow-2xl overflow-hidden">
                        <svg class="absolute left-5 w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search video summaries..."
                            class="w-full px-6 py-5 pl-14 text-lg bg-transparent outline-none text-slate-800 placeholder-slate-400">
                        <button type="submit"
                            class="absolute right-3 px-6 py-3 bg-gradient-to-r from-teal-500 to-blue-600 text-white font-bold rounded-xl hover:from-teal-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl cursor-pointer">
                            Search
                        </button>
                    </div>
                </div>
            </form>

            {{-- Stats Row --}}
            <div class="flex flex-wrap items-center justify-center gap-8 mt-12 animate-fade-in-up"
                style="animation-delay: 400ms;">
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900">
                        {{ \App\Models\Video::where('processing_status', 'completed')->count() }}+</div>
                    <div class="text-sm text-slate-500">Summaries</div>
                </div>
                <div class="w-px h-10 bg-slate-300"></div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900">5min</div>
                    <div class="text-sm text-slate-500">Avg. Read Time</div>
                </div>
                <div class="w-px h-10 bg-slate-300"></div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-900">Free</div>
                    <div class="text-sm text-slate-500">Public Access</div>
                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3">
                </path>
            </svg>
        </div>
    </section>

    {{-- Premium Login Banner (for guests) --}}
    @guest
        <div class="relative overflow-hidden mb-5">
            <div class="absolute inset-0 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 opacity-95"></div>
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzBoLTJ2LTJoMnYyem0wLTRoLTJ2LTJoMnYyem0tNC00aC0ydi0yaDJ2MnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-30">
            </div>
            <div class="relative py-4 px-4">
                <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-4 text-white">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">Unlock premium summaries with exclusive insights</span>
                    <a href="{{ route('login') }}"
                        class="px-5 py-2 bg-white text-violet-600 text-sm font-bold rounded-lg hover:bg-violet-50 transition-all duration-200 shadow-lg cursor-pointer">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 bg-white/20 text-white text-sm font-bold rounded-lg hover:bg-white/30 transition-all duration-200 border border-white/30 cursor-pointer">
                        Create Account
                    </a>
                </div>
            </div>
        </div>
    @endguest

    {{-- Flash Message --}}
    @if (session('premium_required'))
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <span class="text-amber-700 text-sm font-medium">{{ session('premium_required') }}</span>
            </div>
        </div>
    @endif

    {{-- Video Grid with enhanced cards --}}
    <section class="py-20 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Free Video Summaries</h2>
                    <p class="text-slate-500 mt-1">Curated knowledge from top YouTube creators</p>
                </div>
                <span
                    class="px-4 py-2 bg-white rounded-full text-sm font-medium text-slate-600 shadow-sm border border-slate-200">
                    {{ $videos->total() }} summaries
                </span>
            </div>

            @if ($videos->isEmpty())
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-600 mb-2">No summaries found</h3>
                    <p class="text-slate-500">Try a different search term or check back later.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($videos as $video)
                        <a href="{{ route('yt-summarize.show', $video) }}"
                            class="group relative bg-white/80 backdrop-blur-sm rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer border border-slate-100/50 hover:border-teal-200 hover:-translate-y-1">

                            {{-- Thumbnail with overlay --}}
                            <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute bottom-3 right-3 px-2.5 py-1 bg-black/80 text-white text-xs font-mono rounded-lg backdrop-blur-sm">
                                    {{ $video->duration }}
                                </div>
                                {{-- Play icon on hover --}}
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div
                                        class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center shadow-xl">
                                        <svg class="w-6 h-6 text-teal-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5">
                                <h3
                                    class="font-bold text-slate-900 line-clamp-2 group-hover:text-teal-600 transition-colors duration-200 mb-2">
                                    {{ $video->title }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-slate-500 mb-3">
                                    <span class="truncate">{{ $video->channel_name }}</span>
                                    <span>•</span>
                                    <span class="flex-shrink-0">{{ number_format($video->view_count) }} views</span>
                                </div>

                                {{-- AI Summary Preview --}}
                                @if ($video->aiOutput && $video->aiOutput->summary_english)
                                    <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                                        {{ Str::limit($video->aiOutput->summary_english, 100) }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-3 py-1 bg-gradient-to-r from-teal-50 to-teal-100 text-teal-700 text-xs font-semibold rounded-full border border-teal-200">Free</span>
                                    @if ($video->aiOutput)
                                        <span
                                            class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full border border-blue-200">AI
                                            Summary</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section for Premium --}}
    @guest
        <section class="py-20 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
            </div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Unlock Premium Summaries</h2>
                <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">
                    Get access to exclusive in-depth analysis, actionable frameworks, and expert insights from premium
                    content creators.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-8 py-4 bg-gradient-to-r from-teal-500 to-blue-600 text-white font-bold rounded-xl hover:from-teal-600 hover:to-blue-700 transition-all duration-300 shadow-xl hover:shadow-2xl cursor-pointer">
                        Get Started Free
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
