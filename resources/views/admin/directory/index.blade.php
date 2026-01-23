@extends('admin.layout')

@section('title', 'Directory Items')

@section('content')
    <div class="px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Directory Items</h1>
            <a href="{{ route('admin.directory.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i> Add New Item
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6">
            <form action="{{ route('admin.directory.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, description..."
                        class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="w-40">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                    <select name="type"
                        class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach (['tools', 'learning', 'companies', 'communities', 'templates'] as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-40">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        @foreach (['pending', 'verified', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-32">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-900 transition">
                        Filter
                    </button>
                </div>
                <div class="w-24">
                    <a href="{{ route('admin.directory.index') }}"
                        class="block text-center w-full px-4 py-2 text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Verification</th>
                        <th class="px-6 py-4 text-center">Featured</th>
                        <th class="px-6 py-4 text-center">Active</th>
                        <th class="px-6 py-4 text-center">Stats</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($items as $item)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($item->logo_path)
                                        <img src="{{ Storage::url($item->logo_path) }}"
                                            class="w-10 h-10 rounded-lg object-cover mr-3 border border-slate-200">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center mr-3 text-slate-400">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $item->name }}</div>
                                        <div class="text-xs text-slate-500">{{ Str::limit($item->tagline, 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 capitalize">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->verification_status == 'verified')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @elseif($item->verification_status == 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->is_featured)
                                    <i class="fa-solid fa-star text-amber-400"></i>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->is_active)
                                    <i class="fa-solid fa-check text-green-500"></i>
                                @else
                                    <i class="fa-solid fa-xmark text-slate-300"></i>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-xs">
                                <div class="flex flex-col space-y-1">
                                    <span title="Views"><i class="fa-regular fa-eye mr-1"></i>
                                        {{ $item->view_count }}</span>
                                    <span title="Clicks"><i class="fa-solid fa-arrow-pointer mr-1"></i>
                                        {{ $item->click_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.directory.edit', $item->id) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.directory.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium text-slate-900">No items found</p>
                                    <p class="text-sm">Try adjusting your filters or add a new item.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>
@endsection
