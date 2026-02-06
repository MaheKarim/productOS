{{-- Bento Directory Section --}}
<section class="py-24 bg-slate-50 relative overflow-hidden">
    {{-- Background Decoration --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-indigo-100/50 rounded-full blur-3xl opacity-50 -z-10">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                Everything You Need <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">to Ship Better
                    Products</span>
            </h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                A curated collection of tools, templates, and frameworks to accelerate your product management career.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-3 gap-6 h-auto md:h-[800px]">

            {{-- Large Card: Interview Prep --}}
            <a href="{{ route('interview-prep.landing') }}"
                class="group relative md:col-span-2 md:row-span-2 bg-gradient-to-br from-indigo-600 to-violet-700 rounded-[2rem] p-10 shadow-lg hover:shadow-2xl hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all duration-500 ease-out overflow-hidden flex flex-col cursor-pointer border-none">

                {{-- Abstract Shapes --}}
                <div
                    class="absolute -right-10 -top-10 w-64 h-64 bg-white/10 rounded-full blur-3xl opacity-50 group-hover:opacity-75 transition-opacity duration-500">
                </div>

                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex items-start justify-between mb-8">
                        <div
                            class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-all duration-300 border border-white/20">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="px-3 py-1 rounded-full bg-white/20 text-[10px] font-bold text-white backdrop-blur-sm border border-white/10 tracking-widest">
                            POPULAR
                        </div>
                    </div>

                    <h3 class="text-3xl font-bold text-white mb-3 tracking-tight">
                        Interview Prep</h3>
                    <p class="text-indigo-100 text-lg leading-relaxed">
                        Practicing for FAANG PM interviews? Get access to 500+ questions and AI-graded mock interviews.
                    </p>

                    <div class="mt-auto pt-8 flex items-center gap-4">
                        <div class="flex -space-x-4 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Alex&background=cbd5e1&color=fff"
                                class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-transparent group-hover:ring-white/50"
                                alt="User">
                            <img src="https://ui-avatars.com/api/?name=Sarah&background=94a3b8&color=fff"
                                class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-transparent group-hover:ring-white/50"
                                alt="User">
                            <img src="https://ui-avatars.com/api/?name=Mike&background=64748b&color=fff"
                                class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-transparent group-hover:ring-white/50"
                                alt="User">
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-white flex items-center justify-center text-xs font-bold text-indigo-600 transition-colors">
                                +2k
                            </div>
                        </div>
                        <span class="text-sm font-medium text-indigo-200">Joined this week</span>
                    </div>
                </div>
            </a>

            {{-- Medium Card: Directory --}}
            <a href="{{ route('directory.index') }}"
                class="group relative md:col-span-2 md:row-span-1 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-[2rem] p-8 shadow-lg hover:shadow-2xl hover:shadow-emerald-500/30 hover:-translate-y-1 transition-all duration-500 ease-out overflow-hidden cursor-pointer border-none">

                <div class="relative z-10 flex items-center justify-between h-full">
                    <div class="flex-1">
                        <div
                            class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-4 transition-all duration-300 border border-white/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">
                            Resource Directory</h3>
                        <p class="text-sm text-emerald-50">Curated tools & templates.</p>
                    </div>
                    <div class="text-5xl font-black text-white/20 group-hover:text-white/30 transition-colors">
                        500+
                    </div>
                </div>
            </a>

            {{-- Medium Card: Book Library --}}
            <a href="{{ route('books.index') }}"
                class="group relative md:col-span-1 md:row-span-2 bg-gradient-to-br from-blue-600 to-indigo-900 rounded-[2rem] p-8 shadow-lg hover:shadow-2xl hover:shadow-blue-500/30 hover:-translate-y-1 transition-all duration-500 ease-out overflow-hidden flex flex-col cursor-pointer border-none">

                {{-- Dynamic Background --}}
                <div
                    class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light pointer-events-none">
                </div>

                <div class="relative z-10 h-full flex flex-col">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-6 border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Book Library</h3>
                    <p class="text-sm text-blue-100/80">Summaries of top business books.</p>

                    <div class="mt-auto pt-6 space-y-3">
                        <div class="h-1.5 bg-white/10 rounded-full w-full overflow-hidden">
                            <div class="h-full bg-blue-400 w-3/4 rounded-full"></div>
                        </div>
                        <div class="h-1.5 bg-white/10 rounded-full w-2/3 overflow-hidden">
                            <div class="h-full bg-indigo-400 w-1/2 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Medium Card: Prompts --}}
            <a href="{{ route('prompts.index') }}"
                class="group relative md:col-span-1 md:row-span-2 bg-gradient-to-br from-amber-400 to-orange-500 rounded-[2rem] p-8 shadow-lg hover:shadow-2xl hover:shadow-amber-500/30 hover:-translate-y-1 transition-all duration-500 ease-out overflow-hidden flex flex-col cursor-pointer border-none">

                <div class="relative z-10 h-full flex flex-col">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-white mb-6 border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">AI
                        Prompts</h3>
                    <p class="text-sm text-amber-50 mb-6">Frameworks for ChatGPT & Claude.</p>

                    <div class="mt-auto bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/10">
                        <div class="flex gap-1.5 mb-2">
                            <div class="w-2 h-2 rounded-full bg-red-400"></div>
                            <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                            <div class="w-2 h-2 rounded-full bg-green-400"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-1 bg-white/20 rounded-full w-full"></div>
                            <div class="h-1 bg-white/20 rounded-full w-5/6"></div>
                            <div class="h-1 bg-white/20 rounded-full w-4/5"></div>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Small Card: Coming Soon --}}
            <div
                class="group relative md:col-span-2 md:row-span-1 bg-slate-100 rounded-[2rem] p-8 border border-slate-300 border-dashed transition-all duration-300 flex items-center justify-center cursor-not-allowed overflow-hidden">
                <div class="text-center">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Coming Soon</p>
                    <h3 class="text-lg font-bold text-slate-500">Resume Builder</h3>
                </div>
            </div>

        </div>
    </div>
</section>
