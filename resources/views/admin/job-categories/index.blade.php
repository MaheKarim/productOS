@extends('admin.layout')

@section('page-title', 'Job Categories')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-slate-500 text-sm">Categorize job listings for better organization.</p>
            </div>
            <a href="{{ route('admin.job-categories.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Add Category
            </a>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200/60 shadow-glass overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/50 border-b border-slate-200/60 text-xs uppercase tracking-widest text-slate-500 font-bold">
                            <th class="px-8 py-6">Name</th>
                            <th class="px-8 py-6">Slug</th>
                            <th class="px-8 py-6">Jobs Count</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5">
                                    <span
                                        class="font-bold text-slate-800 text-base font-display">{{ $category->name }}</span>
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500 font-mono">{{ $category->slug }}</td>
                                <td class="px-8 py-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                                        {{ $category->jobs_count }} Jobs
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.job-categories.edit', $category) }}"
                                            class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.job-categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-slate-500">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->hasPages())
                <div class="px-8 py-6 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
