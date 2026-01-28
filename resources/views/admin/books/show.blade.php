@extends('admin.layout')

@section('title', $book->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.books.index') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-slate-900 transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Library
        </a>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-6">
                @if ($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                        class="w-32 h-44 object-cover rounded-xl shadow-lg border border-slate-200 flex-shrink-0">
                @else
                    <div class="w-20 h-20 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="book-open" class="w-10 h-10 text-indigo-600"></i>
                    </div>
                @endif

                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-2">{{ $book->title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-slate-500 mb-4">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            {{ $book->author ?? 'Unknown Author' }}
                        </div>
                        <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            {{ $book->total_pages }} Pages
                        </div>
                        <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="layers" class="w-4 h-4"></i>
                            {{ $book->chapters->count() }} Chapters/Parts
                        </div>
                    </div>
                    @if ($book->tags)
                        <div class="flex flex-wrap gap-2">
                            @foreach (explode(',', $book->tags) as $tag)
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                                    {{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.books.edit', $book) }}"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                    Edit
                </a>
                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold uppercase tracking-wider">
                    Status: {{ $book->status }}
                </span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($book->error_message)
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 flex items-center gap-3">
            <i data-lucide="alert-triangle" class="w-5 h-5 flex-shrink-0"></i>
            <div>
                <p class="font-bold">Error:</p>
                <p>{{ $book->error_message }}</p>
                <form action="{{ route('admin.books.retry', $book) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="text-xs px-3 py-1 bg-red-200 hover:bg-red-300 rounded-lg transition-colors">Retry
                        Processing</button>
                </form>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Controls & Text Preview --}}
        <div class="space-y-6">
            {{-- AI Processing Card --}}
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-lg p-6">
                <h3 class="font-bold text-slate-900 flex items-center gap-2 mb-4">
                    <i data-lucide="sparkles" class="w-5 h-5 text-indigo-600"></i>
                    AI Processing Options
                </h3>

                <form action="{{ route('admin.books.process', $book) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">AI
                            Provider</label>
                        <select name="provider_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}" {{ $provider->is_default ? 'selected' : '' }}>
                                    {{ $provider->name }} ({{ $provider->default_model }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Operation</label>
                        <div class="space-y-2">
                            <label
                                class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="process_type" value="full"
                                    class="text-indigo-600 focus:ring-indigo-500" checked>
                                <div>
                                    <span class="block font-bold text-slate-700 text-sm">Full Summary Only</span>
                                    <span class="block text-xs text-slate-400">Summarize the entire book</span>
                                </div>
                            </label>
                            <label
                                class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="process_type" value="chapter"
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="block font-bold text-slate-700 text-sm">Chapters Only</span>
                                    <span class="block text-xs text-slate-400">Process each chapter individually</span>
                                </div>
                            </label>
                            <label
                                class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer">
                                <input type="radio" name="process_type" value="both"
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <span class="block font-bold text-slate-700 text-sm">Full + Chapters</span>
                                    <span class="block text-xs text-slate-400">Comprehensive processing (Time
                                        intensive)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="translate" value="1"
                                class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" checked>
                            <span class="font-bold text-slate-700 text-sm">Translate to Bangla</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2"
                        {{ $book->status === 'processing' ? 'disabled' : '' }}>
                        @if ($book->status === 'processing')
                            <i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Processing...
                        @else
                            <i data-lucide="play" class="w-5 h-5"></i> Start Processing
                        @endif
                    </button>
                </form>
            </div>

            {{-- Text Preview (Chapters/Chunks) --}}
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-900">Detected Sections</h3>
                </div>
                <div class="max-h-[500px] overflow-y-auto p-2">
                    @foreach ($book->chapters as $chapter)
                        <div class="mb-2 last:mb-0" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 text-left transition-colors text-sm">
                                <span class="font-medium text-slate-700 truncate w-3/4">{{ $chapter->title }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open"
                                class="p-3 bg-slate-50 rounded-lg text-xs leading-relaxed text-slate-600 font-mono mt-1 whitespace-pre-wrap">
                                {{ Str::limit($chapter->content, 500) }}
                                @if (strlen($chapter->content) > 500)
                                    <span class="text-slate-400 italic">...content truncated for preview</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if ($book->chapters->count() === 0)
                        <div class="p-4 text-center text-slate-400 text-sm">No chapters detected yet. Upload processing
                            triggers automatically.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Results --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Full Summary Section --}}
            @if ($book->fullSummary)
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                        <h3 class="font-black text-slate-900 text-lg flex items-center gap-2">
                            <i data-lucide="book-open" class="w-5 h-5 text-indigo-600"></i> Full Book Summary
                        </h3>
                        <span class="text-xs text-slate-400 font-mono">Model:
                            {{ $book->fullSummary->provider->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                        <div class="p-6 prose prose-sm max-w-none text-slate-600">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">English</h4>
                            {!! nl2br(e($book->fullSummary->summary)) !!}
                        </div>
                        @if ($book->fullSummary->translation_bn)
                            <div class="p-6 prose prose-sm max-w-none text-slate-900 bg-indigo-50/30">
                                <h4 class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-4">Bangla</h4>
                                <div class="font-bengali leading-relaxed">
                                    {!! nl2br(e($book->fullSummary->translation_bn)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Chapter Summaries --}}
            <div class="space-y-4">
                <h3 class="font-bold text-slate-900 px-2 flex items-center gap-2">
                    <i data-lucide="list" class="w-5 h-5 text-indigo-600"></i> Chapter Summaries
                </h3>

                @forelse($book->chapters as $chapter)
                    @if ($chapter->summary)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                            x-data="{ expanded: false }">
                            <div class="p-4 flex items-center justify-between cursor-pointer hover:bg-slate-50 transition-colors"
                                @click="expanded = !expanded">
                                <h4 class="font-bold text-slate-800">{{ $chapter->title }}</h4>
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-xs text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">Summarized</span>
                                    <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform"
                                        :class="expanded ? 'rotate-180' : ''"></i>
                                </div>
                            </div>

                            <div x-show="expanded"
                                class="border-t border-slate-100 grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-100">
                                <div class="p-5 text-sm leading-relaxed text-slate-600">
                                    <h5 class="text-xs font-bold text-slate-400 uppercase mb-2">English</h5>
                                    {!! nl2br(e($chapter->summary->summary)) !!}
                                </div>
                                @if ($chapter->summary->translation_bn)
                                    <div class="p-5 text-sm leading-relaxed text-slate-900 bg-indigo-50/20 font-bengali">
                                        <h5 class="text-xs font-bold text-indigo-400 uppercase mb-2">Bangla</h5>
                                        {!! nl2br(e($chapter->summary->translation_bn)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div
                        class="p-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        No chapters available.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
