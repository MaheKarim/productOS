<x-layout.app>
    <x-slot:title>Library - ProductOS</x-slot:title>

    <div class="min-h-screen bg-slate-50 relative">

        <!-- DARK HERO SECTION -->
        <div class="relative bg-slate-900 pt-28 pb-32 overflow-hidden">
            <!-- Ambient Background Orbs -->
            <div class="absolute inset-0 pointer-events-none z-0">
                <div
                    class="absolute top-0 left-1/4 w-[800px] h-[800px] bg-blue-600/20 rounded-full blur-[100px] animate-pulse">
                </div>
                <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[100px] animate-pulse"
                    style="animation-delay: 2s;"></div>
            </div>

            <!-- Grid Pattern Overlay -->
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px] pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 text-blue-200 rounded-full text-sm font-semibold mb-6 backdrop-blur-md">
                    <i data-lucide="sparkles" class="w-4 h-4 text-blue-400"></i>
                    <span>Curated Knowledge Base</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                    Unlock <span
                        class="bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400 bg-clip-text text-transparent">Product
                        Wisdom</span>
                </h1>
                <p class="text-lg text-blue-100/70 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                    Access expert summaries, actionable frameworks, and key insights from the world's best product
                    management books.
                </p>

                <!-- Search Bar (In Dark Context) -->
                <div class="max-w-2xl mx-auto relative group z-20">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500">
                    </div>
                    <form action="{{ route('books.index') }}" method="GET" class="relative">
                        <div
                            class="flex items-center bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-2 transition-transform group-hover:-translate-y-0.5">
                            <i data-lucide="search" class="w-6 h-6 text-blue-300 ml-4"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, author, or tags..."
                                class="w-full ml-4 bg-transparent border-none p-2 text-lg text-white placeholder:text-blue-200/50 focus:ring-0">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold transition-colors shadow-lg shadow-blue-600/20">
                                Search
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Floating Dynamic Elements -->
                <div class="absolute top-20 left-[15%] hidden lg:block animate-bounce" style="animation-duration: 3s;">
                    <div
                        class="p-3 bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl -rotate-12 hover:rotate-0 transition-transform cursor-default">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-lg shadow-pink-500/20">
                            <i data-lucide="target" class="w-5 h-5 text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-20 right-[15%] hidden lg:block animate-bounce"
                    style="animation-duration: 4s; animation-delay: 1s;">
                    <div
                        class="p-3 bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl rotate-12 hover:rotate-0 transition-transform cursor-default">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="absolute top-40 right-[20%] hidden lg:block animate-pulse" style="animation-duration: 3s;">
                    <div
                        class="p-3 bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl rotate-6 hover:rotate-0 transition-transform cursor-default">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave Separator -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-full text-slate-50 fill-current">
                    <path d="M0 48H1440V0C1440 0 1140 48 720 48C300 48 0 0 0 0V48Z" />
                </svg>
            </div>
        </div>

        <!-- LIGHT LIST SECTION -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 -mt-12 relative z-20">
            <!-- Stats/Filter Row -->
            <div
                class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 p-6 mb-12 flex flex-col md:flex-row items-center justify-between border border-slate-100">
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <div class="flex -space-x-3">
                        @foreach ($books->take(3) as $book)
                            @if ($book->cover_image)
                                <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                                    src="{{ Storage::url($book->cover_image) }}" alt="">
                            @else
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-xs text-slate-500">
                                    ?</div>
                            @endif
                        @endforeach
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $books->total() }} Books Available</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-sm text-slate-400 font-medium mr-2">Sort by:</span>
                    <select
                        class="form-select border-slate-200 rounded-lg text-sm text-slate-600 focus:border-blue-500 focus:ring-blue-500">
                        <option>Newest Added</option>
                        <option>Most Popular</option>
                        <option>Alphabetical</option>
                    </select>
                </div>
            </div>

            @if ($books->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                    @foreach ($books as $book)
                        <a href="{{ route('books.show', $book->slug) }}"
                            class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 flex flex-col h-full">

                            <!-- Cover Image -->
                            <div class="relative h-[360px] overflow-hidden bg-slate-100">
                                @if ($book->cover_image)
                                    <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                        <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                                    </div>
                                @endif
                                <!-- Overlay Gradient (Subtle) -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="mb-2 flex items-center gap-2">
                                    <span
                                        class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $book->created_at->format('M Y') }}
                                    </span>
                                </div>
                                <h3
                                    class="text-lg font-bold text-slate-900 leading-tight mb-1 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $book->title }}
                                </h3>
                                <p class="text-sm text-slate-500 mb-4 line-clamp-1 font-medium">{{ $book->author }}</p>

                                <div
                                    class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between text-xs font-semibold text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-3 h-3"></i>
                                        {{ ceil($book->total_pages * 1.5) }} min
                                    </span>
                                    <span
                                        class="group-hover:text-blue-600 group-hover:translate-x-1 transition-all flex items-center gap-1">
                                        Read Summary <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $books->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                    <div
                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <i data-lucide="search-x" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No results found</h3>
                    <p class="text-slate-500 mb-6">Try adjusting your search terms to find what you're looking for.</p>
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-blue-600/20">
                        Clear Search
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>
