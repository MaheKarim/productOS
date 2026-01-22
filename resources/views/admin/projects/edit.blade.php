@extends('admin.layout')

@section('title', 'Edit Project')

@section('page-title', 'Edit Project')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">Edit Project</h3>
            <a href="{{ route('admin.projects.show', $project) }}"
                class="text-primary hover:text-teal-900 text-sm font-medium">
                <i class="fa-solid fa-eye mr-1"></i>
                Preview
            </a>
        </div>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data"
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
                        <input type="text" name="title" value="{{ old('title', $project->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent {{ $errors->has('title') ? 'border-red-500' : '' }}"
                            placeholder="Enter project title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description <span
                                class="text-red-500">*</span></label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none {{ $errors->has('description') ? 'border-red-500' : '' }}"
                            placeholder="Enter project description">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Category</label>
                        <input type="text" name="category" value="{{ old('category', $project->category) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., Web Development, Mobile App">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">External Link</label>
                        <input type="url" name="external_link"
                            value="{{ old('external_link', $project->external_link) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="https://example.com">
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Status & Order</h4>

                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-sm font-medium text-slate-700">Active</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Order</label>
                        <input type="number" name="order" value="{{ old('order', $project->order) }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Display order (0 = first)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Main Image</label>
                        @if ($project->image)
                            <div class="mb-3">
                                <img src="{{ $project->image_url }}" alt="Current image"
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
                        <label class="block text-sm font-medium text-slate-700 mb-2">Thumbnail</label>
                        @if ($project->thumbnail)
                            <div class="mb-3">
                                <img src="{{ $project->thumbnail_url }}" alt="Current thumbnail"
                                    class="w-full h-32 object-cover rounded-lg">
                                <p class="text-xs text-slate-500 mt-1">Current thumbnail</p>
                            </div>
                        @endif
                        <div
                            class="mt-1 flex justify-center px-6 pt-6 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary transition-colors">
                            <input type="file" name="thumbnail" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-primary hover:file:bg-teal-100 cursor-pointer">
                            <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP (Max 2MB) - Leave empty to keep current
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Metrics (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Metric Value</label>
                        <input type="text" name="metric_value" value="{{ old('metric_value', $project->metric_value) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., 127%">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Metric Label</label>
                        <input type="text" name="metric_label" value="{{ old('metric_label', $project->metric_label) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., Growth Rate">
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Additional Information
                    (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Duration</label>
                        <input type="text" name="duration" value="{{ old('duration', $project->duration) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., 3 months">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Users</label>
                        <input type="text" name="users" value="{{ old('users', $project->users) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="e.g., 10,000+">
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Tags (Optional)</h4>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tags</label>
                    <input type="text" name="tags"
                        value="{{ old('tags', is_array($project->tags) ? implode(', ', $project->tags) : $project->tags) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Comma-separated tags (e.g., Laravel, Vue, Tailwind)">
                </div>
            </div>

            <!-- Related Tools -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Related Tools (Optional)
                </h4>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Related Tools</label>
                    <input type="text" name="related_tools"
                        value="{{ old('related_tools', is_array($project->related_tools) ? implode(', ', $project->related_tools) : $project->related_tools) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Comma-separated tools (e.g., VS Code, Git, Docker)">
                </div>
            </div>

            <!-- SEO -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">SEO (Optional)</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $project->meta_title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="SEO title for search engines">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none"
                            placeholder="SEO description for search engines">{{ old('meta_description', $project->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.projects.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                    <i class="fa-solid fa-save mr-2"></i>
                    Update Project
                </button>
            </div>
        </form>
    </div>
@endsection
