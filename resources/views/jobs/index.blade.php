@extends('frontend.layout')

@section('title', 'ProductOS Jobs - Find Your Next Role')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        {{-- Hero Section --}}
        <div class="relative bg-white pt-32 pb-16 border-b border-slate-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-transparent to-indigo-50/30"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-sm font-medium text-blue-600 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    {{ \App\Models\Job::active()->count() }} Open Positions
                </span>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 tracking-tight">
                    Discover Your Next <br />
                    <span class="text-blue-600">Career Move</span>
                </h1>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10">
                    Curated job listings for product managers, designers, and developers. Find companies that value your
                    craft.
                </p>

                {{-- Search Bar --}}
                <div class="max-w-3xl mx-auto bg-white border border-slate-200 p-2 rounded-2xl shadow-lg">
                    <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                        <div class="flex-1 relative">
                            <i data-lucide="search"
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 w-5 h-5"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, company, or keywords..."
                                class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-900 placeholder-slate-400 h-12 text-sm">
                        </div>
                        <button type="submit"
                            class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl transition-all h-12 cursor-pointer">
                            Find Jobs
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Sidebar Filters --}}
                <div class="w-full lg:w-64 flex-shrink-0 space-y-6">
                    {{-- Categories --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Categories</h3>
                        <div class="space-y-1">
                            <a href="{{ route('jobs.index') }}"
                                class="flex items-center justify-between group px-3 py-2.5 rounded-lg transition-colors cursor-pointer {{ !request('category') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span class="text-sm font-medium">All Jobs</span>
                                <span
                                    class="text-xs {{ !request('category') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }} px-2 py-0.5 rounded-full">{{ \App\Models\Job::active()->count() }}</span>
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('jobs.index', array_merge(request()->query(), ['category' => $category->slug])) }}"
                                    class="flex items-center justify-between group px-3 py-2.5 rounded-lg transition-colors cursor-pointer {{ request('category') == $category->slug ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <span class="text-sm font-medium">{{ $category->name }}</span>
                                    <span
                                        class="text-xs {{ request('category') == $category->slug ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }} px-2 py-0.5 rounded-full">{{ $category->jobs_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Job Type --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Job Type</h3>
                        <div class="space-y-1">
                            @foreach (['Full-time', 'Part-time', 'Contract', 'Freelance', 'Internship'] as $type)
                                <a href="{{ route('jobs.index', array_merge(request()->query(), ['type' => $type])) }}"
                                    class="flex items-center gap-3 group px-3 py-2.5 rounded-lg transition-colors cursor-pointer {{ request('type') == $type ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <div
                                        class="w-4 h-4 rounded border-2 {{ request('type') == $type ? 'bg-blue-600 border-blue-600' : 'border-slate-300' }} flex items-center justify-center">
                                        @if (request('type') == $type)
                                            <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium">{{ $type }}</span>
                                </a>
                            @endforeach
                        </div>
                        @if (request('type'))
                            <a href="{{ route('jobs.index', array_diff_key(request()->query(), ['type' => ''])) }}"
                                class="block mt-3 text-xs text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                                Clear filter
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Job Listings --}}
                <div class="flex-1">
                    <div class="mb-6 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">
                            @if (request('search'))
                                Results for "{{ request('search') }}"
                            @elseif(request('category'))
                                {{ $categories->where('slug', request('category'))->first()->name ?? 'Category' }} Jobs
                            @else
                                Latest Opportunities
                            @endif
                        </h2>
                        <span class="text-sm text-slate-500">
                            {{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($jobs as $job)
                            <a href="{{ route('jobs.show', $job->slug) }}"
                                class="block bg-white hover:bg-slate-50 border border-slate-200 hover:border-slate-300 rounded-xl p-5 transition-all cursor-pointer group {{ $job->is_featured ? 'bg-amber-50/50 border-amber-200 hover:border-amber-300' : '' }}">
                                <div class="flex flex-col md:flex-row md:items-center gap-5">
                                    {{-- Company Logo --}}
                                    <div
                                        class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-lg flex-shrink-0 group-hover:bg-white transition-colors">
                                        {{ strtoupper(substr($job->company_name, 0, 1)) }}
                                    </div>

                                    {{-- Job Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3
                                                class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors truncate">
                                                {{ $job->job_title }}
                                            </h3>
                                            @if ($job->is_featured)
                                                <span
                                                    class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-[10px] font-bold uppercase flex-shrink-0">Featured</span>
                                            @endif
                                            @if ($job->created_at->diffInDays() < 3)
                                                <span
                                                    class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase border border-emerald-100 flex-shrink-0">New</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-3">
                                            <span class="font-medium">{{ $job->company_name }}</span>
                                            <i data-lucide="badge-check" class="w-4 h-4 text-blue-500"></i>
                                        </div>

                                        {{-- Tags --}}
                                        <div class="flex flex-wrap items-center gap-2 text-xs">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                <i data-lucide="map-pin" class="w-3 h-3"></i>
                                                {{ $job->location ?? 'Remote' }}
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                {{ $job->job_type }}
                                            </span>
                                            @if ($job->salary_range)
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 font-medium">
                                                    {{ $job->salary_range }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Posted Time --}}
                                    <div class="hidden md:flex flex-col items-end gap-1">
                                        <span class="text-xs font-medium text-slate-400">
                                            @php
                                                $posted = $job->posted_date ?? $job->created_at;
                                                $days = (int) now()->diffInDays($posted);
                                                $postedText =
                                                    $days === 0 ? 'Today' : ($days === 1 ? '1d' : $days . 'd');
                                            @endphp
                                            {{ $postedText }}
                                        </span>
                                        <span class="text-blue-600 group-hover:translate-x-1 transition-transform">
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="search-x" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-2">No jobs found</h3>
                                <p class="text-slate-500 max-w-sm mx-auto">Try adjusting your search terms or filters to
                                    find what you're looking for.</p>
                                <a href="{{ route('jobs.index') }}"
                                    class="inline-block mt-6 text-blue-600 font-bold hover:underline cursor-pointer">Clear
                                    all filters</a>
                            </div>
                        @endforelse
                    </div>

                    @if ($jobs->hasPages())
                        <div class="mt-10">
                            {{ $jobs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
