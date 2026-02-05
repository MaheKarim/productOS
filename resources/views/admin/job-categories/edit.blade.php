@extends('admin.layout')

@section('page-title', 'Edit Job Category')

@section('content')
    <div class="max-w-xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.job-categories.index') }}"
                    class="text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <h1 class="text-xl font-semibold text-slate-900">Edit Category</h1>
                <span class="px-2 py-0.5 text-xs font-mono text-slate-500 bg-slate-100 rounded border border-slate-200">ID:
                    {{ $jobCategory->id }}</span>
            </div>
            <p class="text-slate-500 text-sm ml-8">Manage category settings and appearance.</p>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-medium text-slate-900">Category Details</h3>
            </div>

            <form action="{{ route('admin.job-categories.update', $jobCategory) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Category Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $jobCategory->name) }}"
                        required
                        class="w-full h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">Slug</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 text-sm text-slate-500 bg-slate-50 border border-r-0 border-slate-200 rounded-l-lg">/job-categories/</span>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $jobCategory->slug) }}"
                            class="flex-1 h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-r-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Leave blank to auto-generate from name</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Icon --}}
                <div>
                    <label for="icon" class="block text-sm font-medium text-slate-700 mb-1.5">Icon</label>
                    <div class="flex gap-3">
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $jobCategory->icon) }}"
                            placeholder="e.g. briefcase, code, palette"
                            class="flex-1 h-10 px-3 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all text-sm">
                        @if ($jobCategory->icon)
                            <div
                                class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center border border-slate-200">
                                <i data-lucide="{{ $jobCategory->icon }}" class="w-5 h-5 text-slate-600"></i>
                            </div>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Lucide icon name (e.g. briefcase, code, palette)</p>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preview --}}
                <div class="py-4">
                    <label class="block text-sm font-medium text-slate-700 mb-3">Preview</label>
                    <div class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-200">
                        <div class="w-7 h-7 bg-white rounded-md flex items-center justify-center border border-slate-200">
                            @if ($jobCategory->icon)
                                <i data-lucide="{{ $jobCategory->icon }}" class="w-4 h-4 text-slate-600"></i>
                            @else
                                <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i>
                            @endif
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ $jobCategory->name }}</span>
                        <span
                            class="px-1.5 py-0.5 text-xs font-medium text-slate-500 bg-white rounded border border-slate-200">
                            {{ $jobCategory->jobs_count ?? $jobCategory->jobs()->count() }}
                            {{ Str::plural('job', $jobCategory->jobs_count ?? $jobCategory->jobs()->count()) }}
                        </span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 h-10 px-4 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg transition-colors cursor-pointer flex items-center justify-center gap-2 text-sm">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Update Category
                    </button>
                    <a href="{{ route('admin.job-categories.index') }}"
                        class="px-4 h-10 flex items-center text-slate-500 hover:text-slate-700 font-medium text-sm transition-colors cursor-pointer">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="mt-6 bg-white rounded-xl border border-red-200 shadow-sm">
            <div class="px-6 py-4 border-b border-red-100 flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-red-500"></i>
                <h3 class="text-sm font-medium text-red-600">Danger Zone</h3>
            </div>
            <div class="p-6 flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-sm font-medium text-slate-900 mb-1">Delete this category</h4>
                    <p class="text-xs text-slate-500">Once deleted, all jobs in this category will become uncategorized.</p>
                </div>
                <form action="{{ route('admin.job-categories.destroy', $jobCategory) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this category? All jobs will become uncategorized.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-3 h-9 bg-white hover:bg-red-50 text-red-600 font-medium text-sm rounded-lg border border-red-200 transition-colors cursor-pointer whitespace-nowrap">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
