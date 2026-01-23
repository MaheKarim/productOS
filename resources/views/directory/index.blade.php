@extends('frontend.layout')

@section('title', 'Directory - ProductOS')

@section('content')
    <div class="relative min-h-[500px] flex items-center justify-center pt-32 pb-20 overflow-hidden bg-slate-900">
        {{-- Animated Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-900 to-blue-900/40"></div>
        <div
            class="absolute w-[800px] h-[800px] bg-blue-500/10 rounded-full blur-[120px] -top-[200px] left-1/2 -translate-x-1/2">
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs font-bold uppercase tracking-widest mb-6">
                Everything You Need
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight leading-tight">
                The Ultimate Resource Hub for <br />
                <span class="bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">Product
                    Managers</span>
            </h1>
            <p class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Curated tools, courses, jobs, communities, and templates. Built for the Bangladesh PM ecosystem.
            </p>

            {{-- Global Search Bar --}}
            <div class="relative max-w-2xl mx-auto mb-12" x-data="{
                query: '',
                results: [],
                showResults: false,
                loading: false,
                async search() {
                    if (this.query.length < 2) {
                        this.results = [];
                        this.showResults = false;
                        return;
                    }
                    this.loading = true;
                    const response = await fetch(`/directory/search?q=${this.query}`);
                    this.results = await response.json();
                    this.loading = false;
                    this.showResults = true;
                },
                trackClick(ItemUuid) {
                    fetch(`/directory/track-click/${ItemUuid}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                }
            }" @click.away="showResults = false">
                <div class="relative">
                    <input type="text" x-model="query" @input.debounce.300ms="search()"
                        placeholder="Search tools, courses, jobs..."
                        class="w-full bg-slate-800/80 backdrop-blur-md border border-slate-700 text-white placeholder-slate-500 rounded-2xl py-4 pl-12 pr-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-500/50 shadow-2xl transition-all">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <div x-show="loading" class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-500">
                        <i class="fa-solid fa-circle-notch fa-spin"></i>
                    </div>
                </div>

                {{-- Live Search Results --}}
                <div x-show="showResults && results.length > 0" x-transition
                    class="absolute w-full mt-4 bg-slate-900/90 backdrop-blur-xl border border-slate-700 rounded-2xl shadow-2xl overflow-hidden z-50 text-left">
                    <ul class="max-h-[400px] overflow-y-auto divide-y divide-slate-800">
                        <template x-for="item in results" :key="item.uuid">
                            <li>
                                <a :href="item.website_url || '#'" target="_blank" @click="trackClick(item.uuid)"
                                    class="block p-4 hover:bg-slate-800 transition-colors group">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center flex-shrink-0 border border-slate-700">
                                            <template x-if="item.logo_path">
                                                <img :src="'/storage/' + item.logo_path"
                                                    class="w-full h-full object-cover rounded-lg">
                                            </template>
                                            <template x-if="!item.logo_path">
                                                <span class="text-xs text-slate-500"
                                                    x-text="item.type.charAt(0).toUpperCase()"></span>
                                            </template>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="font-bold text-white group-hover:text-blue-400 transition-colors"
                                                    x-text="item.name"></span>
                                                <span
                                                    class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 border border-slate-700 text-slate-400 capitalize"
                                                    x-text="item.type"></span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5 truncate max-w-[300px]"
                                                x-text="item.tagline"></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </template>
                    </ul>
                    <div class="p-3 bg-slate-950/50 text-center text-xs text-slate-500 border-t border-slate-800">
                        Press Enter to see all results
                    </div>
                </div>
                <div x-show="showResults && results.length === 0 && !loading" x-cloak
                    class="absolute w-full mt-4 bg-slate-900 border border-slate-700 rounded-xl p-4 text-slate-400 text-sm">
                    No results found.
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-slate-500 font-medium">
                <span><i class="fa-solid fa-check text-blue-500 mr-2"></i> 500+ Curated Tools</span>
                <span><i class="fa-solid fa-check text-blue-500 mr-2"></i> Free Templates</span>
                <span><i class="fa-solid fa-check text-blue-500 mr-2"></i> Local Jobs</span>
            </div>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-6 py-20">
        {{-- Categories Grid --}}
        <h2 class="text-2xl font-bold text-slate-900 mb-10 border-l-4 border-blue-600 pl-4">Browse by Category</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-24">
            @foreach ($categories as $category)
                @php
                    // Map types to routes
                    $route = route('directory.' . $category->type); // Assumes route names match type
                @endphp
                <a href="{{ $route }}"
                    class="group relative overflow-hidden bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white to-slate-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 rounded-xl {{ $category->color_class }} bg-opacity-10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform text-2xl {{ str_replace('bg-', 'text-', $category->color_class) }}">
                            <i class="{{ $category->icon }}"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $category->name }}</h3>
                        <p class="text-slate-500 text-xs leading-relaxed mb-4 min-h-[40px]">{{ $category->description }}</p>
                        <div class="flex items-center justify-between">
                            <span
                                class="text-xs font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded">{{ $category->item_count }}
                                items</span>
                            <span
                                class="text-sm font-bold {{ str_replace('bg-', 'text-', $category->color_class) }} group-hover:translate-x-1 transition-transform">Explore
                                <i class="fa-solid fa-arrow-right ml-1 text-xs"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Featured Section --}}
        @if ($featuredItems->isNotEmpty())
            <div class="mb-24">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-2xl font-bold text-slate-900 border-l-4 border-amber-400 pl-4">Featured This Week</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredItems as $item)
                        <div
                            class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg transition-all group h-full flex flex-col">
                            <div class="flex items-start justify-between mb-6">
                                @if ($item->logo_path)
                                    <img src="{{ Storage::url($item->logo_path) }}"
                                        class="w-14 h-14 rounded-xl object-cover border border-slate-100 shadow-sm">
                                @else
                                    <div
                                        class="w-14 h-14 rounded-xl bg-slate-50 flex items-center justify-center border border-slate-100 shadow-sm">
                                        <i class="fa-solid fa-layer-group text-slate-300 text-xl"></i>
                                    </div>
                                @endif
                                <div class="flex space-x-2">
                                    @if ($item->is_featured)
                                        <span
                                            class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold uppercase rounded leading-none border border-amber-100">Featured</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4 flex-grow">
                                <div
                                    class="text-[10px] items-center text-blue-600 font-bold uppercase tracking-wider mb-2 flex space-x-2">
                                    <span>{{ $item->type }}</span>
                                    <span class="bg-slate-200 rounded-full w-1 h-1"></span>
                                    <span>{{ $item->category }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2">{{ $item->name }}</h3>
                                <p class="text-sm text-slate-500 line-clamp-2">{{ $item->tagline }}</p>
                            </div>

                            <a href="{{ $item->website_url ?? '#' }}" target="_blank"
                                class="w-full block text-center py-2.5 rounded-lg bg-slate-900 text-white text-sm font-semibold hover:bg-blue-600 transition-colors mt-auto">
                                Visit Website
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CTA Section --}}
        <div
            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-12 text-center text-white relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-400/20 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2">
            </div>

            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold mb-6">Have a resource to share?</h2>
                <p class="text-blue-100 text-lg mb-8">
                    Help us grow the largest repository of Product Management resources in Bangladesh. Submit your tool,
                    job, or community.
                </p>
                <a href="mailto:mahe@productOS.bd"
                    class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition shadow-xl hover:shadow-2xl hover:-translate-y-1">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Submit Resource
                </a>
            </div>
        </div>
    </div>
@endsection
