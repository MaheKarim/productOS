@extends('admin.layout')

@section('title', 'Directory Categories')

@section('content')
    <div class="px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Categories</h1>
            <a href="{{ route('admin.directory.categories.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i> Add New Category
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Icon</th>
                        <th class="px-6 py-4">Color</th>
                        <th class="px-6 py-4 text-center">Order</th>
                        <th class="px-6 py-4 text-center">Items</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $category->name }}</td>
                            <td class="px-6 py-4"><span class="capitalize">{{ $category->type }}</span></td>
                            <td class="px-6 py-4"><i class="{{ $category->icon }} text-lg text-slate-400"></i></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-4 h-4 rounded-full {{ $category->color_class }}"></div>
                                    <span class="text-xs">{{ $category->color_class }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">{{ $category->display_order }}</td>
                            <td class="px-6 py-4 text-center">{{ $category->item_count }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.directory.categories.edit', $category->id) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    {{-- Delete --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($categories->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">No categories found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
