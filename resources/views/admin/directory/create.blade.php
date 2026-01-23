@extends('admin.layout')

@section('title', isset($item) ? 'Edit Item' : 'Create New Item')

@section('content')
    <div class="px-8 py-6">
        <div class="mb-6">
            <a href="{{ route('admin.directory.index') }}"
                class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Directory
            </a>
            <h1 class="text-2xl font-bold text-slate-800">{{ isset($item) ? 'Edit Item' : 'Create New Item' }}</h1>
        </div>

        <form action="{{ isset($item) ? route('admin.directory.update', $item->id) : route('admin.directory.store') }}"
            method="POST" enctype="multipart/form-data" x-data="{
                type: '{{ old('type', $item->type ?? 'tools') }}',
                handleTypeChange() {
                    console.log('Type changed to: ' + this.type);
                }
            }" class="max-w-5xl">
            @csrf
            @if (isset($item))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Main Info --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Basic Info Card --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Basic Information
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Item Type</label>
                                <select name="type" x-model="type" @change="handleTypeChange()"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="tools">Tool / Software</option>
                                    <option value="learning">Learning Resource</option>
                                    <option value="companies">Company</option>
                                    <option value="communities">Community</option>
                                    <option value="templates">Template</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                                <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Tagline (Short
                                    Description)</label>
                                <input type="text" name="tagline" value="{{ old('tagline', $item->tagline ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                                    maxlength="255" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Full Description</label>
                                <textarea name="description" rows="5"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $item->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Type Specific Logic --}}

                    {{-- PRICING (Tools & Learning) --}}
                    <div x-show="['tools', 'learning'].includes(type)"
                        class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Pricing &
                            Availability</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Pricing Model</label>
                                <select name="pricing_model"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Model</option>
                                    <option value="free"
                                        {{ old('pricing_model', $item->pricing_model ?? '') == 'free' ? 'selected' : '' }}>
                                        Free</option>
                                    <option value="freemium"
                                        {{ old('pricing_model', $item->pricing_model ?? '') == 'freemium' ? 'selected' : '' }}>
                                        Freemium</option>
                                    <option value="paid"
                                        {{ old('pricing_model', $item->pricing_model ?? '') == 'paid' ? 'selected' : '' }}>
                                        Paid</option>
                                    <option value="enterprise"
                                        {{ old('pricing_model', $item->pricing_model ?? '') == 'enterprise' ? 'selected' : '' }}>
                                        Enterprise</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Price Range</label>
                                <input type="text" name="price_range"
                                    value="{{ old('price_range', $item->price_range ?? '') }}"
                                    placeholder="e.g. $10 - $50 / month"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="bd_available" value="1"
                                        {{ old('bd_available', $item->bd_available ?? false) ? 'checked' : '' }}
                                        class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium text-slate-700">Available in Bangladesh (Payment
                                        Support)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- LEARNING Specific --}}
                    <div x-show="type === 'learning'" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Learning Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Content Type</label>
                                <select name="content_type"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    <option value="course"
                                        {{ old('content_type', $item->content_type ?? '') == 'course' ? 'selected' : '' }}>
                                        Course</option>
                                    <option value="book"
                                        {{ old('content_type', $item->content_type ?? '') == 'book' ? 'selected' : '' }}>
                                        Book</option>
                                    <option value="video"
                                        {{ old('content_type', $item->content_type ?? '') == 'video' ? 'selected' : '' }}>
                                        Video</option>
                                    <option value="podcast"
                                        {{ old('content_type', $item->content_type ?? '') == 'podcast' ? 'selected' : '' }}>
                                        Podcast</option>
                                    <option value="blog"
                                        {{ old('content_type', $item->content_type ?? '') == 'blog' ? 'selected' : '' }}>
                                        Blog</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Difficulty</label>
                                <select name="difficulty_level"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="all">All Levels</option>
                                    <option value="beginner"
                                        {{ old('difficulty_level', $item->difficulty_level ?? '') == 'beginner' ? 'selected' : '' }}>
                                        Beginner</option>
                                    <option value="intermediate"
                                        {{ old('difficulty_level', $item->difficulty_level ?? '') == 'intermediate' ? 'selected' : '' }}>
                                        Intermediate</option>
                                    <option value="advanced"
                                        {{ old('difficulty_level', $item->difficulty_level ?? '') == 'advanced' ? 'selected' : '' }}>
                                        Advanced</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Instructor / Author</label>
                                <input type="text" name="instructor"
                                    value="{{ old('instructor', $item->instructor ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Platform</label>
                                <input type="text" name="platform" value="{{ old('platform', $item->platform ?? '') }}"
                                    placeholder="Udemy, Coursera, etc."
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    {{-- COMPANIES Specific --}}
                    <div x-show="type === 'companies'" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Company Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Is Hiring?</label>
                                <label class="flex items-center space-x-2 mt-2">
                                    <input type="checkbox" name="is_hiring" value="1"
                                        {{ old('is_hiring', $item->is_hiring ?? false) ? 'checked' : '' }}
                                        class="rounded text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-green-700">Yes, Currently Hiring</span>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Company Size</label>
                                <select name="company_size"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Size</option>
                                    <option value="1-10"
                                        {{ old('company_size', $item->company_size ?? '') == '1-10' ? 'selected' : '' }}>
                                        1-10</option>
                                    <option value="11-50"
                                        {{ old('company_size', $item->company_size ?? '') == '11-50' ? 'selected' : '' }}>
                                        11-50</option>
                                    <option value="51-200"
                                        {{ old('company_size', $item->company_size ?? '') == '51-200' ? 'selected' : '' }}>
                                        51-200</option>
                                    <option value="201-500"
                                        {{ old('company_size', $item->company_size ?? '') == '201-500' ? 'selected' : '' }}>
                                        201-500</option>
                                    <option value="500+"
                                        {{ old('company_size', $item->company_size ?? '') == '500+' ? 'selected' : '' }}>
                                        500+</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Industry</label>
                                <input type="text" name="industry"
                                    value="{{ old('industry', $item->industry ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                                <input type="text" name="location"
                                    value="{{ old('location', $item->location ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Application URL</label>
                                <input type="text" name="application_url"
                                    value="{{ old('application_url', $item->application_url ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    {{-- COMMUNITIES Specific --}}
                    <div x-show="type === 'communities'"
                        class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Community Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Platform</label>
                                <input type="text" name="platform"
                                    value="{{ old('platform', $item->platform ?? '') }}"
                                    placeholder="Facebook, LinkedIn, Discord"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Member Count</label>
                                <input type="text" name="member_count"
                                    value="{{ old('member_count', $item->member_count ?? '') }}" placeholder="e.g. 5K+"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Join URL</label>
                                <input type="text" name="join_url"
                                    value="{{ old('join_url', $item->join_url ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    {{-- TEMPLATES Specific --}}
                    <div x-show="type === 'templates'" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">Template Details
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Template Type</label>
                                <select name="template_type"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    <option value="prd"
                                        {{ old('template_type', $item->template_type ?? '') == 'prd' ? 'selected' : '' }}>
                                        PRD</option>
                                    <option value="presentation"
                                        {{ old('template_type', $item->template_type ?? '') == 'presentation' ? 'selected' : '' }}>
                                        Presentation</option>
                                    <option value="framework"
                                        {{ old('template_type', $item->template_type ?? '') == 'framework' ? 'selected' : '' }}>
                                        Framework</option>
                                    <option value="checklist"
                                        {{ old('template_type', $item->template_type ?? '') == 'checklist' ? 'selected' : '' }}>
                                        Checklist</option>
                                    <option value="other"
                                        {{ old('template_type', $item->template_type ?? '') == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">File Format</label>
                                <input type="text" name="file_format"
                                    value="{{ old('file_format', $item->file_format ?? '') }}"
                                    placeholder="PDF, Google Docs"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Download URL</label>
                                <input type="text" name="download_url"
                                    value="{{ old('download_url', $item->download_url ?? '') }}"
                                    class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>


                </div>

                {{-- Right Column: Meta & Media --}}
                <div class="space-y-6">
                    {{-- Status Card --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wide">Publishing Status</h2>

                        <div class="space-y-3">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}
                                    class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm font-medium text-slate-700">Active (Visible)</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured', $item->is_featured ?? false) ? 'checked' : '' }}
                                    class="rounded text-amber-500 focus:ring-amber-500">
                                <span class="text-sm font-medium text-slate-700">Featured Item</span>
                            </label>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                                {{ isset($item) ? 'Update Item' : 'Create Item' }}
                            </button>
                        </div>
                    </div>

                    {{-- Categorization --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wide">Categorization</h2>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Primary Category</label>
                            <select name="category"
                                class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ old('category', $item->category ?? '') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ ucfirst($category->type) }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Logo Upload --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wide">Logo / Image</h2>

                        @if (isset($item) && $item->logo_path)
                            <div class="mb-4">
                                <img src="{{ Storage::url($item->logo_path) }}"
                                    class="w-20 h-20 rounded-lg object-cover border border-slate-200">
                            </div>
                        @endif

                        <input type="file" name="logo"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-slate-400 mt-2">Recommended: 400x400px, Max 2MB</p>
                    </div>

                    {{-- External Link --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <h2 class="text-sm font-bold text-slate-800 mb-4 uppercase tracking-wide">Links</h2>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Website URL</label>
                            <input type="url" name="website_url"
                                value="{{ old('website_url', $item->website_url ?? '') }}"
                                class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
