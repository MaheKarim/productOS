<section id="skills" class="py-24 bg-slate-50 relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-100 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-40"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 border border-purple-100 text-purple-600 rounded-full text-sm font-semibold mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                    </path>
                </svg>
                Expertise
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                My <span class="bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">PM
                    Toolkit</span>
            </h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Frameworks, methodologies, and skills I use to build successful products.
            </p>
        </div>

        <!-- Skills Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- PM Frameworks -->
            <div
                class="bg-white rounded-2xl p-8 border border-slate-200 hover:shadow-xl hover:border-purple-300 transition-all group">
                <div class="flex items-start gap-4 mb-6">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-violet-600 flex items-center justify-center shrink-0 shadow-lg shadow-purple-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-purple-600 transition-colors">
                            PM Frameworks & Methodologies</h3>
                        <p class="text-sm text-slate-500">Proven approaches to building products</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['Lean Startup', 'Agile/Scrum', 'Design Thinking', 'Jobs-to-be-Done', 'OKRs', 'RICE Prioritization', 'Continuous Discovery'] as $skill)
                        <span
                            class="px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium border border-purple-100 hover:bg-purple-100 transition-colors">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Tools & Platforms -->
            <div
                class="bg-white rounded-2xl p-8 border border-slate-200 hover:shadow-xl hover:border-blue-300 transition-all group">
                <div class="flex items-start gap-4 mb-6">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shrink-0 shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                            Tools & Platforms</h3>
                        <p class="text-sm text-slate-500">Software I use daily</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">PM Tools</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Jira', 'Productboard', 'Linear', 'Notion', 'Confluence'] as $tool)
                                <span
                                    class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">{{ $tool }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Analytics</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Amplitude', 'Mixpanel', 'Hotjar', 'GA4'] as $tool)
                                <span
                                    class="px-3 py-1.5 bg-cyan-50 text-cyan-700 rounded-lg text-sm font-medium border border-cyan-100">{{ $tool }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Skills -->
            <div
                class="bg-white rounded-2xl p-8 border border-slate-200 hover:shadow-xl hover:border-emerald-300 transition-all group">
                <div class="flex items-start gap-4 mb-6">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shrink-0 shadow-lg shadow-emerald-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="text-xl font-bold text-slate-900 mb-1 group-hover:text-emerald-600 transition-colors">
                            Technical Skills</h3>
                        <p class="text-sm text-slate-500">Bridge between product & engineering</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach ([['name' => 'SQL & Data Analysis', 'level' => 85], ['name' => 'API Understanding', 'level' => 80], ['name' => 'HTML/CSS/Basic JS', 'level' => 75], ['name' => 'System Architecture', 'level' => 70]] as $skill)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-slate-700">{{ $skill['name'] }}</span>
                                <span class="text-emerald-600 font-bold">{{ $skill['level'] }}%</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-1000"
                                    style="width: {{ $skill['level'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Core PM Competencies -->
            <div
                class="bg-white rounded-2xl p-8 border border-slate-200 hover:shadow-xl hover:border-amber-300 transition-all group">
                <div class="flex items-start gap-4 mb-6">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shrink-0 shadow-lg shadow-amber-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-1 group-hover:text-amber-600 transition-colors">
                            Core Competencies</h3>
                        <p class="text-sm text-slate-500">Soft skills that drive results</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ([
        ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'name' => 'Stakeholder Mgmt'],
        ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'name' => 'User Research'],
        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'name' => 'Data Analysis'],
        ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'name' => 'Cross-func Leadership'],
        ['icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', 'name' => 'Strategic Roadmapping'],
        ['icon' => 'M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12', 'name' => 'Prioritization'],
    ] as $skill)
                        <div class="flex items-center gap-2 p-3 bg-amber-50 rounded-xl border border-amber-100">
                            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $skill['icon'] }}"></path>
                            </svg>
                            <span class="text-sm font-medium text-slate-700">{{ $skill['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
