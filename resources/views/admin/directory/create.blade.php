@extends('admin.layout')

@section('title', isset($item) ? 'Edit Item' : 'New Directory Item')

@section('page-title', isset($item) ? 'Edit Resource' : 'Add Resource')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-10">
            <a href="{{ route('admin.directory.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-teal-600 transition-colors mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Directory
            </a>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                {{ isset($item) ? 'Edit Resource' : 'Add Resource' }}
            </h3>
            <p class="text-slate-500 mt-2">Manage directory item details and categorization.</p>
        </div>

        <form action="{{ isset($item) ? route('admin.directory.update', $item->id) : route('admin.directory.store') }}"
            method="POST" enctype="multipart/form-data" x-data="{
                type: '{{ old('type', $item->type ?? 'tools') }}',
                init() {
                    this.$watch('type', value => console.log('Type switched to:', value));
                }
            }">
            @csrf
            @if (isset($item))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Main Content (2/3) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Card: Essential Info --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            Essentials
                        </h4>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Name <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft {{ $errors->has('name') ? 'border-red-500 ring-4 ring-red-500/10' : '' }}"
                                        placeholder="e.g. Linear" required>
                                    @error('name')
                                        <p class="mt-2 text-xs font-bold text-red-500 uppercase tracking-tight">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Website URL</label>
                                    <div class="relative">
                                        <i data-lucide="link"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                        <input type="url" name="website_url"
                                            value="{{ old('website_url', $item->website_url ?? '') }}"
                                            class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                            placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tagline <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tagline" value="{{ old('tagline', $item->tagline ?? '') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                    placeholder="Brief, catchy description (max 100 chars)" maxlength="255" required>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Full Description</label>
                                <textarea name="description" rows="5"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft resize-none">{{ old('description', $item->description ?? '') }}</textarea>
                                <p class="text-[10px] text-slate-400 mt-2">Markdown supported</p>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Card: Type Specific --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm"
                        x-show="['tools', 'learning', 'companies', 'communities', 'templates'].includes(type)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">

                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="sliders" class="w-4 h-4 mr-2"></i>
                            <span x-text="type.charAt(0).toUpperCase() + type.slice(1) + ' Details'"></span>
                        </h4>

                        <div class="space-y-6">
                            {{-- Tools & Learning --}}
                            <div x-show="['tools', 'learning'].includes(type)"
                                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Pricing Model</label>
                                    <select name="pricing_model"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft">
                                        <option value="">Select...</option>
                                        <option value="free"
                                            {{ old('pricing_model', $item->pricing_model ?? '') == 'free' ? 'selected' : '' }}>
                                            Free</option>
                                        <option value="freemium"
                                            {{ old('pricing_model', $item->pricing_model ?? '') == 'freemium' ? 'selected' : '' }}>
                                            Freemium</option>
                                        <option value="paid"
                                            {{ old('pricing_model', $item->pricing_model ?? '') == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Price Range</label>
                                    <input type="text" name="price_range"
                                        value="{{ old('price_range', $item->price_range ?? '') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                        placeholder="$0 - $0">
                                </div>
                            </div>

                            {{-- Learning Specific --}}
                            <div x-show="type === 'learning'"
                                class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Difficulty</label>
                                    <select name="difficulty_level"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft">
                                        <option value="all"
                                            {{ old('difficulty_level', $item->difficulty_level ?? '') == 'all' ? 'selected' : '' }}>
                                            All Levels</option>
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
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Format</label>
                                    <input type="text" name="content_type"
                                        value="{{ old('content_type', $item->content_type ?? '') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                        placeholder="Course, Book, Video...">
                                </div>
                            </div>

                            {{-- Companies Specific --}}
                            <div x-show="type === 'companies'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Company Size</label>
                                    <input type="text" name="company_size"
                                        value="{{ old('company_size', $item->company_size ?? '') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                        placeholder="e.g. 50-200">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Location</label>
                                    <input type="text" name="location"
                                        value="{{ old('location', $item->location ?? '') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                        placeholder="Dhaka, Remote">
                                </div>
                                <div class="col-span-full pt-4">
                                    <label
                                        class="flex items-center p-4 bg-teal-50 border border-teal-100 rounded-2xl cursor-pointer hover:bg-teal-100 transition-colors">
                                        <input type="checkbox" name="is_hiring" value="1"
                                            {{ old('is_hiring', $item->is_hiring ?? false) ? 'checked' : '' }}
                                            class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 border-gray-300 mr-3">
                                        <div>
                                            <span class="block text-sm font-bold text-teal-800">Currently Hiring</span>
                                            <span class="block text-xs text-teal-600">Mark this company as actively
                                                recruiting</span>
                                        </div>
                                    </label>
                                    <div class="mt-4" x-show="document.querySelector('[name=is_hiring]').checked">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Careers Page URL</label>
                                        <input type="url" name="application_url"
                                            value="{{ old('application_url', $item->application_url ?? '') }}"
                                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                            placeholder="https://careers.company.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Side Settings (1/3) --}}
                <div class="space-y-8">
                    {{-- Type Selector --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Resource Type</h4>
                        <select name="type" x-model="type"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft text-sm font-bold">
                            <option value="tools">Tool / Software</option>
                            <option value="learning">Learning Resource</option>
                            <option value="companies">Company</option>
                            <option value="communities">Community</option>
                            <option value="templates">Template</option>
                        </select>
                    </div>

                    {{-- Publish Settings --}}
                    <div class="bg-teal-900 rounded-[2.5rem] p-8 text-white shadow-lg shadow-teal-900/20">
                        <h4 class="text-[10px] font-bold text-teal-300 uppercase tracking-widest mb-6">Publication
                            Settings</h4>

                        <div class="space-y-6">
                            <div
                                class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="text-sm font-bold">Active</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-teal-950 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-500">
                                    </div>
                                </label>
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="text-sm font-bold">Featured</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1"
                                        {{ old('is_featured', $item->is_featured ?? false) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-teal-950 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500">
                                    </div>
                                </label>
                            </div>

                            <div
                                class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="text-sm font-bold">BD Available</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="bd_available" value="1"
                                        {{ old('bd_available', $item->bd_available ?? false) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-teal-950 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500">
                                    </div>
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-white text-teal-900 rounded-2xl font-black text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-white/10 hover:-translate-y-0.5 transition-soft">
                                <i data-lucide="save" class="w-4 h-4 inline-block mr-2 scale-110"></i>
                                {{ isset($item) ? 'Save Changes' : 'Publish Item' }}
                            </button>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Categorization</h4>
                        <div class="space-y-4">
                            <select name="category"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft text-sm font-bold">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ old('category', $item->category ?? '') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ ucfirst($category->type) }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-slate-400 leading-tight">Can't find the category? <a
                                    href="{{ route('admin.directory.categories.index') }}"
                                    class="text-teal-600 hover:underline">Manage Categories</a></p>
                        </div>
                    </div>

                    {{-- Logo Upload --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-200/60 shadow-sm">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Brand Assets</h4>

                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="w-32 h-32 rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center mb-4 overflow-hidden relative group hover:border-teal-400 hover:bg-teal-50/50 transition-soft">
                                @if (isset($item) && $item->logo_path)
                                    <img src="{{ Storage::url($item->logo_path) }}" class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold">
                                        Change</div>
                                @else
                                    <i data-lucide="image" class="w-12 h-12 text-slate-300"></i>
                                @endif
                                <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <p class="text-xs text-center text-slate-400">Click to upload logo<br>Max 2MB (PNG/JPG)</p>
                        </div>
                    </div>

                    {{-- Delete Action (Edit Mode Only) --}}
                    @if (isset($item))
                        <form id="delete-form-{{ $item->id }}"
                            action="{{ route('admin.directory.destroy', $item->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button"
                            onclick="if(confirm('Delete this item?')) document.getElementById('delete-form-{{ $item->id }}').submit()"
                            class="w-full py-4 bg-red-50 text-red-600 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-red-100 transition-soft">
                            <i data-lucide="trash-2" class="w-4 h-4 inline-block mr-2 scale-110"></i>
                            Delete Item
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
