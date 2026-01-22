@extends('admin.layout')

@section('title', 'Edit Service')

@section('page-title', 'Edit Service')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">Edit Service</h3>
            <a href="{{ route('admin.services.show', $service) }}"
                class="text-primary hover:text-teal-900 text-sm font-medium">
                <i class="fa-solid fa-eye mr-1"></i>
                Preview
            </a>
        </div>

        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data"
            class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Basic Information</h4>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $service->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('title') ? 'border-red-500' : '' }}"
                            placeholder="Enter service title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none {{ $errors->has('description') ? 'border-red-500' : '' }}"
                            placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Problem Solves</label>
                        <textarea name="problem_solves" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="What problem does this service solve?">{{ old('problem_solves', $service->problem_solves) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tangible Outcome</label>
                        <textarea name="tangible_outcome" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="What is tangible outcome?">{{ old('tangible_outcome', $service->tangible_outcome) }}</textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Status & Order</h4>

                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-slate-700">Active</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Order</label>
                        <input type="number" name="order" value="{{ old('order', $service->order) }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Display order (0 = first)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Image</label>
                        @if ($service->image)
                            <div class="mb-3">
                                <img src="{{ $service->image_url }}" alt="Current image"
                                    class="w-full h-32 object-cover rounded-lg">
                                <p class="text-xs text-slate-500 mt-1">Current image</p>
                            </div>
                        @endif
                        <div
                            class="mt-1 flex justify-center px-6 pt-6 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary transition-colors">
                            <input type="file" name="image" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-primary hover:file:bg-teal-100 cursor-pointer">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP (Max 2MB) - Leave empty to keep current
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Icon Type</label>
                        <select name="icon_type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="fa-solid"
                                {{ old('icon_type', $service->icon_type) === 'fa-solid' ? 'selected' : '' }}>Solid
                            </option>
                            <option value="fa-regular" {{ old('icon_type') === 'fa-regular' ? 'selected' : '' }}>Regular
                            </option>
                            <option value="fa-brands" {{ old('icon_type') === 'fa-brands' ? 'selected' : '' }}>Brands
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Icon (FontAwesome)</label>
                        <input type="text" name="icon" value="{{ old('icon', $service->icon) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., fa-cube">
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Features</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Feature 1</label>
                        <input type="text" name="features[0]"
                            value="{{ old('features.0', $service->features[0] ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter feature">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Feature 2</label>
                        <input type="text" name="features[1]"
                            value="{{ old('features.1', $service->features[1] ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter feature">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Feature 3</label>
                        <input type="text" name="features[2]"
                            value="{{ old('features.2', $service->features[2] ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter feature">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Feature 4</label>
                        <input type="text" name="features[3]"
                            value="{{ old('features.3', $service->features[3] ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Enter feature">
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Call-to-Action (Optional)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">CTA Text</label>
                        <input type="text" name="cta_text" value="{{ old('cta_text', $service->cta_text) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., Learn More">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">CTA URL</label>
                        <input type="url" name="cta_url" value="{{ old('cta_url', $service->cta_url) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="https://example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">CTA Style</label>
                        <select name="cta_style"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="primary"
                                {{ old('cta_style', $service->cta_style) === 'primary' ? 'selected' : '' }}>Primary
                            </option>
                            <option value="secondary" {{ old('cta_style') === 'secondary' ? 'selected' : '' }}>Secondary
                            </option>
                            <option value="outline" {{ old('cta_style') === 'outline' ? 'selected' : '' }}>Outline
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="SEO title for search engines">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="SEO description for search engines">{{ old('meta_description', $service->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.services.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-save mr-2"></i>
                    Update Service
                </button>
            </div>
        </form>
    </div>
@endsection
