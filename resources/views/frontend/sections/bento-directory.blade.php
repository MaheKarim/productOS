{{-- Bento Directory Section --}}
<section class="py-24 bg-slate-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-6">
                Everything You Need <br>
                <span class="text-indigo-600">to Ship Better Products</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-3 gap-6 h-auto md:h-[800px]">

            {{-- Large Card: Interview Prep --}}
            <a href="{{ route('interview-prep.landing') }}"
                class="group relative md:col-span-2 md:row-span-2 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>

                <div class="relative z-10 h-full flex flex-col">
                    <div
                        class="w-12 h-12 bg-indigo-100 group-hover:bg-white/20 rounded-xl flex items-center justify-center text-indigo-600 group-hover:text-white mb-6 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 group-hover:text-white mb-2">Interview Prep</h3>
                    <p class="text-slate-500 group-hover:text-indigo-100">Practicing for FAANG PM interviews? Get access
                        to 500+ questions and AI-graded mock interviews.</p>

                    <div class="mt-auto pt-8">
                        <div class="flex -space-x-3 overflow-hidden">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-200"></div>
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-300"></div>
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-400"></div>
                            <div
                                class="w-10 h-10 rounded-full border-2 border-white bg-indigo-600 flex items-center justify-center text-xs text-white font-bold">
                                +2k</div>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Medium Card: Directory --}}
            <a href="{{ route('directory.index') }}"
                class="group relative md:col-span-2 md:row-span-1 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-emerald-100 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 opacity-50 group-hover:opacity-70 transition-opacity">
                </div>

                <div class="relative z-10 flex items-center justify-between h-full">
                    <div>
                        <div
                            class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1">Resource Directory</h3>
                        <p class="text-sm text-slate-500">Curated tools & templates.</p>
                    </div>
                    <div
                        class="text-4xl font-black text-emerald-500/20 group-hover:text-emerald-500/40 transition-colors">
                        500+
                    </div>
                </div>
            </a>

            {{-- Medium Card: Book Library --}}
            <a href="{{ route('books.index') }}"
                class="group relative md:col-span-1 md:row-span-2 bg-slate-900 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20">
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent"></div>

                <div class="relative z-10 h-full flex flex-col">
                    <div
                        class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center text-white mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Book Library</h3>
                    <p class="text-sm text-slate-400">Summaries of top business books.</p>

                    <div class="mt-auto pt-6 space-y-2">
                        <div class="h-2 bg-white/10 rounded-full w-full"></div>
                        <div class="h-2 bg-white/10 rounded-full w-2/3"></div>
                        <div class="h-2 bg-white/10 rounded-full w-4/5"></div>
                    </div>
                </div>
            </a>

            {{-- Medium Card: Prompts --}}
            <a href="{{ route('prompts.index') }}"
                class="group relative md:col-span-1 md:row-span-2 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all overflow-hidden flex flex-col">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>

                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center text-amber-600 mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">AI Prompts</h3>
                <p class="text-sm text-slate-500 mb-6">Frameworks for ChatGPT & Claude.</p>

                <div class="mt-auto bg-slate-50 rounded-xl p-3 border border-slate-100">
                    <div class="flex gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                        <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    </div>
                    <div class="space-y-1.5">
                        <div class="h-1.5 bg-slate-200 rounded-full w-full"></div>
                        <div class="h-1.5 bg-slate-200 rounded-full w-5/6"></div>
                        <div class="h-1.5 bg-slate-200 rounded-full w-4/5"></div>
                    </div>
                </div>
            </a>

            {{-- Small Card: Coming Soon --}}
            <div
                class="group relative md:col-span-2 md:row-span-1 bg-slate-50 rounded-3xl p-8 border border-slate-200 border-dashed hover:border-solid hover:border-slate-300 transition-all flex items-center justify-center">
                <div class="text-center">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Coming Soon</p>
                    <h3 class="text-lg font-bold text-slate-600">Resume Builder</h3>
                </div>
            </div>

        </div>
    </div>
</section>
