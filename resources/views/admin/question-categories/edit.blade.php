@extends('admin.layout')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.question-categories.index') }}"
                class="inline-flex items-center text-slate-500 hover:text-slate-700 mb-4 transition-colors cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Categories
            </a>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Category</h1>
            <p class="mt-1 text-slate-500">Update the category details.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <form action="{{ route('admin.question-categories.update', $category) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="e.g., Product Management Basics">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-2">
                        Slug
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono"
                        placeholder="product-management-basics">
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none"
                        placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label for="color" class="block text-sm font-medium text-slate-700 mb-2">
                        Category Color
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="color" name="color" id="color" value="{{ old('color', $category->color) }}"
                            class="w-12 h-12 rounded-xl border border-slate-200 cursor-pointer">
                        <input type="text" id="color-text" value="{{ old('color', $category->color) }}"
                            class="w-32 px-4 py-3 border border-slate-200 rounded-xl font-mono text-sm"
                            pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                    @error('color')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Status --}}
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ $category->is_active ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">
                        Active <span class="text-slate-500">(visible and available for questions)</span>
                    </label>
                </div>

                {{-- Info Box --}}
                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        <span>This category has <strong>{{ $category->questions_count ?? 0 }}</strong> questions
                            assigned.</span>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.question-categories.index') }}"
                        class="px-5 py-2.5 text-slate-600 hover:text-slate-800 font-medium transition-colors cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Sync color picker with text input
            const colorPicker = document.getElementById('color');
            const colorText = document.getElementById('color-text');

            colorPicker.addEventListener('input', function() {
                colorText.value = this.value;
            });

            colorText.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                    colorPicker.value = this.value;
                }
            });
        });
    </script>
@endpush
