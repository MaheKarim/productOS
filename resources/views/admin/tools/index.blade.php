@extends('admin.layout')

@section('title', 'Tools Management')
@section('page-title', 'Tools Management')

@section('content')
    <div class="space-y-8">
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tools</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $tools->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="calculator" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $tools->where('is_active', true)->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-emerald-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Inactive</p>
                        <p class="text-3xl font-bold text-amber-600 mt-1">{{ $tools->where('is_active', false)->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="pause-circle" class="w-6 h-6 text-amber-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Categories</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $categories->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="folder" class="w-6 h-6 text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tools Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">All Tools</h3>
                    <p class="text-sm text-slate-500 mt-1">Manage calculator tools and their content</p>
                </div>
                <a href="{{ route('admin.tools.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/25">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add New Tool
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tool
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Category</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Difficulty</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">FAQs
                            </th>
                            <th class="text-center px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Status</th>
                            <th class="text-right px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($tools as $tool)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl flex items-center justify-center
                                            @if ($tool->category->name == 'Strategy & Validation') bg-emerald-100
                                            @elseif($tool->category->name == 'SaaS Metrics') bg-blue-100
                                            @elseif($tool->category->name == 'Prioritization') bg-purple-100
                                            @elseif($tool->category->name == 'Validation & Research') bg-amber-100
                                            @elseif($tool->category->name == 'Execution & Delivery') bg-orange-100
                                            @elseif($tool->category->name == 'Growth & Engagement') bg-rose-100
                                            @else bg-slate-100 @endif
                                        ">
                                            <i data-lucide="calculator"
                                                class="w-5 h-5 
                                                @if ($tool->category->name == 'Strategy & Validation') text-emerald-600
                                                @elseif($tool->category->name == 'SaaS Metrics') text-blue-600
                                                @elseif($tool->category->name == 'Prioritization') text-purple-600
                                                @elseif($tool->category->name == 'Validation & Research') text-amber-600
                                                @elseif($tool->category->name == 'Execution & Delivery') text-orange-600
                                                @elseif($tool->category->name == 'Growth & Engagement') text-rose-600
                                                @else text-slate-600 @endif
                                            "></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $tool->name }}</p>
                                            <p class="text-xs text-slate-500">
                                                {{ $tool->time_estimate }}
                                                @if ($tool->custom_url)
                                                    <br><span class="text-indigo-600 font-medium">→
                                                        {{ $tool->custom_url }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700">
                                        {{ $tool->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium
                                        @if ($tool->difficulty == 'Easy') bg-emerald-100 text-emerald-700
                                        @elseif($tool->difficulty == 'Medium') bg-amber-100 text-amber-700
                                        @else bg-red-100 text-red-700 @endif
                                    ">
                                        {{ $tool->difficulty }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                                        <i data-lucide="help-circle" class="w-4 h-4"></i>
                                        {{ is_array($tool->faqs) ? count($tool->faqs) : 0 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.tools.toggle', $tool) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="cursor-pointer">
                                            @if ($tool->is_active)
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]) }}"
                                            target="_blank"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                            title="View">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.tools.edit', $tool) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                            title="Edit">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.tools.destroy', $tool) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this tool?')">
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
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="calculator" class="w-8 h-8 text-slate-400"></i>
                                        </div>
                                        <p class="text-slate-600 font-medium">No tools found</p>
                                        <p class="text-slate-400 text-sm mt-1">Get started by creating your first tool</p>
                                        <a href="{{ route('admin.tools.create') }}"
                                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                            Create Tool
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Categories Overview -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Categories Overview</h3>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <div
                        class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-center hover:border-indigo-200 hover:bg-indigo-50/30 transition-colors cursor-pointer">
                        <p class="text-2xl font-bold text-slate-900">{{ $category->tools_count }}</p>
                        <p class="text-xs text-slate-500 mt-1 truncate">{{ $category->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
