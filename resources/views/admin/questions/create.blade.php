@extends('admin.layout')

@section('title', 'Create Question')
@section('page-title', 'Create Question')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.questions.index') }}"
                class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-4 transition-colors cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Questions
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Create New Question</h1>
            <p class="mt-1 text-slate-500">Add a new question with multiple answer options.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.questions.store') }}" method="POST" class="p-6 space-y-6" x-data="questionForm()">
                @csrf

                {{-- Question Text --}}
                <div>
                    <label for="question" class="block text-sm font-medium text-slate-700 mb-2">
                        Question <span class="text-red-500">*</span>
                    </label>
                    <textarea name="question" id="question" rows="3" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none"
                        placeholder="Enter your question here...">{{ old('question') }}</textarea>
                    @error('question')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Answers (Dynamic JSON Array) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Answer Options
                        <span class="text-slate-400 font-normal">(optional)</span>
                    </label>

                    <div class="space-y-3" id="answers-container">
                        <template x-for="(answer, index) in answers" :key="index">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-sm font-semibold"
                                    x-text="String.fromCharCode(65 + index)"></span>
                                <input type="text" :name="'answers[' + index + ']'" x-model="answers[index]"
                                    class="flex-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                                    placeholder="Enter answer option">
                                <button type="button" @click="removeAnswer(index)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                    :class="{ 'opacity-50 cursor-not-allowed': answers.length <= 2 }"
                                    :disabled="answers.length <= 2">
                                    <i data-lucide="x" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addAnswer()"
                        class="mt-3 inline-flex items-center px-4 py-2 text-sm text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                        :class="{ 'opacity-50 cursor-not-allowed': answers.length >= 6 }" :disabled="answers.length >= 6">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Add Answer Option
                    </button>

                    @error('answers')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('answers.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correct Answer (Multiple Select) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Correct Answer(s)
                        <span class="text-slate-400 font-normal">(select one or more)</span>
                    </label>
                    <div class="space-y-2" x-show="answers.some(a => a.trim() !== '')">
                        <template x-for="(answer, index) in answers" :key="'correct-' + index">
                            <label x-show="answer.trim() !== ''"
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl hover:border-teal-300 hover:bg-teal-50/50 transition-colors cursor-pointer">
                                <input type="checkbox" :name="'correct_answer[]'" :value="answer"
                                    class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                                <span class="flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 bg-indigo-50 text-indigo-600 rounded flex items-center justify-center text-xs font-semibold"
                                        x-text="String.fromCharCode(65 + index)"></span>
                                    <span class="text-sm text-slate-700" x-text="answer"></span>
                                </span>
                            </label>
                        </template>
                    </div>
                    <p x-show="!answers.some(a => a.trim() !== '')" class="text-sm text-slate-400 italic">
                        Add answer options above to select correct answers
                    </p>
                    @error('correct_answer')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categories --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Categories <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($categories as $category)
                            <label
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50/50 transition-colors cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <span class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full"
                                        style="background-color: {{ $category->color }};"></span>
                                    <span class="text-sm font-medium text-slate-700">{{ $category->name }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Difficulty --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Difficulty Level <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="difficulty" value="easy" class="peer sr-only"
                                {{ old('difficulty', 'medium') == 'easy' ? 'checked' : '' }}>
                            <div
                                class="p-4 border border-slate-200 rounded-xl text-center peer-checked:border-teal-500 peer-checked:bg-teal-50 transition-all hover:border-teal-300">
                                <i data-lucide="smile" class="w-6 h-6 mx-auto mb-2 text-teal-600"></i>
                                <p class="font-medium text-slate-700">Easy</p>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="difficulty" value="medium" class="peer sr-only"
                                {{ old('difficulty', 'medium') == 'medium' ? 'checked' : '' }}>
                            <div
                                class="p-4 border border-slate-200 rounded-xl text-center peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all hover:border-amber-300">
                                <i data-lucide="meh" class="w-6 h-6 mx-auto mb-2 text-amber-600"></i>
                                <p class="font-medium text-slate-700">Medium</p>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="difficulty" value="hard" class="peer sr-only"
                                {{ old('difficulty', 'medium') == 'hard' ? 'checked' : '' }}>
                            <div
                                class="p-4 border border-slate-200 rounded-xl text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-red-300">
                                <i data-lucide="frown" class="w-6 h-6 mx-auto mb-2 text-red-600"></i>
                                <p class="font-medium text-slate-700">Hard</p>
                            </div>
                        </label>
                    </div>
                    @error('difficulty')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Explanation --}}
                <div>
                    <label for="explanation" class="block text-sm font-medium text-slate-700 mb-2">
                        Explanation <span class="text-slate-400">(optional)</span>
                    </label>
                    <textarea name="explanation" id="explanation" rows="3"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none"
                        placeholder="Explain why this is the correct answer...">{{ old('explanation') }}</textarea>
                    @error('explanation')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Status --}}
                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                        class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                        Active <span class="text-slate-500">(make this question available)</span>
                    </label>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.questions.index') }}"
                        class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium transition-colors cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                        Create Question
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function questionForm() {
            return {
                answers: ['', ''],
                correctAnswer: '',

                addAnswer() {
                    if (this.answers.length < 6) {
                        this.answers.push('');
                        this.$nextTick(() => lucide.createIcons());
                    }
                },

                removeAnswer(index) {
                    if (this.answers.length > 2) {
                        this.answers.splice(index, 1);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endpush
