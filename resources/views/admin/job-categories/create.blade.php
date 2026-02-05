@extends('admin.layout')

@section('page-title', 'Create Job Category')

@section('content')
    <div class="max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.job-categories.index') }}"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </a>
                <h2 class="text-xl font-bold text-slate-900">Create Job Category</h2>
            </div>
            <p class="text-slate-500 text-sm ml-11">Add a new category to organize your job listings.</p>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('admin.job-categories.store') }}" method="POST" x-data="{ name: '', slug: '' }">
            @csrf

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                {{-- Card Header --}}
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="folder-plus" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-900">Category Details</h3>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 space-y-5">
                    {{-- Category Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required x-model="name"
                            placeholder="e.g. Engineering, Marketing, Design"
                            class="w-full h-10 px-3.5 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm">
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Slug
                            <span class="text-slate-400 font-normal">(optional)</span>
                        </label>
                        <input type="text" id="slug" name="slug" x-model="slug"
                            placeholder="auto-generated-from-name"
                            class="w-full h-10 px-3.5 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm font-mono">
                        <p class="mt-1.5 text-xs text-slate-400">
                            Leave empty to auto-generate from name. Used in URLs.
                        </p>
                        @error('slug')
                            <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Icon --}}
                    <div>
                        <label for="icon" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Icon
                            <span class="text-slate-400 font-normal">(optional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i data-lucide="image" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <input type="text" id="icon" name="icon"
                                placeholder="lucide icon name, e.g. briefcase, code, palette"
                                class="w-full h-10 pl-10 pr-3.5 bg-white border border-slate-200 text-slate-900 placeholder-slate-400 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all text-sm">
                        </div>
                        <p class="mt-1.5 text-xs text-slate-400">
                            Enter a Lucide icon name. View all icons at
                            <a href="https://lucide.dev/icons/" target="_blank" rel="noopener"
                                class="text-blue-600 hover:underline">lucide.dev/icons</a>
                        </p>
                        @error('icon')
                            <p class="mt-1.5 text-sm text-red-500 flex items-center gap-1">
                                <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between gap-4">
                    <a href="{{ route('admin.job-categories.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg shadow-sm transition-all cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Create Category
                    </button>
                </div>
            </div>
        </form>

        {{-- Tips Card --}}
        <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i data-lucide="lightbulb" class="w-4 h-4 text-blue-600"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-blue-900">Pro Tips</p>
                    <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                        <li>Use clear, descriptive names that job seekers will recognize</li>
                        <li>Keep category names short and consistent (e.g., "Engineering", not "Engineering Jobs")</li>
                        <li>Consider how categories will appear in filters and navigation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
