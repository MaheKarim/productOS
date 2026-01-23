@extends('admin.layout')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <div class="px-8 py-6">
        <div class="mb-6">
            <a href="{{ route('admin.directory.categories.index') }}"
                class="text-slate-500 hover:text-slate-700 text-sm mb-2 inline-block">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Categories
            </a>
            <h1 class="text-2xl font-bold text-slate-800">{{ isset($category) ? 'Edit Category' : 'Create New Category' }}
            </h1>
        </div>

        <div class="max-w-2xl">
            <form
                action="{{ isset($category) ? route('admin.directory.categories.update', $category->id) : route('admin.directory.categories.store') }}"
                method="POST" class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Directory Type</label>
                        <select name="type"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                            @foreach (['tools', 'learning', 'companies', 'communities', 'templates'] as $type)
                                <option value="{{ $type }}"
                                    {{ (old('type') ?? ($category->type ?? '')) == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Category Name</label>
                        <input type="text" name="name" value="{{ old('name') ?? ($category->name ?? '') }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    {{-- Icon --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" value="{{ old('icon') ?? ($category->icon ?? '') }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="fa-solid fa-layer-group">
                    </div>

                    {{-- Color --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Color Class (Tailwind)</label>
                        <input type="text" name="color_class"
                            value="{{ old('color_class') ?? ($category->color_class ?? '') }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="bg-blue-500">
                    </div>

                    {{-- Order --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Display Order</label>
                        <input type="number" name="display_order"
                            value="{{ old('display_order') ?? ($category->display_order ?? 0) }}"
                            class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        {{ isset($category) ? 'Update Category' : 'Create Category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
