@extends('admin.layout')

@section('title', 'Prompt Library')

@section('content')
    <div class="px-8 py-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Prompt Library</h1>
                <p class="text-slate-500 mt-1">Manage AI prompts for Product Managers</p>
            </div>
            <a href="{{ route('admin.prompts.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add New Prompt
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
            <form action="{{ route('admin.prompts.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search prompts..."
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Category Filter --}}
                <div class="w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                    <select name="category"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter --}}
                <div class="w-36">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published
                        </option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                {{-- AI Tool Filter --}}
                <div class="w-36">
                    <label class="block text-sm font-medium text-slate-700 mb-1">AI Tool</label>
                    <select name="ai_tool"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">All Tools</option>
                        <option value="chatgpt" {{ request('ai_tool') == 'chatgpt' ? 'selected' : '' }}>ChatGPT</option>
                        <option value="claude" {{ request('ai_tool') == 'claude' ? 'selected' : '' }}>Claude</option>
                        <option value="gemini" {{ request('ai_tool') == 'gemini' ? 'selected' : '' }}>Gemini</option>
                        <option value="universal" {{ request('ai_tool') == 'universal' ? 'selected' : '' }}>Universal
                        </option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition cursor-pointer">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                    <a href="{{ route('admin.prompts.index') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition cursor-pointer">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <div class="text-2xl font-bold text-slate-800">{{ \App\Models\Prompt::count() }}</div>
                <div class="text-sm text-slate-500">Total Prompts</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <div class="text-2xl font-bold text-emerald-600">{{ \App\Models\Prompt::published()->count() }}</div>
                <div class="text-sm text-slate-500">Published</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <div class="text-2xl font-bold text-amber-600">{{ \App\Models\Prompt::featured()->count() }}</div>
                <div class="text-sm text-slate-500">Featured</div>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200">
                <div class="text-2xl font-bold text-blue-600">{{ \App\Models\Prompt::sum('copy_count') }}</div>
                <div class="text-sm text-slate-500">Total Copies</div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Prompt</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Tool</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Stats</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($prompts as $prompt)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div>
                                        <div class="font-medium text-slate-800 flex items-center gap-2">
                                            {{ Str::limit($prompt->title, 40) }}
                                            @if ($prompt->is_featured)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                    <i data-lucide="star" class="w-3 h-3 mr-1 fill-current"></i> Featured
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">{{ Str::limit($prompt->description, 60) }}
                                        </div>
                                        @if ($prompt->use_case_tags)
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                @foreach (array_slice($prompt->use_case_tags ?? [], 0, 3) as $tag)
                                                    <span
                                                        class="px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded-full">
                                                        {{ $tag }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">
                                    {{ $prompt->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                    {{ $prompt->ai_tool === 'chatgpt' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $prompt->ai_tool === 'claude' ? 'bg-orange-50 text-orange-700' : '' }}
                                    {{ $prompt->ai_tool === 'gemini' ? 'bg-purple-50 text-purple-700' : '' }}
                                    {{ $prompt->ai_tool === 'universal' ? 'bg-slate-100 text-slate-700' : '' }}">
                                    {{ $prompt->ai_tool_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($prompt->status === 'published')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                        Published
                                    </span>
                                @elseif ($prompt->status === 'draft')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                        Draft
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>
                                        Archived
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-4 text-xs text-slate-500">
                                    <span title="Views" class="flex items-center gap-1">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        {{ number_format($prompt->view_count) }}
                                    </span>
                                    <span title="Copies" class="flex items-center gap-1">
                                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                        {{ number_format($prompt->copy_count) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end items-center gap-1">
                                    {{-- Toggle Featured --}}
                                    <form action="{{ route('admin.prompts.feature', $prompt) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 rounded-lg transition cursor-pointer {{ $prompt->is_featured ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-slate-400 hover:text-amber-600 hover:bg-slate-100' }}"
                                            title="{{ $prompt->is_featured ? 'Remove from featured' : 'Add to featured' }}">
                                            <i data-lucide="star"
                                                class="w-4 h-4 {{ $prompt->is_featured ? 'fill-current' : '' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Toggle Status --}}
                                    <form action="{{ route('admin.prompts.toggle', $prompt) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 rounded-lg transition cursor-pointer {{ $prompt->status === 'published' ? 'text-emerald-600 hover:bg-emerald-50' : 'text-slate-400 hover:text-emerald-600 hover:bg-slate-100' }}"
                                            title="{{ $prompt->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                            <i data-lucide="{{ $prompt->status === 'published' ? 'eye' : 'eye-off' }}"
                                                class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- Duplicate --}}
                                    <form action="{{ route('admin.prompts.duplicate', $prompt) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition cursor-pointer"
                                            title="Duplicate">
                                            <i data-lucide="copy-plus" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.prompts.edit', $prompt) }}"
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition cursor-pointer"
                                        title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.prompts.destroy', $prompt) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this prompt?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer"
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
                                    <i data-lucide="file-text" class="w-12 h-12 text-slate-300 mb-3"></i>
                                    <p class="text-slate-500 font-medium">No prompts found</p>
                                    <p class="text-slate-400 text-sm mt-1">Try adjusting your filters or create a new
                                        prompt.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($prompts->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $prompts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
