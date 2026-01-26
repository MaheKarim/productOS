@extends('user.layout')

@section('title', 'YT Summarizer')
@section('header', 'YT Summarizer')

@section('content')
    {{-- Hero Search Section --}}
    <div class="relative mb-8 rounded-2xl overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700"></div>
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzBoLTJ2LTJoMnYyem0wLTRoLTJ2LTJoMnYyem0tNC00aC0ydi0yaDJ2MnoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-30">
        </div>

        {{-- Content --}}
        <div class="relative px-8 py-12 text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-4">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                AI-Powered Summaries
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">
                YouTube Summarizer
            </h2>
            <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto">
                Get AI-powered insights from any YouTube video. Save hours of watching time.
            </p>

            {{-- Search Bar --}}
            <form action="{{ route('user.yt-summarize.index') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-2xl blur-xl"></div>
                    <div class="relative flex items-center bg-white rounded-xl shadow-2xl overflow-hidden">
                        <svg class="absolute left-4 w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search video summaries..."
                            class="w-full px-12 py-4 text-slate-800 placeholder-slate-400 outline-none">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <button type="submit"
                            class="absolute right-2 px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg cursor-pointer">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Summaries</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fa-solid fa-video text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Free Content</p>
                    <p class="text-2xl font-bold text-teal-600">{{ $stats['free'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 flex items-center justify-center">
                    <i class="fa-solid fa-unlock text-teal-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Premium Content</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $stats['premium'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                    <i class="fa-solid fa-crown text-amber-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 mb-6 bg-white rounded-xl p-2 shadow-sm border border-slate-100 w-fit">
        <a href="{{ route('user.yt-summarize.index', ['search' => request('search')]) }}"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer {{ $filter === 'all' ? 'bg-blue-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100' }}">
            All
        </a>
        <a href="{{ route('user.yt-summarize.index', ['search' => request('search'), 'filter' => 'free']) }}"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer {{ $filter === 'free' ? 'bg-teal-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100' }}">
            Free
        </a>
        <a href="{{ route('user.yt-summarize.index', ['search' => request('search'), 'filter' => 'premium']) }}"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer {{ $filter === 'premium' ? 'bg-amber-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100' }}">
            Premium
        </a>
    </div>

    {{-- Video Grid --}}
    @if ($videos->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-100">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                <i class="fa-solid fa-video-slash text-slate-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-700 mb-2">No summaries found</h3>
            <p class="text-slate-500">Try adjusting your search or filter criteria.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($videos as $video)
                <a href="{{ route('user.yt-summarize.show', $video) }}"
                    class="group bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer">

                    {{-- Thumbnail --}}
                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute bottom-2 right-2 px-2 py-1 bg-black/80 text-white text-xs font-mono rounded">
                            {{ $video->duration }}
                        </div>
                        {{-- Access Badge --}}
                        <div class="absolute top-2 left-2">
                            <span
                                class="px-2 py-1 text-xs font-bold rounded {{ $video->access_level === 'premium' ? 'bg-gradient-to-r from-amber-400 to-orange-500 text-white' : 'bg-teal-500 text-white' }}">
                                {{ ucfirst($video->access_level) }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3
                            class="font-semibold text-slate-900 line-clamp-2 group-hover:text-blue-600 transition-colors mb-2">
                            {{ $video->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <span class="truncate">{{ $video->channel_name }}</span>
                            <span>•</span>
                            <span class="flex-shrink-0">{{ number_format($video->view_count) }} views</span>
                        </div>

                        @if ($video->aiOutput && $video->aiOutput->summary_english)
                            <p class="text-sm text-slate-600 line-clamp-2 mt-3">
                                {{ Str::limit($video->aiOutput->summary_english, 80) }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $videos->appends(request()->query())->links() }}
        </div>
    @endif
@endsection
