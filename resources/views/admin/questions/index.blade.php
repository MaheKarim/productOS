@extends('admin.layout')

@section('title', 'Questions')
@section('page-title', 'Questions')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8 relative">
        {{-- Background Decoration --}}
        <div
            class="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 blur-3xl -z-10 rounded-b-3xl">
        </div>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight font-sans">Question Bank</h1>
                <p class="mt-2 text-slate-600 text-lg">Manage and curate your assessment questions.</p>
            </div>
            <a href="{{ route('admin.questions.create') }}"
                class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-2xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-1 hover:shadow-orange-500/40 backdrop-blur-sm">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Add Question
            </a>
        </div>

        {{-- Stats Grid (Glassmorphism) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ([['label' => 'Total Questions', 'value' => $questions->total(), 'icon' => 'database', 'color' => 'blue'], ['label' => 'Easy', 'value' => $questions->where('difficulty', 'easy')->count(), 'icon' => 'smile', 'color' => 'teal'], ['label' => 'Medium', 'value' => $questions->where('difficulty', 'medium')->count(), 'icon' => 'meh', 'color' => 'amber'], ['label' => 'Hard', 'value' => $questions->where('difficulty', 'hard')->count(), 'icon' => 'frown', 'color' => 'red']] as $stat)
                <div
                    class="relative overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 rounded-3xl p-6 shadow-xl shadow-slate-200/50 group hover:bg-white/90 transition-all duration-300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-{{ $stat['color'] }}-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 bg-white/80 rounded-2xl flex items-center justify-center shadow-sm mb-4 text-{{ $stat['color'] }}-600">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <p class="text-slate-500 font-medium text-sm">{{ $stat['label'] }}</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1 font-sans">{{ $stat['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filters & Search (Glass Card) --}}
        <div class="bg-white/60 backdrop-blur-lg border border-white/50 rounded-3xl p-5 shadow-lg shadow-slate-200/40">
            <form action="{{ route('admin.questions.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                {{-- Search --}}
                <div class="flex-1 min-w-[240px]">
                    <div class="relative group">
                        <i data-lucide="search"
                            class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder:text-slate-400"
                            placeholder="Search questions...">
                    </div>
                </div>

                {{-- Select Filters --}}
                @foreach (['category' => ['options' => $categories, 'label' => 'name', 'placeholder' => 'All Categories'], 'difficulty' => ['options' => ['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard'], 'placeholder' => 'All Difficulties'], 'status' => ['options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'placeholder' => 'All Status']] as $name => $config)
                    <div class="relative min-w-[160px]">
                        <select name="{{ $name }}"
                            class="w-full px-4 py-3 bg-white/50 border border-slate-200/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer font-medium text-slate-700 appearance-none">
                            <option value="">{{ $config['placeholder'] }}</option>
                            @if ($name === 'category')
                                @foreach ($config['options'] as $option)
                                    <option value="{{ $option->id }}"
                                        {{ request($name) == $option->id ? 'selected' : '' }}>
                                        {{ $option->name }}
                                    </option>
                                @endforeach
                            @else
                                @foreach ($config['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ request($name) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <i data-lucide="chevron-down"
                            class="w-4 h-4 text-slate-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                @endforeach

                <button type="submit"
                    class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:scale-105 active:scale-95 cursor-pointer">
                    <i data-lucide="filter" class="w-5 h-5"></i>
                </button>

                @if (request()->hasAny(['search', 'category', 'difficulty', 'status']))
                    <a href="{{ route('admin.questions.index') }}"
                        class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors cursor-pointer"
                        title="Clear Filters">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- Content Table --}}
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl shadow-slate-200/50 overflow-hidden">
            @if ($questions->isEmpty())
                <div class="p-16 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                        <i data-lucide="search-x" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No questions found</h3>
                    <p class="text-slate-500 max-w-sm mb-8">Try adjusting your filters or create a new question to get
                        started.</p>
                    <a href="{{ route('admin.questions.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl transition-colors cursor-pointer">
                        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                        Add New Question
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-indigo-50/50 border-b border-indigo-100">
                            <tr>
                                @foreach (['Question', 'Source', 'Target', 'Categories', 'Info', 'Status', 'Actions'] as $header)
                                    <th
                                        class="px-6 py-5 text-left text-xs font-bold text-indigo-900/60 uppercase tracking-wider">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-50">
                            @foreach ($questions as $question)
                                @php
                                    $diffColors = ['easy' => 'teal', 'medium' => 'amber', 'hard' => 'red'];
                                    $diffColor = $diffColors[$question->difficulty] ?? 'slate';
                                @endphp
                                <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                    <td class="px-6 py-5 w-[35%]">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-2 h-2 rounded-full bg-{{ $diffColor }}-500 mt-2 flex-shrink-0">
                                            </div>
                                            <p
                                                class="text-slate-900 font-medium line-clamp-2 leading-relaxed group-hover:text-indigo-700 transition-colors">
                                                {{ $question->truncated_question }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        @if ($question->source)
                                            <div
                                                class="flex items-center gap-1.5 text-sm text-slate-600 bg-white/50 px-2 py-1 rounded-md border border-slate-100 inline-flex">
                                                <i data-lucide="link" class="w-3 h-3 text-slate-400"></i>
                                                {{ $question->source }}
                                            </div>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <span
                                            class="px-2 py-1 text-xs font-medium text-slate-600 bg-slate-100/80 rounded-lg whitespace-nowrap"
                                            title="{{ $question->question_for }}">
                                            {{ \Illuminate\Support\Str::limit($question->question_for ?? 'General', 20) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse ($question->categories as $category)
                                                <span
                                                    class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full border border-transparent transition-colors cursor-default hover:opacity-80"
                                                    style="background-color: {{ $category->color }}15; color: {{ $category->color }}; border-color: {{ $category->color }}30;">
                                                    {{ $category->name }}
                                                </span>
                                            @empty
                                                <span class="text-slate-400 text-xs italic">Uncategorized</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <div class="flex flex-col gap-1.5">
                                            <span class="inline-flex items-center gap-1.5 text-xs text-slate-500">
                                                <i data-lucide="list" class="w-3 h-3"></i>
                                                {{ $question->answers_count }} Opts
                                            </span>
                                            @if ($question->marks !== null)
                                                <span
                                                    class="inline-flex items-center gap-1.5 text-xs text-amber-600 font-medium">
                                                    <i data-lucide="award" class="w-3 h-3"></i>
                                                    {{ $question->marks }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        @if ($question->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-teal-50 text-teal-700 rounded-full border border-teal-100">
                                                <span class="relative flex h-2 w-2 mr-1.5">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                                                </span>
                                                Active
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-slate-100 text-slate-500 rounded-full border border-slate-200">
                                                <span class="w-2 h-2 bg-slate-400 rounded-full mr-1.5"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 align-top text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.questions.edit', $question) }}"
                                                class="p-2 bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 rounded-lg transition-all shadow-sm hover:shadow cursor-pointer"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.questions.destroy', $question) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this question?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-white border border-slate-200 text-slate-500 hover:text-red-600 hover:border-red-200 hover:bg-red-50 rounded-lg transition-all shadow-sm hover:shadow cursor-pointer"
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
                    <div class="px-6 py-6 border-t border-slate-100/50 bg-slate-50/30">
                        {{ $questions->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endpush
