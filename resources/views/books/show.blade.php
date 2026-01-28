<x-layout.app>
    <x-slot:title>{{ $book->title }} - ProductOS</x-slot:title>

    <div class="min-h-screen bg-slate-50 relative">
        <!-- DARK HEADER BACKGROUND -->
        <div class="absolute top-0 left-0 right-0 h-[400px] bg-slate-900 overflow-hidden z-0">
            <!-- Ambient Background Orbs -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[80px]"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[80px]">
                </div>
            </div>
            <!-- Grid Pattern Overlay -->
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px] pointer-events-none">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-28 relative z-10">
            <!-- Breadcrumbs (Light text on Dark BG) -->
            <nav class="flex items-center gap-2 text-sm text-blue-200/60 mb-8 font-medium">
                <a href="{{ route('books.index') }}" class="hover:text-white transition-colors">Library</a>
                <i data-lucide="chevron-right" class="w-4 h-4 text-blue-200/30"></i>
                <span class="text-white">{{ $book->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Left Sidebar: Cover & Actions -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- 3D Cover Container -->
                    <div class="relative group perspective-1000">
                        <div
                            class="relative w-[320px] aspect-[2/3] mx-auto transform transition-transform duration-500 group-hover:rotate-y-6">
                            @if ($book->cover_image)
                                <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover rounded-2xl shadow-2xl shadow-slate-900/40 border-4 border-white/10">
                            @else
                                <div
                                    class="w-full h-full bg-slate-800 rounded-2xl border border-white/10 flex items-center justify-center text-slate-500">
                                    <i data-lucide="book" class="w-16 h-16"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions Card (Floating on overlap) -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-slate-100">
                        <button
                            class="w-full py-4 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white rounded-xl font-bold text-lg shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 mb-6 flex items-center justify-center gap-2">
                            <i data-lucide="book-open-check" class="w-5 h-5"></i>
                            Start Reading
                        </button>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="text-2xl font-bold text-slate-900">{{ ceil($book->total_pages * 1.5) }}m
                                </div>
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-1">Read Time
                                </div>
                            </div>
                            <div class="text-center p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="text-2xl font-bold text-slate-900">{{ $book->total_pages }}</div>
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mt-1">Pages</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Summary -->
                <div class="lg:col-span-8">
                    <!-- Title Header (On Dark) -->
                    <div class="mb-12">
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="px-3 py-1 bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded-full text-[10px] font-bold uppercase tracking-widest backdrop-blur-sm">
                                Editorial Summary
                            </span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-black text-white tracking-tight mb-2 leading-tight">
                            {{ $book->title }}
                        </h1>
                        <p class="text-xl text-blue-100/80 font-medium mb-4">By {{ $book->author }}</p>

                        @if ($book->tags)
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach (explode(',', $book->tags) as $tag)
                                    <span
                                        class="px-3 py-1 bg-white/10 backdrop-blur-sm text-blue-100 border border-white/10 rounded-full text-xs font-medium">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- White Content Card -->
                    <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-slate-200">
                        <!-- Full Summary content -->
                        @if ($book->fullSummary)
                            <div class="mb-12">
                                <h3
                                    class="text-sm font-bold uppercase tracking-widest text-slate-500 mb-6 flex items-center gap-3">
                                    <i data-lucide="book-open" class="w-4 h-4 text-blue-600"></i>
                                    Full Summary
                                </h3>
                                @if ($book->fullSummary->translation_bn)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div
                                            class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-a:text-blue-600 hover:prose-a:text-blue-500">
                                            {!! nl2br(e($book->fullSummary->summary)) !!}
                                        </div>
                                        <div
                                            class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-a:text-indigo-600 hover:prose-a:text-indigo-500 bg-indigo-50/30 rounded-2xl p-6">
                                            <h4
                                                class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-4">
                                                Bangla Translation</h4>
                                            <div class="font-bengali leading-relaxed">
                                                {!! nl2br(e($book->fullSummary->translation_bn)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-a:text-blue-600 hover:prose-a:text-blue-500">
                                        {!! nl2br(e($book->fullSummary->summary)) !!}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Chapter Summaries -->
                        @if ($book->chapters->count() > 0 && $book->chapters->whereNotNull('summary')->count() > 0)
                            <div class="mt-16 pt-10 border-t border-slate-100">
                                <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i data-lucide="list-tree" class="w-6 h-6 text-slate-400"></i>
                                    Chapter Summaries
                                </h3>
                                <div class="space-y-6">
                                    @foreach ($book->chapters as $chapter)
                                        @if ($chapter->summary)
                                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                                <div class="flex items-center gap-3 mb-4">
                                                    <span
                                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">
                                                        Chapter {{ $loop->iteration }}
                                                    </span>
                                                    <h4 class="text-lg font-bold text-slate-900">{{ $chapter->title }}
                                                    </h4>
                                                </div>
                                                @if ($chapter->summary->translation_bn)
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div
                                                            class="prose prose-slate max-w-none prose-headings:font-semibold">
                                                            {!! nl2br(e($chapter->summary->summary)) !!}
                                                        </div>
                                                        <div
                                                            class="prose prose-slate max-w-none prose-headings:font-semibold bg-indigo-50/30 rounded-2xl p-6">
                                                            <h5
                                                                class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-4">
                                                                Bangla Translation</h5>
                                                            <div class="font-bengali leading-relaxed">
                                                                {!! nl2br(e($chapter->summary->translation_bn)) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="prose prose-slate max-w-none prose-headings:font-semibold">
                                                        {!! nl2br(e($chapter->summary->summary)) !!}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- No content message -->
                        @if (!$book->fullSummary && $book->chapters->whereNotNull('summary')->count() === 0)
                            <div class="text-center py-16">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                    <i data-lucide="loader-2" class="w-8 h-8 animate-spin"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Content Coming Soon</h3>
                                <p class="text-slate-500 max-w-md mx-auto">The AI summary for this book is currently
                                    being processed. Please check back later.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Suggested Books Section -->
            @if (isset($recommendations) && $recommendations->count() > 0)
                <div class="mt-24 pt-12 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="sparkles" class="w-6 h-6 text-blue-500"></i>
                            You might also like
                        </h2>
                        <a href="{{ route('books.index') }}"
                            class="text-sm font-semibold text-blue-600 hover:text-blue-500 flex items-center gap-1 transition-colors">
                            View all books <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($recommendations as $recBook)
                            <a href="{{ route('books.show', $recBook->slug ?? $recBook->id) }}"
                                class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                                <!-- Cover Image -->
                                <div class="relative h-[280px] overflow-hidden bg-slate-100">
                                    @if ($recBook->cover_image)
                                        <img src="{{ Storage::url($recBook->cover_image) }}"
                                            alt="{{ $recBook->title }}"
                                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                            <i data-lucide="image" class="w-10 h-10 mb-2"></i>
                                        </div>
                                    @endif
                                    <!-- Overlay Gradient -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3
                                        class="text-base font-bold text-slate-900 leading-tight mb-1 group-hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $recBook->title }}
                                    </h3>
                                    <p class="text-xs text-slate-500 mb-3 line-clamp-1 font-medium">
                                        {{ $recBook->author }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-layout.app>
