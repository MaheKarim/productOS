{{-- Features Hub Section with Category Filter --}}
<section id="features-hub" class="py-24 px-8 bg-slate-50 relative overflow-hidden" x-data="{
    activeFilter: 'all',
    features: [
        { id: 'tools', name: 'PM Calculators', category: 'productivity', icon: 'calculator', description: 'Essential calculators for ROI, prioritization, sprint velocity, and more.', route: '{{ route('tools.index') }}', color: 'blue' },
        { id: 'directory', name: 'PM Directory', category: 'research', icon: 'folder', description: 'Curated list of tools, frameworks, communities, and resources for PMs.', route: '{{ route('directory.index') }}', color: 'violet' },
        { id: 'youtube', name: 'YouTube Summarizer', category: 'productivity', icon: 'video', description: 'Paste a YouTube URL and get a concise summary with key takeaways.', route: '{{ route('yt-summarize.index') }}', color: 'red' },
        { id: 'books', name: 'Book Summaries', category: 'research', icon: 'book', description: 'Chapter-wise summaries of essential PM and business books.', route: '{{ route('books.index') }}', color: 'emerald' },
        { id: 'prompts', name: 'PM Prompts Library', category: 'strategy', icon: 'sparkles', description: 'AI-ready prompts for meetings, user stories, roadmaps, and more.', route: '{{ route('prompts.index') }}', color: 'amber' },
        { id: 'roadmap', name: 'PM Roadmap', category: 'strategy', icon: 'map', description: 'Your personalized learning path to becoming a better PM.', route: '{{ route('roadmap.index') }}', color: 'cyan' }
    ]
}">

    <div class="max-w-[1200px] mx-auto relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-12" data-aos="fade-up">
            <span
                class="inline-block py-1.5 px-4 rounded-full bg-blue-50 text-blue-600 text-xs font-bold mb-4 border border-blue-100 uppercase tracking-widest">
                All Features
            </span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                Your Complete <span class="text-blue-600 italic">PM Toolkit</span>
            </h2>
            <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Everything you need to excel in product management, all in one place.
            </p>
        </div>

        {{-- Category Filters --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12" data-aos="fade-up" data-aos-delay="100">
            <button @click="activeFilter = 'all'"
                :class="activeFilter === 'all' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100'"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all border border-slate-200 cursor-pointer">
                All Features
            </button>
            <button @click="activeFilter = 'productivity'"
                :class="activeFilter === 'productivity' ? 'bg-blue-600 text-white border-blue-600' :
                    'bg-white text-slate-600 hover:bg-blue-50'"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all border border-slate-200 cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Productivity
            </button>
            <button @click="activeFilter = 'research'"
                :class="activeFilter === 'research' ? 'bg-violet-600 text-white border-violet-600' :
                    'bg-white text-slate-600 hover:bg-violet-50'"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all border border-slate-200 cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Research
            </button>
            <button @click="activeFilter = 'strategy'"
                :class="activeFilter === 'strategy' ? 'bg-amber-600 text-white border-amber-600' :
                    'bg-white text-slate-600 hover:bg-amber-50'"
                class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all border border-slate-200 cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Strategy
            </button>
        </div>

        {{-- Features Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="200">
            <template x-for="feature in features" :key="feature.id">
                <a :href="feature.route" x-show="activeFilter === 'all' || activeFilter === feature.category"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="group bg-white rounded-2xl p-6 hover:shadow-xl transition-all duration-300 border border-slate-100 hover:border-slate-200 hover:-translate-y-1">

                    {{-- Icon --}}
                    <div class="mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110"
                            :class="{
                                'bg-blue-100 text-blue-600': feature.color === 'blue',
                                'bg-violet-100 text-violet-600': feature.color === 'violet',
                                'bg-red-100 text-red-600': feature.color === 'red',
                                'bg-emerald-100 text-emerald-600': feature.color === 'emerald',
                                'bg-amber-100 text-amber-600': feature.color === 'amber',
                                'bg-cyan-100 text-cyan-600': feature.color === 'cyan'
                            }">
                            {{-- Calculator Icon --}}
                            <svg x-show="feature.icon === 'calculator'" class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{-- Folder Icon --}}
                            <svg x-show="feature.icon === 'folder'" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                </path>
                            </svg>
                            {{-- Video Icon --}}
                            <svg x-show="feature.icon === 'video'" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{-- Book Icon --}}
                            <svg x-show="feature.icon === 'book'" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            {{-- Sparkles Icon --}}
                            <svg x-show="feature.icon === 'sparkles'" class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                            {{-- Map Icon --}}
                            <svg x-show="feature.icon === 'map'" class="w-6 h-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                        </div>
                    </div>

                    {{-- Content --}}
                    <h3 class="text-lg font-bold text-slate-900 mb-2" x-text="feature.name"></h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4" x-text="feature.description"></p>

                    {{-- CTA --}}
                    <div class="flex items-center text-sm font-semibold group-hover:gap-2 transition-all"
                        :class="{
                            'text-blue-600': feature.color === 'blue',
                            'text-violet-600': feature.color === 'violet',
                            'text-red-600': feature.color === 'red',
                            'text-emerald-600': feature.color === 'emerald',
                            'text-amber-600': feature.color === 'amber',
                            'text-cyan-600': feature.color === 'cyan'
                        }">
                        Use Tool
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </div>
                </a>
            </template>
        </div>
    </div>
</section>
