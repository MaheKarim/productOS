@extends('admin.layout')

@section('title', 'Create About Section')

@section('page-title', 'Create About Section')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-teal-900">Create New About Section</h3>
        </div>

        <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Basic Information</h4>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Heading <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="heading" value="{{ old('heading') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('heading') ? 'border-red-500' : '' }}"
                            placeholder="Enter heading">
                        @error('heading')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none {{ $errors->has('description') ? 'border-red-500' : '' }}"
                            placeholder="Enter description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Status & Order</h4>

                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-slate-700">Active</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Order</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Display order (0 = first)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Image</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-6 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary transition-colors">
                            <input type="file" name="image" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-primary hover:file:bg-teal-100 cursor-pointer">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP (Max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Philosophy Section -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Philosophy</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Philosophy 1</label>
                        <input type="text" name="philosophy1_title" value="{{ old('philosophy1_title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Title">
                        <textarea name="philosophy1_description" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="Description">{{ old('philosophy1_description') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Philosophy 2</label>
                        <input type="text" name="philosophy2_title" value="{{ old('philosophy2_title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Title">
                        <textarea name="philosophy2_description" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="Description">{{ old('philosophy2_description') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Philosophy 3</label>
                        <input type="text" name="philosophy3_title" value="{{ old('philosophy3_title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Title">
                        <textarea name="philosophy3_description" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="Description">{{ old('philosophy3_description') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Philosophy 4</label>
                        <input type="text" name="philosophy4_title" value="{{ old('philosophy4_title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Title">
                        <textarea name="philosophy4_description" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="Description">{{ old('philosophy4_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Work Items -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Work Items</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Work Item 1</label>
                        <input type="text" name="work_item1" value="{{ old('work_item1') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter work item">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Work Item 2</label>
                        <input type="text" name="work_item2" value="{{ old('work_item2') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter work item">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Work Item 3</label>
                        <input type="text" name="work_item3" value="{{ old('work_item3') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter work item">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Work Item 4</label>
                        <input type="text" name="work_item4" value="{{ old('work_item4') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter work item">
                    </div>
                </div>
            </div>

            <!-- Core Values -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Core Values</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Core Value 1</label>
                        <input type="text" name="core_value1" value="{{ old('core_value1') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter core value">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Core Value 2</label>
                        <input type="text" name="core_value2" value="{{ old('core_value2') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter core value">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Core Value 3</label>
                        <input type="text" name="core_value3" value="{{ old('core_value3') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter core value">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Core Value 4</label>
                        <input type="text" name="core_value4" value="{{ old('core_value4') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter core value">
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="SEO title for search engines">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="SEO description for search engines">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.about.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-save mr-2"></i>
                    Save About Section
                </button>
            </div>
        </form>
    </div>
@endsection
