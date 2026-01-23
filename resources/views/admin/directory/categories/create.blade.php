@extends('admin.layout')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('page-title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-10">
            <a href="{{ route('admin.directory.categories.index') }}"
                class="inline-flex items-center text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-teal-600 transition-colors mb-4 group">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Categories
            </a>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">
                {{ isset($category) ? 'Edit Category' : 'Create New Category' }}
            </h3>
            <p class="text-slate-500 mt-2">Organize directory items into logical groups.</p>
        </div>

        <form
            action="{{ isset($category) ? route('admin.directory.categories.update', $category->id) : route('admin.directory.categories.store') }}"
            method="POST">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Main Content (2/3) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Card: Category Details --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="folder-open" class="w-4 h-4 mr-2"></i>
                            Category Details
                        </h4>

                        <div class="space-y-6">
                            {{-- Type --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Directory Type <span
                                        class="text-red-500">*</span></label>
                                <select name="type"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft text-sm font-bold">
                                    @foreach (['tools', 'learning', 'companies', 'communities', 'templates'] as $type)
                                        <option value="{{ $type }}"
                                            {{ (old('type') ?? ($category->type ?? '')) == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Category Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') ?? ($category->name ?? '') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft"
                                    placeholder="e.g. Design Tools" required>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                                <textarea name="description" rows="4"
                                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft resize-none"
                                    placeholder="Brief description of this category...">{{ old('description') ?? ($category->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Visual Identity --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-8 flex items-center">
                            <i data-lucide="palette" class="w-4 h-4 mr-2"></i>
                            Visual Identity
                        </h4>

                        <div class="space-y-6">
                            {{-- Icon --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Icon Class (FontAwesome)</label>
                                <div class="relative">
                                    <i
                                        class="fa-solid {{ old('icon') ?? ($category->icon ?? 'fa-layer-group') }} absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" name="icon"
                                        value="{{ old('icon') ?? ($category->icon ?? '') }}"
                                        class="w-full pl-5 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft font-mono text-sm"
                                        placeholder="fa-solid fa-layer-group">
                                </div>
                            </div>

                            {{-- Color --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Color Class (Tailwind)</label>
                                <div class="relative">
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 w-6 h-6 rounded-lg border border-slate-200 {{ old('color_class') ?? ($category->color_class ?? 'bg-teal-500') }}">
                                    </div>
                                    <input type="text" name="color_class"
                                        value="{{ old('color_class') ?? ($category->color_class ?? '') }}"
                                        class="w-full pl-5 pr-16 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 focus:bg-white transition-soft font-mono text-sm"
                                        placeholder="bg-teal-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Side Settings (1/3) --}}
                <div class="space-y-8">
                    {{-- Display Settings --}}
                    <div class="bg-teal-900 rounded-[2.5rem] p-8 text-white shadow-lg shadow-teal-900/20">
                        <h4 class="text-[10px] font-bold text-teal-300 uppercase tracking-widest mb-6">Display Settings</h4>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-teal-300 uppercase tracking-widest mb-2">Display
                                    Order</label>
                                <input type="number" name="display_order"
                                    value="{{ old('display_order') ?? ($category->display_order ?? 0) }}" min="0"
                                    class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-2xl focus:ring-2 focus:ring-white/20 focus:outline-none transition-soft text-sm font-bold"
                                    placeholder="0">
                                <p class="text-[10px] text-teal-400 mt-2">Lower numbers appear first</p>
                            </div>

                            <button type="submit"
                                class="w-full py-4 bg-white text-teal-900 rounded-2xl font-black text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-white/10 hover:-translate-y-0.5 transition-soft">
                                <i data-lucide="save" class="w-4 h-4 inline-block mr-2 scale-110"></i>
                                {{ isset($category) ? 'Update Category' : 'Create Category' }}
                            </button>
                        </div>
                    </div>

                    {{-- Delete Action (Edit Mode Only) --}}
                    @if (isset($category))
                        <form id="delete-cat-{{ $category->id }}"
                            action="{{ route('admin.directory.categories.destroy', $category->id) }}" method="POST"
                            class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button"
                            onclick="if(confirm('Delete this category? This will also remove it from all associated items.')) document.getElementById('delete-cat-{{ $category->id }}').submit()"
                            class="w-full py-4 bg-red-50 text-red-600 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-red-100 transition-soft">
                            <i data-lucide="trash-2" class="w-4 h-4 inline-block mr-2 scale-110"></i>
                            Delete Category
                        </button>
                    @endif

                    {{-- Quick Tips --}}
                    <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-200/60">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center">
                            <i data-lucide="lightbulb" class="w-4 h-4 mr-2"></i>
                            Quick Tips
                        </h4>
                        <ul class="space-y-3 text-xs text-slate-600 leading-relaxed">
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 text-teal-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Use descriptive names that users can easily understand</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 text-teal-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Choose icons that visually represent the category</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 text-teal-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Use consistent color classes across related categories</span>
                            </li>
                            <li class="flex items-start">
                                <i data-lucide="check" class="w-4 h-4 text-teal-500 mr-2 mt-0.5 flex-shrink-0"></i>
                                <span>Set display order to control category sequence</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
