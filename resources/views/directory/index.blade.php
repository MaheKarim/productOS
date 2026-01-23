@extends('frontend.layout')

@section('title', 'Directory - ProductOS')

@section('content')
    <div class="relative min-h-screen bg-[#030712] text-white selection:bg-indigo-500/30 overflow-hidden">
        {{-- Futuristic Background Mesh --}}
        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-indigo-900/20 rounded-full blur-[120px] animate-pulse-slow">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-900/20 rounded-full blur-[120px] animate-pulse-slow delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.05)_0%,transparent_70%)]">
            </div>
            {{-- Grid Pattern Overlay --}}
            <div
                class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:40px_40px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
            </div>
        </div>

        {{-- Hero & Search --}}
        <div class="relative z-10 pt-40 pb-20 px-6">
            <div class="max-w-5xl mx-auto text-center mb-16">
                <div
                    class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-8 animate-fade-in">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span>Direct Access to Innovation</span>
                </div>

                <h1
                    class="text-5xl md:text-8xl font-black text-white mb-8 tracking-tighter leading-none animate-fade-in-up">
                    The PM <br />
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-blue-400 to-cyan-400">Knowledge
                        Graph.</span>
                </h1>

                <p
                    class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto leading-relaxed font-light animate-fade-in-up delay-100">
                    A multi-dimensional repository of tools, workflows, and insights curated for the next generation of
                    product leaders.
                </p>

                {{-- Floating Search Bar with Neon Glow --}}
                <div class="relative max-w-3xl mx-auto group animate-fade-in-up delay-200" x-data="{
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
                }"
                    @click.away="showResults = false">

                    {{-- Neon Border Effect --}}
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-[2rem] blur opacity-25 group-focus-within:opacity-50 transition duration-500">
                    </div>

                    <div class="relative">
                        <input type="text" x-model="query" @input.debounce.300ms="search()"
                            placeholder="Initialize query for tools, courses, jobs..."
                            class="w-full bg-[#0F172A]/80 backdrop-blur-2xl border border-white/10 text-white placeholder-slate-500 rounded-[1.8rem] py-5 pl-14 pr-6 text-xl focus:outline-none focus:ring-0 shadow-2xl transition-all">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-indigo-400 text-lg group-focus-within:scale-110 transition-transform"></i>
                        <div x-show="loading" class="absolute right-6 top-1/2 -translate-y-1/2 text-cyan-400">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                        </div>
                    </div>

                    {{-- Search Results Glass Card --}}
                    <div x-show="showResults && results.length > 0" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute w-full mt-6 bg-[#0F172A]/90 backdrop-blur-3xl border border-white/10 rounded-[2rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.5)] overflow-hidden z-50 text-left">
                        <ul class="max-h-[440px] overflow-y-auto divide-y divide-white/5 scrollbar-thin">
                            <template x-for="item in results" :key="item.uuid">
                                <li>
                                    <a :href="item.website_url || '#'" target="_blank" @click="trackClick(item.uuid)"
                                        class="block p-5 hover:bg-white/5 transition-all group/item">
                                        <div class="flex items-center space-x-5">
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-slate-800/80 p-0.5 border border-white/10 shadow-inner">
                                                <template x-if="item.logo_path">
                                                    <img :src="'/storage/' + item.logo_path"
                                                        class="w-full h-full object-cover rounded-[0.9rem]">
                                                </template>
                                                <template x-if="!item.logo_path">
                                                    <div
                                                        class="w-full h-full flex items-center justify-center bg-indigo-500/10 rounded-[0.9rem]">
                                                        <span class="text-xs font-bold text-indigo-400"
                                                            x-text="item.type.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="text-lg font-bold text-white group-hover/item:text-indigo-400 transition-colors"
                                                        x-text="item.name"></span>
                                                    <span
                                                        class="text-[9px] px-2 py-0.5 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 uppercase font-black"
                                                        x-text="item.type"></span>
                                                </div>
                                                <p class="text-sm text-slate-500 group-hover/item:text-slate-400 transition-colors mt-0.5 line-clamp-1"
                                                    x-text="item.tagline"></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Categories Section --}}
            <div class="max-w-[1400px] mx-auto pt-20">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <h2 class="text-xs font-black text-indigo-400 uppercase tracking-[0.3em] mb-3">System Mapping</h2>
                        <h3 class="text-3xl md:text-4xl font-black text-white tracking-tight">Browse Sub-Systems</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                    @foreach ($categories as $category)
                        @php $route = route('directory.' . $category->type); @endphp
                        <a href="{{ $route }}"
                            class="group relative bg-[#1E293B]/30 backdrop-blur-xl border border-white/5 rounded-[2.5rem] p-8 hover:bg-white/[0.07] hover:border-white/20 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                            {{-- Ambient Glow --}}
                            <div
                                class="absolute -bottom-20 -right-20 w-40 h-40 {{ $category->color_class }} opacity-[0.05] group-hover:opacity-20 blur-3xl transition-opacity duration-500">
                            </div>

                            <div class="relative z-10 flex flex-col h-full">
                                <div
                                    class="w-14 h-14 rounded-2xl {{ $category->color_class }} bg-opacity-10 border border-white/5 flex items-center justify-center mb-8 group-hover:scale-110 group-hover:shadow-[0_0_30px_-5px_rgba(0,0,0,0.5)] transition-all duration-500 text-3xl {{ str_replace('bg-', 'text-', $category->color_class) }}">
                                    <i class="{{ $category->icon }}"></i>
                                </div>

                                <h3
                                    class="text-xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-slate-400 transition-all">
                                    {{ $category->name }}</h3>
                                <p class="text-slate-500 text-sm font-medium leading-relaxed mb-8 flex-grow line-clamp-2">
                                    {{ $category->description }}</p>

                                <div class="flex items-center justify-between mt-auto">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $category->item_count }}
                                        Units</span>
                                    <div
                                        class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center group-hover:border-white/30 group-hover:bg-white text-slate-400 group-hover:text-black transition-all">
                                        <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Featured Section --}}
            @if ($featuredItems->isNotEmpty())
                <div class="max-w-[1400px] mx-auto pt-32 pb-20">
                    <div class="flex items-end justify-between mb-12">
                        <div>
                            <h2 class="text-xs font-black text-amber-400 uppercase tracking-[0.3em] mb-3">High Priority</h2>
                            <h3 class="text-3xl md:text-4xl font-black text-white tracking-tight">Verified Entities</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($featuredItems as $item)
                            <div
                                class="group relative bg-[#0F172A]/40 backdrop-blur-2xl border border-white/10 p-8 rounded-[2.5rem] flex flex-col hover:bg-white/[0.05] transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-500/5">
                                <div class="flex justify-between items-start mb-8">
                                    <div
                                        class="w-16 h-16 rounded-[1.2rem] bg-slate-800/80 p-0.5 border border-white/10 shadow-2xl">
                                        @if ($item->logo_path)
                                            <img src="{{ Storage::url($item->logo_path) }}"
                                                class="w-full h-full object-cover rounded-[1.1rem]">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-indigo-500/10 rounded-[1.1rem]">
                                                <i class="fa-solid fa-cube text-indigo-400/50 text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="px-2 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-500 text-[9px] font-black uppercase tracking-widest rounded-lg">
                                        Featured</div>
                                </div>

                                <div class="flex-grow">
                                    <div
                                        class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-3">
                                        <span>{{ $item->type }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                        <span class="text-slate-500">{{ $item->category }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-3 tracking-tight">{{ $item->name }}</h3>
                                    <p
                                        class="text-slate-500 text-sm font-medium leading-relaxed mb-8 line-clamp-2 group-hover:text-slate-400 transition-colors">
                                        {{ $item->tagline }}</p>
                                </div>

                                <a href="{{ $item->website_url ?? '#' }}" target="_blank"
                                    class="relative overflow-hidden w-full py-4 rounded-2xl bg-white text-slate-900 text-sm font-black uppercase tracking-[0.2em] group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 text-center">
                                    <span class="relative z-10">Access Interface</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CTA Section --}}
            <div class="max-w-[1400px] mx-auto pb-40">
                <div
                    class="relative bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[3rem] p-16 md:p-24 overflow-hidden group shadow-[0_0_80px_-20px_rgba(79,70,229,0.3)]">
                    {{-- Animated Volumetric Lighting --}}
                    <div
                        class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_80%_20%,rgba(255,255,255,0.15)_0%,transparent_50%)]">
                    </div>
                    <div
                        class="absolute -bottom-1/2 -left-1/4 w-[80%] h-[80%] bg-cyan-400/20 rounded-full blur-[120px] animate-pulse-slow">
                    </div>

                    <div class="relative z-10 max-w-3xl">
                        <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tighter leading-tight">Augment
                            the Hub.</h2>
                        <p class="text-indigo-100/80 text-xl font-light leading-relaxed mb-12 max-w-2xl">
                            The repository is decentralized by nature. Contribute your specialized tools or intelligence to
                            the ecosystem.
                        </p>
                        <a href="mailto:mahe@productOS.bd"
                            class="inline-flex items-center px-10 py-5 bg-white text-indigo-600 font-black uppercase tracking-[0.2em] rounded-[1.5rem] hover:bg-slate-50 transition-all duration-300 shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] hover:-translate-y-1 hover:shadow-white/10 group">
                            <i class="fa-solid fa-terminal mr-3 group-hover:animate-pulse"></i> Submit Intelligence
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.1;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(1.1);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }

        .animate-fade-in {
            animation: fade-in 1.5s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 5px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Nav Override */
        nav {
            background: rgba(3, 7, 18, 0.7) !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            backdrop-blur: 20px !important;
        }

        nav a.text-slate-600 {
            color: #94a3b8 !important;
        }

        nav a.text-slate-600:hover,
        nav a.text-blue-600 {
            color: white !important;
        }

        nav .text-slate-900 {
            color: white !important;
        }

        /* Icon Gradients */
        .fa-solid,
        .fa-brands,
        .fa-regular {
            background: linear-gradient(135deg, #a5b4fc 0%, #6366f1 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
    </style>
@endpush
