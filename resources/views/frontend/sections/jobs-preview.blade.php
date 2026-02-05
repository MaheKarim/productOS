@php
    $featuredJobs = \App\Models\Job::with('category')
        ->active()
        ->notExpired()
        ->latest('is_featured')
        ->latest()
        ->take(6)
        ->get();
@endphp

@if ($featuredJobs->count() > 0)
    <section id="jobs" class="py-24 px-4 sm:px-6 lg:px-8 bg-white relative overflow-hidden">
        {{-- Decorative Background --}}
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-50/50 rounded-full blur-[100px] -mr-32 -mt-32 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-50/50 rounded-full blur-[100px] -ml-32 -mb-32 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest border border-blue-100 mb-6">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    Career Opportunities
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                    Find Your Next <span class="text-blue-600">Role</span>
                </h2>
                <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                    Curated job listings for product managers, designers, and developers. Companies that value your
                    craft.
                </p>
            </div>

            {{-- Jobs Grid --}}
            <div class="space-y-4 mb-12">
                @foreach ($featuredJobs as $job)
                    <a href="{{ route('jobs.show', $job->slug) }}"
                        class="block bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-2xl p-6 transition-all cursor-pointer group {{ $job->is_featured ? 'bg-amber-50/30 border-amber-200 hover:border-amber-300' : '' }}">
                        <div class="flex flex-col md:flex-row md:items-center gap-5">
                            {{-- Company Logo Placeholder --}}
                            <div
                                class="w-14 h-14 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-xl flex-shrink-0 group-hover:bg-white transition-colors">
                                {{ strtoupper(substr($job->company_name, 0, 1)) }}
                            </div>

                            {{-- Job Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3
                                        class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors truncate">
                                        {{ $job->job_title }}
                                    </h3>
                                    @if ($job->is_featured)
                                        <span
                                            class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase">Featured</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 text-slate-600 text-sm mb-3">
                                    <span class="font-medium">{{ $job->company_name }}</span>
                                    <i data-lucide="badge-check" class="w-4 h-4 text-blue-500"></i>
                                </div>

                                {{-- Tags Row --}}
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    {{-- Location Type --}}
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 font-medium border border-slate-200">
                                        <i data-lucide="map-pin" class="w-3 h-3"></i>
                                        {{ $job->location ?? 'Remote' }}
                                    </span>

                                    {{-- Job Type --}}
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 font-medium border border-slate-200">
                                        {{ $job->job_type }}
                                    </span>

                                    {{-- Salary --}}
                                    @if ($job->salary_range)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-medium border border-emerald-100">
                                            {{ $job->salary_range }}
                                        </span>
                                    @endif

                                    {{-- Sample Country Flags (would come from job_data in production) --}}
                                    @if (!empty($job->job_data['countries']))
                                        @foreach (array_slice($job->job_data['countries'], 0, 3) as $country)
                                            <span
                                                class="px-2 py-1 rounded-md bg-slate-50 text-slate-600 font-medium border border-slate-200 text-xs">
                                                {{ $country }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Posted Time & Arrow --}}
                            <div class="hidden md:flex flex-col items-end gap-2">
                                <span class="text-xs font-medium text-slate-400">
                                    @php
                                        $posted = $job->posted_date ?? $job->created_at;
                                        $days = (int) now()->diffInDays($posted);
                                        $postedText = $days === 0 ? 'Today' : ($days === 1 ? '1d' : $days . 'd');
                                    @endphp
                                    {{ $postedText }}
                                </span>
                                <span class="text-blue-600 group-hover:translate-x-1 transition-transform">
                                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- View All CTA --}}
            <div class="text-center">
                <a href="{{ route('jobs.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-all cursor-pointer shadow-lg shadow-slate-900/10 hover:shadow-slate-900/20">
                    View All Jobs
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </section>
@endif
