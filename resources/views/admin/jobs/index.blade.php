@extends('admin.layout')

@section('page-title', 'Job Board')

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Job Board</h1>
                <p class="text-slate-500 text-sm mt-1">Manage job listings, track applications, and organize your hiring
                    pipeline.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.job-categories.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-slate-700 hover:bg-slate-50 font-medium rounded-lg transition-colors border border-slate-200 shadow-sm cursor-pointer">
                    <i data-lucide="tag" class="w-4 h-4"></i>
                    Categories
                </a>
                <a href="{{ route('admin.jobs.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors shadow-sm cursor-pointer">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Post New Job
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Jobs --}}
            <div
                class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Jobs</p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ \App\Models\Job::count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="briefcase" class="w-5 h-5 text-slate-600"></i>
                    </div>
                </div>
            </div>

            {{-- Active Jobs --}}
            <div
                class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Active</p>
                        <p class="text-2xl font-semibold text-emerald-600 mt-1">{{ \App\Models\Job::active()->count() }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                </div>
            </div>

            {{-- Total Views --}}
            <div
                class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Views</p>
                        <p class="text-2xl font-semibold text-blue-600 mt-1">
                            {{ number_format(\App\Models\Job::sum('views_count')) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="eye" class="w-5 h-5 text-blue-600"></i>
                    </div>
                </div>
            </div>

            {{-- Applications --}}
            <div
                class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Applications</p>
                        <p class="text-2xl font-semibold text-amber-600 mt-1">
                            {{ number_format(\App\Models\Job::sum('applications_count')) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5 text-amber-600"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            {{-- Table Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-900">All Job Listings</h3>
                <span class="text-xs text-slate-500">{{ $jobs->total() ?? $jobs->count() }}
                    {{ Str::plural('job', $jobs->total() ?? $jobs->count()) }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500 font-medium border-b border-slate-100">
                            <th class="px-6 py-3">Job Info</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3">Location / Type</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Posted</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($jobs as $job)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-slate-900 group-hover:text-slate-700">
                                                {{ $job->job_title }}
                                            </span>
                                            @if ($job->is_featured)
                                                <span
                                                    class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-700">
                                                    <i data-lucide="star"
                                                        class="w-2.5 h-2.5 fill-amber-500 text-amber-500"></i>
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-sm text-slate-500">{{ $job->company_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $job->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-sm text-slate-700">{{ $job->location ?? 'Remote' }}</span>
                                        <span class="text-xs text-slate-500">{{ $job->job_type }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statuses = [
                                            'active' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'draft' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            'inactive' => 'bg-red-50 text-red-700 border-red-200',
                                            'expired' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        ];
                                        $statusClass = $statuses[$job->status] ?? $statuses['draft'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium capitalize border {{ $statusClass }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full {{ $job->status === 'active' ? 'bg-emerald-500' : ($job->status === 'inactive' ? 'bg-red-500' : 'bg-slate-400') }}"></span>
                                        {{ $job->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $job->posted_date ? $job->posted_date->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.jobs.edit', $job) }}"
                                            class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST"
                                            onsubmit="return confirm('Delete this job listing?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <i data-lucide="briefcase" class="w-6 h-6 text-slate-400"></i>
                                    </div>
                                    <h3 class="text-sm font-medium text-slate-900 mb-1">No jobs posted yet</h3>
                                    <p class="text-sm text-slate-500 max-w-sm mx-auto mb-4">Start by creating your first job
                                        listing to attract top talent.</p>
                                    <a href="{{ route('admin.jobs.create') }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition-colors cursor-pointer">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                        Post First Job
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jobs->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
