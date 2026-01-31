@extends('admin.layout')

@section('title', 'Question Categories')
@section('page-title', 'Question Categories')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Question Categories</h1>
                <p class="mt-1 text-slate-500">Organize your questions into categories for better management.</p>
            </div>
            <a href="{{ route('admin.question-categories.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Add Category
            </a>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Categories</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $categories->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="folder-tree" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Active</p>
                        <p class="text-2xl font-bold text-teal-600">{{ $categories->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-teal-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Questions</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $categories->sum('questions_count') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="help-circle" class="w-6 h-6 text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Categories Grid --}}
        @if ($categories->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="folder-plus" class="w-8 h-8 text-slate-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">No categories yet</h3>
                <p class="text-slate-500 mb-6">Create your first category to start organizing questions.</p>
                <a href="{{ route('admin.question-categories.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Create Category
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Questions</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition-colors cursor-pointer">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                            style="background-color: {{ $category->color }}20;">
                                            <i data-lucide="folder" class="w-5 h-5"
                                                style="color: {{ $category->color }};"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $category->name }}</p>
                                            <p class="text-sm text-slate-500">{{ $category->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">
                                        {{ $category->questions_count }} questions
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($category->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-1.5"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.question-categories.edit', $category) }}"
                                            class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.question-categories.destroy', $category) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endpush
