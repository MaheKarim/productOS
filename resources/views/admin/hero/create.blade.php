@extends('admin.layout')

@section('title', 'Create Hero Section')

@section('page-title', 'Create Hero Section')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-teal-900">Create New Hero Section</h3>
        </div>

        <form action="{{ route('admin.hero.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Basic Information</h4>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('title') ? 'border-red-500' : '' }}"
                            placeholder="Enter hero title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Badge Text</label>
                        <input type="text" name="badge_text" value="{{ old('badge_text') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., Product Manager + Growth Strategist">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Subtitle</label>
                        <textarea name="subtitle" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="Enter subtitle text">{{ old('subtitle') }}</textarea>
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
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Call-to-Action Buttons</h4>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h5 class="text-xs font-semibold text-slate-600 uppercase">Primary CTA</h5>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button Text</label>
                            <input type="text" name="cta_primary_text" value="{{ old('cta_primary_text') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="e.g., View Case Studies">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button URL</label>
                            <input type="text" name="cta_primary_url" value="{{ old('cta_primary_url') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="https://example.com/case-studies">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h5 class="text-xs font-semibold text-slate-600 uppercase">Secondary CTA</h5>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button Text</label>
                            <input type="text" name="cta_secondary_text" value="{{ old('cta_secondary_text') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="e.g., Try Tools">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Button URL</label>
                            <input type="text" name="cta_secondary_url" value="{{ old('cta_secondary_url') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="https://example.com/tools">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Images</h4>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Background Image</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-6 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary transition-colors">
                            <input type="file" name="background_image" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-primary hover:file:bg-teal-100 cursor-pointer">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP (Max 2MB)</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Profile Image</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-6 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary transition-colors">
                            <input type="file" name="profile_image" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-primary hover:file:bg-teal-100 cursor-pointer">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP (Max 2MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Statistics (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Icon (FontAwesome)</label>
                        <input type="text" name="stat1_icon" value="{{ old('stat1_icon') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="fa-solid fa-users">

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Value</label>
                                <input type="text" name="stat1_value" value="{{ old('stat1_value') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="2.4M+">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Label</label>
                                <input type="text" name="stat1_label" value="{{ old('stat1_label') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Users Impacted">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Icon (FontAwesome)</label>
                        <input type="text" name="stat2_icon" value="{{ old('stat2_icon') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="fa-solid fa-chart-line">

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Value</label>
                                <input type="text" name="stat2_value" value="{{ old('stat2_value') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="127%">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Label</label>
                                <input type="text" name="stat2_label" value="{{ old('stat2_label') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Avg Growth Rate">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-slate-600">Icon (FontAwesome)</label>
                        <input type="text" name="stat3_icon" value="{{ old('stat3_icon') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="fa-solid fa-rocket">

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Value</label>
                                <input type="text" name="stat3_value" value="{{ old('stat3_value') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="23">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-600">Label</label>
                                <input type="text" name="stat3_label" value="{{ old('stat3_label') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Products Shipped">
                            </div>
                        </div>
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
                <a href="{{ route('admin.hero.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-save mr-2"></i>
                    Save Hero Section
                </button>
            </div>
        </form>
    </div>
@endsection
