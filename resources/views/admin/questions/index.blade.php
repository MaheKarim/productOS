@extends('admin.layout')

@section('title', 'Questions')
@section('page-title', 'Questions')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Question Bank</h1>
                <p class="mt-1 text-slate-500">Manage all your questions with categories and difficulty levels.</p>
            </div>
            <a href="{{ route('admin.questions.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Add Question
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6">
            <form action="{{ route('admin.questions.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                {{-- Search --}}
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            placeholder="Search questions...">
                    </div>
                </div>

                {{-- Category Filter --}}
                <select name="category"
                    class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Difficulty Filter --}}
                <select name="difficulty"
                    class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="">All Difficulties</option>
                    <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>

                {{-- Status Filter --}}
                <select name="status"
                    class="px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>

                <button type="submit"
                    class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors cursor-pointer">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>

                @if (request()->hasAny(['search', 'category', 'difficulty', 'status']))
                    <a href="{{ route('admin.questions.index') }}"
                        class="px-4 py-2.5 text-slate-500 hover:text-slate-700 font-medium transition-colors cursor-pointer">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="help-circle" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Total</p>
                        <p class="text-xl font-bold text-slate-900">{{ $questions->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="smile" class="w-5 h-5 text-teal-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Easy</p>
                        <p class="text-xl font-bold text-teal-600">{{ $questions->where('difficulty', 'easy')->count() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="meh" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Medium</p>
                        <p class="text-xl font-bold text-amber-600">
                            {{ $questions->where('difficulty', 'medium')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="frown" class="w-5 h-5 text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Hard</p>
                        <p class="text-xl font-bold text-red-600">{{ $questions->where('difficulty', 'hard')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Questions Table --}}
        @if ($questions->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="message-circle-question" class="w-8 h-8 text-slate-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 mb-2">No questions found</h3>
                <p class="text-slate-500 mb-6">Create your first question to get started.</p>
                <a href="{{ route('admin.questions.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Create Question
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/2">
                                    Question</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Categories</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Answers</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Difficulty</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($questions as $question)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-slate-900 font-medium line-clamp-2">
                                            {{ $question->truncated_question }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse ($question->categories as $category)
                                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full"
                                                    style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                                                    {{ $category->name }}
                                                </span>
                                            @empty
                                                <span class="text-slate-400 text-sm">No categories</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg">
                                            {{ $question->answers_count }} options
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $question->difficulty_color }}">
                                            {{ ucfirst($question->difficulty) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($question->is_active)
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
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('admin.questions.show', $question) }}"
                                                class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                                title="View">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('admin.questions.edit', $question) }}"
                                                class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.questions.toggle', $question) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer"
                                                    title="{{ $question->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i data-lucide="{{ $question->is_active ? 'eye-off' : 'eye' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.questions.destroy', $question) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this question?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                    title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($questions->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $questions->withQueryString()->links() }}
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
