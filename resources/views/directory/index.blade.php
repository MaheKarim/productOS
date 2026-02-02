@extends('frontend.layout')

@section('title', 'Directory - ProductOS')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-purple-50 via-white to-violet-50 selection:bg-purple-200">
        {{-- Hero & Search Section --}}
        <div class="relative pt-32 pb-16 px-6">
            <div class="max-w-6xl mx-auto text-center">
                {{-- Badge --}}
                <div
                    class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-purple-100 border border-purple-200 text-purple-700 text-xs font-bold uppercase tracking-wider mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    <span>PM Resource Directory</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight leading-tight">
                    Discover Essential<br />
                    <span class="text-purple-600">Product Management Resources</span>
                </h1>

                {{-- Subheading --}}
                <p class="text-xl text-slate-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Curated directory of tools, communities, courses, and frameworks to supercharge your PM journey.
                </p>

                {{-- Search Bar --}}
                <div class="relative max-w-3xl mx-auto" x-data="{
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
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        });
                    }
                }" @click.away="showResults = false">

                    <div class="relative group">
                        <input type="text" x-model="query" @input.debounce.300ms="search()"
                            placeholder="Search for tools, courses, communities..."
                            class="w-full bg-white border-2 border-slate-200 text-slate-900 placeholder-slate-400 rounded-2xl py-5 pl-14 pr-6 text-lg focus:outline-none focus:border-purple-600 focus:ring-4 focus:ring-purple-100 transition-all shadow-sm">
                        <svg class="w-6 h-6 absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"
                            :class="{ 'text-purple-600': query }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <div x-show="loading" class="absolute right-5 top-1/2 -translate-y-1/2 text-purple-600">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Search Results --}}
                    <div x-show="showResults && results.length > 0" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute w-full mt-4 bg-white border-2 border-slate-200 rounded-2xl shadow-xl overflow-hidden z-50 text-left">
                        <ul class="max-h-96 overflow-y-auto divide-y divide-slate-100">
                            <template x-for="item in results" :key="item.uuid">
                                <li>
                                    <a :href="item.website_url || '#'" target="_blank" @click="trackClick(item.uuid)"
                                        class="block p-4 hover:bg-purple-50 transition-colors cursor-pointer group">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 p-2 flex-shrink-0">
                                                <template x-if="item.logo_path">
                                                    <img :src="'/storage/' + item.logo_path"
                                                        class="w-full h-full object-cover rounded-lg">
                                                </template>
                                                <template x-if="!item.logo_path">
                                                    <div
                                                        class="w-full h-full flex items-center justify-center bg-purple-100 rounded-lg">
                                                        <span class="text-sm font-bold text-purple-600"
                                                            x-text="item.type.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between gap-3">
                                                    <span
                                                        class="text-base font-bold text-slate-900 group-hover:text-purple-600 transition-colors truncate"
                                                        x-text="item.name"></span>
                                                    <span
                                                        class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-700 uppercase font-bold flex-shrink-0"
                                                        x-text="item.type"></span>
                                                </div>
                                                <p class="text-sm text-slate-600 mt-1 line-clamp-1" x-text="item.tagline">
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories Section --}}
        <div class="max-w-7xl mx-auto px-6 py-20">
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-3">Browse by Category</h2>
                <p class="text-lg text-slate-600">Explore resources organized by type</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach ($categories as $category)
                    @php $route = route('directory.' . $category->type); @endphp
                    <a href="{{ $route }}"
                        class="group bg-white border-2 border-slate-200 rounded-2xl p-6 hover:border-purple-600 hover:shadow-lg hover:shadow-purple-100 transition-all duration-200 cursor-pointer">

                        <div class="flex flex-col h-full">
                            <div
                                class="w-12 h-12 rounded-xl {{ $category->color_class }} bg-opacity-10 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-200 text-2xl">
                                <i
                                    class="{{ $category->icon }} {{ str_replace('bg-', 'text-', $category->color_class) }}"></i>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-purple-600 transition-colors">
                                {{ $category->name }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-5 flex-grow line-clamp-2">
                                {{ $category->description }}</p>

                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                    {{ $category->item_count }} Items
                                </span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Featured Section --}}
        @if ($featuredItems->isNotEmpty())
            <div class="bg-gradient-to-br from-purple-100/50 to-violet-100/50 py-20">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="mb-12">
                        <div
                            class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-wider mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span>Featured Resources</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-slate-900">Editor's Picks</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($featuredItems as $item)
                            <div
                                class="bg-white border-2 border-slate-200 p-6 rounded-2xl flex flex-col hover:border-purple-600 hover:shadow-lg hover:shadow-purple-100 transition-all duration-200 cursor-pointer group">
                                <div class="flex justify-between items-start mb-5">
                                    <div class="w-14 h-14 rounded-xl bg-slate-100 p-2 flex-shrink-0">
                                        @if ($item->logo_path)
                                            <img src="{{ Storage::url($item->logo_path) }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-purple-100 rounded-lg">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-wider rounded-lg">
                                        Featured</div>
                                </div>

                                <div class="flex-grow">
                                    <div
                                        class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-purple-600 mb-2">
                                        <span>{{ $item->type }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="text-slate-500">{{ $item->category }}</span>
                                    </div>
                                    <h3
                                        class="text-lg font-bold text-slate-900 mb-2 group-hover:text-purple-600 transition-colors">
                                        {{ $item->name }}</h3>
                                    <p class="text-sm text-slate-600 leading-relaxed mb-6 line-clamp-2">
                                        {{ $item->tagline }}</p>
                                </div>

                                <a href="{{ $item->website_url ?? '#' }}" target="_blank"
                                    class="w-full py-3 px-4 rounded-xl bg-purple-600 text-white text-sm font-bold uppercase tracking-wider hover:bg-purple-700 transition-colors text-center">
                                    Visit Resource
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- CTA Section --}}
        <div class="max-w-7xl mx-auto px-6 py-32">
            <div class="bg-gradient-to-br from-purple-600 to-violet-600 rounded-3xl p-12 md:p-16 overflow-hidden relative">
                {{-- Decorative Elements --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-violet-800/30 rounded-full blur-3xl"></div>

                <div class="relative z-10 max-w-3xl">
                    <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight leading-tight">
                        Contribute to the Directory
                    </h2>
                    <p class="text-purple-100 text-xl leading-relaxed mb-10 max-w-2xl">
                        Know a great PM resource that's missing? Help the community by submitting your favorite tools,
                        courses, or communities.
                    </p>
                    <a href="mailto:mahe@productOS.bd"
                        class="inline-flex items-center px-8 py-4 bg-orange-500 text-white font-bold uppercase tracking-wider rounded-xl hover:bg-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5 cursor-pointer group">
                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Submit a Resource
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
