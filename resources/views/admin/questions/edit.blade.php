@extends('admin.layout')

@section('title', 'Edit Question')
@section('page-title', 'Edit Question')

@section('content')
    <div class="max-w-4xl mx-auto relative">
        {{-- Background Decoration --}}
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-96 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 blur-3xl -z-10 rounded-b-3xl">
        </div>

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.questions.index') }}"
                    class="inline-flex items-center text-slate-500 hover:text-indigo-600 mb-2 transition-colors cursor-pointer group">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Back to Questions
                </a>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight font-sans">Edit Question</h1>
            </div>
            <div class="hidden sm:block">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                    ID: {{ $question->id }}
                </span>
            </div>
        </div>

        {{-- Form Card --}}
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl shadow-slate-200/50 overflow-hidden">
            <form action="{{ route('admin.questions.update', $question) }}" method="POST" class="p-8 space-y-8"
                x-data="questionForm()">
                @csrf
                @method('PUT')

                {{-- Question Text --}}
                <div class="space-y-2">
                    <label for="question" class="block text-sm font-semibold text-slate-800">
                        Question <span class="text-red-500">*</span>
                    </label>
                    <textarea name="question" id="question" rows="3" required
                        class="w-full px-5 py-4 bg-white/50 border border-slate-200/60 rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none shadow-sm"
                        placeholder="Enter your question here...">{{ old('question', $question->question) }}</textarea>
                    @error('question')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Source --}}
                    <div class="space-y-2">
                        <label for="source" class="block text-sm font-semibold text-slate-800">
                            Source <span class="text-slate-400 font-normal ml-1">(Optional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="link" class="h-4 w-4 text-slate-400"></i>
                            </div>
                            <input type="text" name="source" id="source"
                                class="w-full pl-11 pr-5 py-3.5 bg-white/50 border border-slate-200/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                                placeholder="e.g. Interview Bit, LeetCode" value="{{ old('source', $question->source) }}">
                        </div>
                        @error('source')
                            <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Marks --}}
                    <div class="space-y-2">
                        <label for="marks" class="block text-sm font-semibold text-slate-800">
                            Marks <span class="text-slate-400 font-normal ml-1">(0-10)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="award" class="h-4 w-4 text-slate-400"></i>
                            </div>
                            <input type="number" name="marks" id="marks" min="0" max="10"
                                class="w-full pl-11 pr-5 py-3.5 bg-white/50 border border-slate-200/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                                placeholder="e.g. 5" value="{{ old('marks', $question->marks) }}">
                        </div>
                        @error('marks')
                            <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Question For --}}
                <div class="space-y-2">
                    <label for="question_for" class="block text-sm font-semibold text-slate-800">
                        Target Audience <span class="text-slate-400 font-normal ml-1">(Optional)</span>
                    </label>
                    <div class="relative">
                        <select name="question_for" id="question_for"
                            class="w-full px-5 py-3.5 bg-white/50 border border-slate-200/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer appearance-none shadow-sm">
                            <option value="">Select Target Audience</option>
                            <option value="New to PM (Less than 2 years experience)"
                                {{ old('question_for', $question->question_for) == 'New to PM (Less than 2 years experience)' ? 'selected' : '' }}>
                                New to PM (< 2 years)</option>
                            <option value="Experienced PM (2-5 years experience)"
                                {{ old('question_for', $question->question_for) == 'Experienced PM (2-5 years experience)' ? 'selected' : '' }}>
                                Experienced PM (2-5 years)</option>
                            <option value="Senior PM / Founder (5+ years or leading a startup)"
                                {{ old('question_for', $question->question_for) == 'Senior PM / Founder (5+ years or leading a startup)' ? 'selected' : '' }}>
                                Senior PM / Founder (5+ years)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>
                    @error('question_for')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Categories --}}
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-800">
                        Categories <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @php
                            $selectedCategories = old('categories', $question->categories->pluck('id')->toArray());
                        @endphp
                        @foreach ($categories as $category)
                            <label
                                class="relative flex items-center gap-3 p-3.5 bg-white/40 border border-slate-200/60 rounded-xl hover:border-indigo-300 hover:bg-white/80 transition-all cursor-pointer group">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"
                                    {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                <span class="flex items-center gap-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full ring-2 ring-white"
                                        style="background-color: {{ $category->color }}; box-shadow: 0 0 8px {{ $category->color }}40;"></span>
                                    <span
                                        class="text-sm font-medium text-slate-700 group-hover:text-slate-900">{{ $category->name }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Difficulty --}}
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-800">
                        Difficulty Level <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach (['easy' => ['color' => 'teal', 'icon' => 'smile'], 'medium' => ['color' => 'amber', 'icon' => 'meh'], 'hard' => ['color' => 'red', 'icon' => 'frown']] as $level => $config)
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty" value="{{ $level }}" class="peer sr-only"
                                    {{ old('difficulty', $question->difficulty) == $level ? 'checked' : '' }}>
                                <div
                                    class="p-4 bg-white/40 border border-slate-200/60 rounded-2xl text-center transition-all hover:bg-white/80 peer-checked:bg-white peer-checked:border-{{ $config['color'] }}-500 peer-checked:ring-2 peer-checked:ring-{{ $config['color'] }}-500/20 peer-checked:shadow-lg peer-checked:shadow-{{ $config['color'] }}-500/10">
                                    <div
                                        class="w-10 h-10 mx-auto mb-2 rounded-full bg-{{ $config['color'] }}-50 flex items-center justify-center text-{{ $config['color'] }}-600 transition-colors">
                                        <i data-lucide="{{ $config['icon'] }}" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-semibold text-slate-700 capitalize">{{ $level }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('difficulty')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Question Type (ReadOnly for Edit to avoid data loss issues, or editable if careful) --}}
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-800">
                        Question Type
                    </label>
                    <input type="hidden" name="type" x-model="type">
                    <div class="flex gap-4">
                        <div class="flex-1 p-4 border rounded-xl text-center transition-all bg-white/40 border-slate-200/60"
                            :class="type === 'mcq' ?
                                'border-indigo-500 bg-indigo-50 shadow-md ring-1 ring-indigo-500/20' : 'opacity-50'">
                            <p class="font-medium text-slate-700">Multiple Choice (MCQ)</p>
                        </div>
                        <div class="flex-1 p-4 border rounded-xl text-center transition-all bg-white/40 border-slate-200/60"
                            :class="type === 'cq' ?
                                'border-purple-500 bg-purple-50 shadow-md ring-1 ring-purple-500/20' : 'opacity-50'">
                            <p class="font-medium text-slate-700">Written / Creative (CQ)</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Question type cannot be changed after creation.</p>
                </div>

                {{-- MCQ: Answers (Dynamic JSON Array) --}}
                <div x-show="type === 'mcq'" x-transition class="space-y-4 pt-4 border-t border-slate-200/50">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-semibold text-slate-800">
                            Answer Options <span class="text-slate-400 font-normal ml-1">(Optional)</span>
                        </label>
                        <button type="button" @click="addAnswer()"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors cursor-pointer"
                            :class="{ 'opacity-50 cursor-not-allowed': answers.length >= 6 }"
                            :disabled="answers.length >= 6">
                            <i data-lucide="plus" class="w-4 h-4 mr-1.5"></i>
                            Add Option
                        </button>
                    </div>

                    <div class="space-y-4" id="answers-container">
                        <template x-for="(answer, index) in answers" :key="index">
                            <div
                                class="group relative flex items-start gap-3 p-4 bg-slate-50/50 rounded-2xl border border-transparent hover:border-slate-200 transition-all">
                                <span
                                    class="w-8 h-8 mt-1.5 bg-white text-indigo-600 rounded-lg shadow-sm border border-slate-100 flex items-center justify-center text-sm font-bold"
                                    x-text="String.fromCharCode(65 + index)"></span>
                                <div class="flex-1 space-y-3">
                                    <input type="text" :name="'answers[' + index + ']'" x-model="answers[index]"
                                        class="w-full px-4 py-3 bg-white border border-slate-200/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                                        placeholder="Enter answer option text">
                                </div>

                                <button type="button" @click="removeAnswer(index)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors opacity-0 group-hover:opacity-100 cursor-pointer"
                                    :class="{
                                        'opacity-50 cursor-not-allowed': answers.length <=
                                            2,
                                        'opacity-100': answers.length > 2
                                    }"
                                    :disabled="answers.length <= 2" title="Remove option">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    @error('answers')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- MCQ: Correct Answer (Multiple Select) --}}
                <div x-show="type === 'mcq'" class="space-y-3 pt-4 border-t border-slate-200/50">
                    <label class="block text-sm font-semibold text-slate-800">
                        Correct Answer(s) <span class="text-slate-400 font-normal ml-1">(Select one or more)</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" x-show="answers.some(a => a.trim() !== '')">
                        <template x-for="(answer, index) in answers" :key="'correct-' + index">
                            <label x-show="answer.trim() !== ''"
                                class="flex items-center gap-3 p-3 bg-white/50 border border-slate-200/60 rounded-xl hover:border-teal-400 hover:bg-teal-50/30 transition-all cursor-pointer group">
                                <input type="checkbox" name="correct_answer[]" :value="answer"
                                    :checked="correctAnswers.includes(answer)"
                                    class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                                <span class="flex items-center gap-2">
                                    <span
                                        class="w-6 h-6 bg-indigo-50 text-indigo-600 rounded flex items-center justify-center text-xs font-bold"
                                        x-text="String.fromCharCode(65 + index)"></span>
                                    <span class="text-sm text-slate-700 font-medium break-all line-clamp-1"
                                        x-text="answer"></span>
                                </span>
                            </label>
                        </template>
                    </div>
                    <p x-show="!answers.some(a => a.trim() !== '')"
                        class="text-sm text-slate-400 italic flex items-center">
                        <i data-lucide="info" class="w-4 h-4 mr-2"></i>
                        Enter answer options above to select correct answers.
                    </p>
                    @error('correct_answer')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CQ: Model Answer --}}
                <div x-show="type === 'cq'" x-transition class="space-y-4 pt-4 border-t border-slate-200/50">
                    <label class="block text-sm font-semibold text-slate-800">
                        Model Answer / Key Points
                        <span class="text-slate-400 font-normal">(AI uses this to grade)</span>
                    </label>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <textarea name="correct_answer[]" rows="4"
                                class="flex-1 px-4 py-3 bg-white border border-slate-200/80 rounded-xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all resize-none shadow-sm"
                                placeholder="Enter the ideal answer or key points...">{{ $question->correct_answer[0] ?? '' }}</textarea>
                        </div>
                        <p class="text-sm text-slate-500">Provide a comprehensive model answer or a list of key points the
                            AI should look for.</p>
                    </div>
                </div>

                {{-- Explanation --}}
                <div class="space-y-2 pt-4 border-t border-slate-200/50">
                    <label for="explanation" class="block text-sm font-semibold text-slate-800">
                        Explanation <span class="text-slate-400 font-normal ml-1">(Optional)</span>
                    </label>
                    <textarea name="explanation" id="explanation" rows="3"
                        class="w-full px-5 py-4 bg-white/50 border border-slate-200/60 rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none shadow-sm"
                        placeholder="Explain why the answer is correct...">{{ old('explanation', $question->explanation) }}</textarea>
                    @error('explanation')
                        <p class="text-sm text-red-600 pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Status --}}
                <div class="flex items-center gap-4 p-5 bg-white/60 border border-slate-200/60 rounded-2xl">
                    <div class="flex-1">
                        <label for="is_active" class="block text-sm font-bold text-slate-900 cursor-pointer">
                            Active Status
                        </label>
                        <p class="text-xs text-slate-500">Enable to make this question visible in assessments.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="sr-only peer"
                            {{ $question->is_active ? 'checked' : '' }}>
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600">
                        </div>
                    </label>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-4 pt-6 mt-8 border-t border-slate-200/60">
                    <a href="{{ route('admin.questions.index') }}"
                        class="px-6 py-3 text-slate-600 hover:text-slate-900 font-medium hover:bg-slate-50/50 rounded-xl transition-all cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 active:scale-95 cursor-pointer">
                        Update Changes
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
                type: @json($question->type ?? 'mcq'),
                answers: @json(old('answers', $question->answers ?? ['', ''])),
                correctAnswers: @json(old('correct_answer', $question->correct_answer ?? [])),

                addAnswer() {
                    if (this.answers.length < 6) {
                        this.answers.push('');
                        this.$nextTick(() => lucide.createIcons());
                    }
                },

                removeAnswer(index) {
                    if (this.answers.length > 2) {
                        this.answers.splice(index, 1);
                        // Also remove from correct answers if it was selected
                        // Note: complex logic if we rely on value, simpler to just let user re-select if content changes
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endpush
