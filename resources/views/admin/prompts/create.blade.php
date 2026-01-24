@extends('admin.layout')

@section('title', 'Create Prompt')

@section('content')
    <div class="px-8 py-6">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.prompts.index') }}"
                class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create New Prompt</h1>
                <p class="text-slate-500 mt-1">Add a new AI prompt to the library</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.prompts.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Basic Info Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Basic Information</h2>

                        {{-- Title --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-slate-700 mb-1">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                placeholder="e.g., PRD Generator for E-commerce Features"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">
                                Short Description
                            </label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}"
                                placeholder="1-2 sentences describing what this prompt does"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <p class="mt-1 text-xs text-slate-500">Max 500 characters</p>
                        </div>

                        {{-- Prompt Text --}}
                        <div>
                            <label for="prompt_text" class="block text-sm font-medium text-slate-700 mb-1">
                                Prompt Text <span class="text-red-500">*</span>
                            </label>
                            <textarea name="prompt_text" id="prompt_text" rows="15" required
                                placeholder="Enter the full prompt text here. Supports Markdown formatting."
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-mono text-sm @error('prompt_text') border-red-500 @enderror">{{ old('prompt_text') }}</textarea>
                            @error('prompt_text')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Supports Markdown. Use [placeholders] for user input.</p>
                        </div>
                    </div>

                    {{-- Example Output Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Example Output</h2>
                        <textarea name="example_output" id="example_output" rows="8"
                            placeholder="Show an example of what this prompt generates..."
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition font-mono text-sm">{{ old('example_output') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">Optional. Helps users understand the expected output.</p>
                    </div>

                    {{-- Tips Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Tips for Best Results</h2>
                        <textarea name="tips" id="tips" rows="4"
                            placeholder="Enter tips, one per line:
Be specific about your product context
Include actual feature descriptions
Provide business goals and constraints"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm">{{ old('tips') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">One tip per line. These help users get better results.</p>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Publish Settings Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Publish Settings</h2>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft
                                </option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived
                                </option>
                            </select>
                        </div>

                        {{-- Featured --}}
                        <div class="flex items-center gap-3 p-3 bg-amber-50 rounded-lg">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="w-5 h-5 text-amber-600 border-slate-300 rounded focus:ring-amber-500">
                            <label for="is_featured" class="text-sm font-medium text-amber-800">
                                Feature on homepage
                            </label>
                        </div>
                    </div>

                    {{-- Classification Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Classification</h2>

                        {{-- Category --}}
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('category_id') border-red-500 @enderror">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- AI Tool --}}
                        <div class="mb-4">
                            <label for="ai_tool" class="block text-sm font-medium text-slate-700 mb-1">
                                AI Tool <span class="text-red-500">*</span>
                            </label>
                            <select name="ai_tool" id="ai_tool" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="universal"
                                    {{ old('ai_tool', 'universal') === 'universal' ? 'selected' : '' }}>Universal (Any AI)
                                </option>
                                <option value="chatgpt" {{ old('ai_tool') === 'chatgpt' ? 'selected' : '' }}>ChatGPT
                                </option>
                                <option value="claude" {{ old('ai_tool') === 'claude' ? 'selected' : '' }}>Claude</option>
                                <option value="gemini" {{ old('ai_tool') === 'gemini' ? 'selected' : '' }}>Gemini</option>
                            </select>
                        </div>

                        {{-- Difficulty --}}
                        <div class="mb-4">
                            <label for="difficulty_level" class="block text-sm font-medium text-slate-700 mb-1">
                                Difficulty Level <span class="text-red-500">*</span>
                            </label>
                            <select name="difficulty_level" id="difficulty_level" required
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="beginner" {{ old('difficulty_level') === 'beginner' ? 'selected' : '' }}>
                                    Beginner</option>
                                <option value="intermediate"
                                    {{ old('difficulty_level', 'intermediate') === 'intermediate' ? 'selected' : '' }}>
                                    Intermediate</option>
                                <option value="advanced" {{ old('difficulty_level') === 'advanced' ? 'selected' : '' }}>
                                    Advanced</option>
                            </select>
                        </div>

                        {{-- Output Length --}}
                        <div class="mb-4">
                            <label for="output_length" class="block text-sm font-medium text-slate-700 mb-1">
                                Expected Output Length
                            </label>
                            <select name="output_length" id="output_length"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="short" {{ old('output_length') === 'short' ? 'selected' : '' }}>Short
                                </option>
                                <option value="medium"
                                    {{ old('output_length', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="long" {{ old('output_length') === 'long' ? 'selected' : '' }}>Long
                                </option>
                            </select>
                        </div>

                        {{-- Use Case Tags --}}
                        <div>
                            <label for="use_case_tags" class="block text-sm font-medium text-slate-700 mb-1">
                                Use Case Tags
                            </label>
                            <input type="text" name="use_case_tags" id="use_case_tags"
                                value="{{ old('use_case_tags') }}" placeholder="roadmap, PRD, user-story"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <p class="mt-1 text-xs text-slate-500">Comma-separated tags</p>
                        </div>
                    </div>

                    {{-- Author Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">Attribution</h2>
                        <div>
                            <label for="author" class="block text-sm font-medium text-slate-700 mb-1">
                                Author / Contributor
                            </label>
                            <input type="text" name="author" id="author" value="{{ old('author') }}"
                                placeholder="Author name"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>

                    {{-- SEO Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-4">SEO Settings</h2>

                        <div class="mb-4">
                            <label for="seo_title" class="block text-sm font-medium text-slate-700 mb-1">
                                SEO Title
                            </label>
                            <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title') }}"
                                placeholder="Custom title for search engines"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <p class="mt-1 text-xs text-slate-500">Max 60 characters</p>
                        </div>

                        <div>
                            <label for="seo_description" class="block text-sm font-medium text-slate-700 mb-1">
                                SEO Description
                            </label>
                            <textarea name="seo_description" id="seo_description" rows="3" placeholder="Description for search engines"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('seo_description') }}</textarea>
                            <p class="mt-1 text-xs text-slate-500">Max 160 characters</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.prompts.index') }}"
                    class="px-6 py-2 text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition cursor-pointer">
                    Cancel
                </a>
                <button type="submit" name="status" value="draft"
                    class="px-6 py-2 text-slate-700 bg-slate-200 hover:bg-slate-300 rounded-lg transition cursor-pointer">
                    Save as Draft
                </button>
                <button type="submit"
                    class="px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition cursor-pointer">
                    Create Prompt
                </button>
            </div>
        </form>
    </div>
@endsection
