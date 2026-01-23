@extends('admin.layout')

@section('title', 'Edit Tool - ' . $tool->name)
@section('page-title', 'Edit Tool')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.tools.index') }}" class="hover:text-indigo-600 transition-colors">Tools</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-slate-900 font-medium">Edit: {{ $tool->name }}</span>
        </nav>

        <form action="{{ route('admin.tools.update', $tool) }}" method="POST" x-data="toolForm()" class="space-y-8">
            @csrf
            @method('PUT')

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
                            <input type="text" id="name" name="name" value="{{ old('name', $tool->name) }}"
                                required
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
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $tool->category_id) == $category->id ? 'selected' : '' }}>
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
                                <option value="Easy"
                                    {{ old('difficulty', $tool->difficulty) == 'Easy' ? 'selected' : '' }}>Easy</option>
                                <option value="Medium"
                                    {{ old('difficulty', $tool->difficulty) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Advanced"
                                    {{ old('difficulty', $tool->difficulty) == 'Advanced' ? 'selected' : '' }}>Advanced
                                </option>
                            </select>
                        </div>

                        <!-- Time Estimate -->
                        <div>
                            <label for="time_estimate" class="block text-sm font-bold text-slate-700 mb-2">Time Estimate
                                *</label>
                            <input type="text" id="time_estimate" name="time_estimate"
                                value="{{ old('time_estimate', $tool->time_estimate) }}" required
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
                            placeholder="Brief description of what this tool does...">{{ old('description', $tool->description) }}</textarea>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $tool->is_active) ? 'checked' : '' }}
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
`Result = Input A / Input B`">{{ old('content', $tool->content) }}</textarea>
                </div>
            </div>

            <!-- FAQs Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i data-lucide="help-circle" class="w-5 h-5 text-indigo-600"></i>
                            Frequently Asked Questions
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">Add FAQ items that appear on the tool's page</p>
                    </div>
                    <button type="button" @click="addFaq()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add FAQ
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="(faq, index) in faqs" :key="index">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Question</label>
                                        <input type="text" :name="`faqs[${index}][question]`" x-model="faq.question"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900"
                                            placeholder="e.g., How often should I calculate this?">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Answer</label>
                                        <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="3"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all text-slate-900"
                                            placeholder="Provide a detailed answer..."></textarea>
                                    </div>
                                </div>
                                <button type="button" @click="removeFaq(index)"
                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer mt-6">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div x-show="faqs.length === 0" class="text-center py-8">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="help-circle" class="w-6 h-6 text-slate-400"></i>
                        </div>
                        <p class="text-slate-500 text-sm">No FAQs added yet</p>
                        <button type="button" @click="addFaq()"
                            class="mt-3 text-indigo-600 font-medium text-sm hover:text-indigo-700 cursor-pointer">
                            + Add your first FAQ
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.tools.index') }}"
                    class="px-6 py-3 text-slate-600 font-medium hover:text-slate-900 transition-colors">
                    Cancel
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-3 border border-slate-200 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Preview
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/25 cursor-pointer">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function toolForm() {
                return {
                    faqs: @json($tool->faqs ?? []),
                    addFaq() {
                        this.faqs.push({
                            question: '',
                            answer: ''
                        });
                        this.$nextTick(() => lucide.createIcons());
                    },
                    removeFaq(index) {
                        this.faqs.splice(index, 1);
                    }
                }
            }
        </script>
    @endpush
@endsection
