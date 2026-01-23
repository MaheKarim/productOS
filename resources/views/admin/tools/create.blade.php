@extends('admin.layout')

@section('title', 'Create New Tool')
@section('page-title', 'Create New Tool')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.tools.index') }}" class="hover:text-indigo-600 transition-colors">Tools</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-slate-900 font-medium">Create New</span>
        </nav>

        <form action="{{ route('admin.tools.store') }}" method="POST" x-data="toolForm()" class="space-y-8">
            @csrf

            <!-- Basic Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-indigo-600"></i>
                        Basic Information
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Tool Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., CAC Calculator">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Category *</label>
                            <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Difficulty -->
                        <div>
                            <label for="difficulty" class="block text-sm font-bold text-slate-700 mb-2">Difficulty *</label>
                            <select id="difficulty" name="difficulty" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900">
                                <option value="Easy" {{ old('difficulty') == 'Easy' ? 'selected' : '' }}>Easy</option>
                                <option value="Medium" {{ old('difficulty', 'Medium') == 'Medium' ? 'selected' : '' }}>
                                    Medium</option>
                                <option value="Advanced" {{ old('difficulty') == 'Advanced' ? 'selected' : '' }}>Advanced
                                </option>
                            </select>
                        </div>

                        <!-- Time Estimate -->
                        <div>
                            <label for="time_estimate" class="block text-sm font-bold text-slate-700 mb-2">Time Estimate
                                *</label>
                            <input type="text" id="time_estimate" name="time_estimate"
                                value="{{ old('time_estimate', '5 mins') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., 5 mins">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Short
                            Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                            placeholder="Brief description of what this tool does...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                        <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                            Tool is active and visible on the website
                        </label>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-5 h-5 text-indigo-600"></i>
                        Full Content
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Markdown supported. This appears on the tool's detail page.</p>
                </div>
                <div class="p-6">
                    <textarea id="content" name="content" rows="12"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400 font-mono text-sm"
                        placeholder="## When to use this tool

Write detailed content about the tool here using Markdown...

### Benefits
- Benefit 1
- Benefit 2

### Formula
`Result = Input A / Input B`">{{ old('content') }}</textarea>
                </div>
            </div>

            <!-- Guidence Metadata Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="compass" class="w-5 h-5 text-indigo-600"></i>
                        Guidance Metadata
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Structured data for the tool sidebar.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Problem Solved -->
                        <div class="md:col-span-2">
                            <label for="problem_solved" class="block text-sm font-bold text-slate-700 mb-2">What Problem
                                This Solves</label>
                            <textarea id="problem_solved" name="problem_solved" rows="2"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., Helps quantify market opportunity size for investors.">{{ old('problem_solved') }}</textarea>
                        </div>

                        <!-- When to Use -->
                        <div>
                            <label for="when_to_use" class="block text-sm font-bold text-slate-700 mb-2">When to Use</label>
                            <textarea id="when_to_use" name="when_to_use" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., Early stage idea validation... ">{{ old('when_to_use') }}</textarea>
                        </div>

                        <!-- When NOT to Use -->
                        <div>
                            <label for="when_not_to_use" class="block text-sm font-bold text-slate-700 mb-2">When NOT to
                                Use</label>
                            <textarea id="when_not_to_use" name="when_not_to_use" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., If you have zero data...">{{ old('when_not_to_use') }}</textarea>
                        </div>

                        <!-- Data Required -->
                        <div>
                            <label for="data_required" class="block text-sm font-bold text-slate-700 mb-2">Data You'll
                                Need</label>
                            <textarea id="data_required" name="data_required" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., Total potential customers...">{{ old('data_required') }}</textarea>
                        </div>

                        <!-- Outcome -->
                        <div>
                            <label for="outcome" class="block text-sm font-bold text-slate-700 mb-2">What You'll
                                Get</label>
                            <textarea id="outcome" name="outcome" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 placeholder:text-slate-400"
                                placeholder="e.g., A clear dollar value for TAM...">{{ old('outcome') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQs Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="help-circle" class="w-5 h-5 text-indigo-600"></i>
                            Frequently Asked Questions
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">Add helpful Q&A pairs for this tool.</p>
                    </div>
                    <button type="button" @click="addFaq()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors cursor-pointer shadow-indigo-500/20 shadow-lg">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add Question
                    </button>
                </div>

                <div class="p-6">
                    <!-- Empty State -->
                    <div x-show="faqs.length === 0"
                        class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                        <div
                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-100">
                            <i data-lucide="message-circle-question" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h4 class="text-slate-900 font-bold mb-1">No FAQs Added</h4>
                        <p class="text-slate-500 text-sm mb-4">Start by adding common questions users might have.</p>
                        <button type="button" @click="addFaq()"
                            class="text-indigo-600 font-bold text-sm hover:text-indigo-700 cursor-pointer inline-flex items-center gap-1">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add First FAQ
                        </button>
                    </div>

                    <!-- FAQ List -->
                    <div class="space-y-4" x-show="faqs.length > 0">
                        <template x-for="(faq, index) in faqs" :key="index">
                            <div
                                class="group bg-white rounded-xl border border-slate-200 hover:border-indigo-200 hover:shadow-md transition-all duration-200 relative overflow-hidden">
                                <!-- Drag Handle / Index -->
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-1 bg-slate-200 group-hover:bg-indigo-500 transition-colors">
                                </div>

                                <div class="p-5 pl-7">
                                    <div class="flex items-start justify-between gap-6">
                                        <div class="flex-1 space-y-4">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Question</label>
                                                    <input type="text" :name="`faqs[${index}][question]`"
                                                        x-model="faq.question"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900 font-medium placeholder:text-slate-300 placeholder:font-normal"
                                                        placeholder="e.g. How is this calculated?">
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Answer</label>
                                                    <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="2"
                                                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-600 text-sm leading-relaxed placeholder:text-slate-300"
                                                        placeholder="Provide a clear, concise answer..."></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col gap-2 pt-6">
                                            <button type="button" @click="removeFaq(index)"
                                                class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                title="Remove FAQ">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                <a href="{{ route('admin.tools.index') }}"
                    class="px-6 py-3 text-slate-600 font-medium hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all hover:scale-[1.02] shadow-xl shadow-indigo-500/25 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    Create Tool
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function toolForm() {
                return {
                    faqs: [],
                    addFaq() {
                        this.faqs.push({
                            question: '',
                            answer: ''
                        });
                        // Re-initialize icons after DOM update
                        this.$nextTick(() => {
                            if (window.lucide) {
                                lucide.createIcons();
                            }
                        });
                    },
                    removeFaq(index) {
                        this.faqs.splice(index, 1);
                        // Re-initialize icons
                        this.$nextTick(() => {
                            if (window.lucide) {
                                lucide.createIcons();
                            }
                        });
                    }
                }
            }
        </script>
    @endpush
@endsection
