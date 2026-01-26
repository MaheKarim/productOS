@extends('user.layout')

@section('title', $video->title)
@section('header', 'Video Summary')

@section('content')
    {{-- Back Link --}}
    <a href="{{ route('user.yt-summarize.index') }}"
        class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600 mb-6 cursor-pointer transition-colors group">
        <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
        Back to Summaries
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content (2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Video Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                {{-- Thumbnail --}}
                <div class="relative aspect-video bg-slate-200">
                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                    <a href="{{ $video->youtube_url }}" target="_blank"
                        class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/40 transition-colors cursor-pointer group">
                        <div
                            class="w-20 h-20 rounded-full bg-red-600 flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-play text-white text-2xl ml-1"></i>
                        </div>
                    </a>
                    <div class="absolute bottom-3 right-3 px-3 py-1.5 bg-black/80 text-white font-mono text-sm rounded-lg">
                        {{ $video->duration }}
                    </div>
                    <div class="absolute top-3 left-3">
                        <span
                            class="px-3 py-1.5 text-sm font-bold rounded-lg {{ $video->access_level === 'premium' ? 'bg-gradient-to-r from-amber-400 to-orange-500 text-white' : 'bg-teal-500 text-white' }}">
                            {{ ucfirst($video->access_level) }}
                        </span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-slate-900 mb-3">{{ $video->title }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                        <span class="font-medium text-slate-700">{{ $video->channel_name }}</span>
                        <span>•</span>
                        <span>{{ number_format($video->view_count) }} views</span>
                        <span>•</span>
                        <span>{{ $video->upload_date->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            @if ($video->aiOutput)
                {{-- Executive Summary --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-file-lines text-blue-600"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900">Executive Summary</h2>
                    </div>
                    <p class="text-slate-700 leading-relaxed">{{ $video->aiOutput->summary_english }}</p>
                </div>

                {{-- Bangla Summary --}}
                @if ($video->aiOutput->summary_bangla)
                    <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-6 border-l-4 border-teal-500">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fa-solid fa-language text-teal-600"></i>
                            <h2 class="font-bold text-teal-900">Bangla Translation</h2>
                        </div>
                        <p class="text-teal-800 leading-relaxed font-bengali">{{ $video->aiOutput->summary_bangla }}</p>
                    </div>
                @endif

                {{-- Key Insights --}}
                @if ($video->aiOutput->key_insights)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                <i class="fa-solid fa-lightbulb text-amber-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">Key Insights</h2>
                        </div>
                        <ul class="space-y-3">
                            @foreach ($video->aiOutput->key_insights as $insight)
                                <li class="flex items-start gap-3 p-3 bg-slate-50 rounded-lg">
                                    <span
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm font-bold">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <p class="text-slate-800">{{ $insight['insight'] ?? $insight }}</p>
                                        @if (isset($insight['timestamp']))
                                            <span
                                                class="inline-block mt-1 px-2 py-0.5 bg-white text-slate-500 text-xs font-mono rounded border border-slate-200">
                                                {{ $insight['timestamp'] }}
                                            </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Skills + FAQ --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if ($video->aiOutput->actionable_skills)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
                            <div class="flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-graduation-cap text-violet-600"></i>
                                <h3 class="font-bold text-slate-900">Actionable Skills</h3>
                            </div>
                            <div class="space-y-2">
                                @foreach ($video->aiOutput->actionable_skills as $skill)
                                    <div class="p-3 bg-violet-50 rounded-lg border border-violet-100">
                                        <div class="font-semibold text-violet-900">{{ $skill['skill'] ?? 'Skill' }}</div>
                                        <div class="text-sm text-violet-700 mt-1">{{ $skill['context'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($video->aiOutput->faqs)
                        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5">
                            <div class="flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-circle-question text-blue-600"></i>
                                <h3 class="font-bold text-slate-900">FAQ</h3>
                            </div>
                            <div class="space-y-3">
                                @foreach ($video->aiOutput->faqs as $faq)
                                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                                        <div class="font-medium text-blue-900 text-sm">Q: {{ $faq['question'] ?? '' }}
                                        </div>
                                        <div class="text-blue-700 text-sm mt-1">A: {{ $faq['answer'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-amber-50 rounded-xl p-8 text-center border border-amber-200">
                    <i class="fa-solid fa-hourglass-half text-amber-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-amber-800 mb-2">AI Summary Processing</h3>
                    <p class="text-amber-700">This video's AI analysis is still being generated.</p>
                </div>
            @endif
        </div>

        {{-- Sidebar (1/3) --}}
        <div class="space-y-6">
            {{-- Why Watch --}}
            @if ($video->aiOutput && $video->aiOutput->read_reason)
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl p-5 text-white shadow-lg">
                    <h3 class="text-sm font-bold uppercase tracking-wider mb-2 opacity-80">Why Watch This?</h3>
                    <p class="font-medium leading-relaxed">{{ $video->aiOutput->read_reason }}</p>
                </div>
            @endif

            {{-- Watch on YouTube --}}
            <a href="{{ $video->youtube_url }}" target="_blank"
                class="flex items-center justify-center gap-3 w-full py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-md cursor-pointer">
                <i class="fa-brands fa-youtube text-xl"></i>
                Watch on YouTube
            </a>

            {{-- Share --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-900 mb-3">Share</h3>
                <button onclick="navigator.clipboard.writeText(window.location.href); this.innerText='Copied!'"
                    class="w-full py-2.5 px-4 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors cursor-pointer">
                    <i class="fa-solid fa-link mr-2"></i>
                    Copy Link
                </button>
            </div>
        </div>
    </div>

    {{-- Suggested Content --}}
    @if ($suggestedVideos->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-slate-900 mb-6">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($suggestedVideos as $suggested)
                    <a href="{{ route('user.yt-summarize.show', $suggested) }}"
                        class="group bg-white rounded-xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-200 transition-all cursor-pointer">
                        <div class="relative aspect-video bg-slate-100 overflow-hidden">
                            <img src="{{ $suggested->thumbnail_url }}" alt="{{ $suggested->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div
                                class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/80 text-white text-xs font-mono rounded">
                                {{ $suggested->duration }}
                            </div>
                            <div class="absolute top-2 left-2">
                                <span
                                    class="px-1.5 py-0.5 text-xs font-bold rounded {{ $suggested->access_level === 'premium' ? 'bg-amber-500 text-white' : 'bg-teal-500 text-white' }}">
                                    {{ ucfirst($suggested->access_level) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3
                                class="font-medium text-slate-900 line-clamp-2 text-sm group-hover:text-blue-600 transition-colors">
                                {{ $suggested->title }}
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $suggested->channel_name }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection
