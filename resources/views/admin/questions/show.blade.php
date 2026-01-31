@extends('admin.layout')

@section('title', 'View Question')
@section('page-title', 'View Question')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.questions.index') }}"
                    class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-4 transition-colors cursor-pointer">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Questions
                </a>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Question Details</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.questions.edit', $question) }}"
                    class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors cursor-pointer">
                    <i data-lucide="pencil" class="w-4 h-4 mr-2"></i>
                    Edit
                </a>
            </div>
        </div>

        {{-- Question Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-6">
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span
                                class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $question->difficulty_color }}">
                                {{ ucfirst($question->difficulty) }}
                            </span>
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
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900 leading-relaxed">{{ $question->question }}</h2>
                    </div>
                </div>
            </div>

            {{-- Categories --}}
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Categories</p>
                <div class="flex flex-wrap gap-2">
                    @forelse ($question->categories as $category)
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full"
                            style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                            <span class="w-2 h-2 rounded-full mr-2"
                                style="background-color: {{ $category->color }};"></span>
                            {{ $category->name }}
                        </span>
                    @empty
                        <span class="text-slate-400 text-sm">No categories assigned</span>
                    @endforelse
                </div>
            </div>

            {{-- Answer Options --}}
            <div class="p-6">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Answer Options</p>
                <div class="space-y-3">
                    @forelse ($question->answers ?? [] as $index => $answer)
                        @php
                            $correctAnswers = $question->correct_answer ?? [];
                            $isCorrect = is_array($correctAnswers) && in_array($answer, $correctAnswers);
                        @endphp
                        <div
                            class="flex items-center gap-4 p-4 rounded-xl transition-colors {{ $isCorrect ? 'bg-teal-50 border border-teal-200' : 'bg-slate-50 border border-slate-100' }}">
                            <span
                                class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold {{ $isCorrect ? 'bg-teal-500 text-white' : 'bg-white text-slate-600 shadow-sm' }}">
                                {{ chr(65 + $index) }}
                            </span>
                            <span class="flex-1 {{ $isCorrect ? 'text-teal-900 font-medium' : 'text-slate-700' }}">
                                {{ $answer }}
                            </span>
                            @if ($isCorrect)
                                <span
                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold bg-teal-500 text-white rounded-full">
                                    <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                                    Correct
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-400 italic">No answer options provided</p>
                    @endforelse
                </div>
            </div>

            {{-- Explanation --}}
            @if ($question->explanation)
                <div class="px-6 py-4 bg-amber-50 border-t border-amber-100">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="lightbulb" class="w-4 h-4 text-amber-600"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider mb-1">Explanation</p>
                            <p class="text-sm text-amber-900">{{ $question->explanation }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Metadata --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-6 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <span>Created: {{ $question->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <span>Updated: {{ $question->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- JSON Preview --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-900">JSON Data Preview</h3>
            </div>
            <div class="p-6">
                <pre class="bg-slate-900 text-slate-100 p-4 rounded-xl text-sm overflow-x-auto"><code>{{ json_encode(
                    [
                        'id' => $question->id,
                        'question' => $question->question,
                        'answers' => $question->answers,
                        'correct_answer' => $question->correct_answer,
                        'difficulty' => $question->difficulty,
                        'categories' => $question->categories->pluck('name'),
                    ],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE,
                ) }}</code></pre>
            </div>
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
