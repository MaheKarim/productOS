@extends('admin.layout')

@section('page-title', 'Gift & Offer Management')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">Gift & Offer Management</h1>
                <p class="text-sm text-slate-500 mt-1">Manage promotional offers and gift deals from partner websites.</p>
            </div>
            <a href="{{ route('admin.gifts.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition-colors cursor-pointer shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add New Gift
            </a>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="gift" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $gifts->total() }}</p>
                        <p class="text-xs text-slate-500">Total Gifts</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ \App\Models\Gift::where('is_active', true)->count() }}</p>
                        <p class="text-xs text-slate-500">Active Offers</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="pause-circle" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ \App\Models\Gift::where('is_active', false)->count() }}</p>
                        <p class="text-xs text-slate-500">Inactive Offers</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gifts Table --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-900">All Gift Offers</h3>
                <span class="text-xs text-slate-400">{{ $gifts->total() }} entries</span>
            </div>

            @if($gifts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Website</th>
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Description</th>
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Offer</th>
                                <th class="text-center text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Status</th>
                                <th class="text-center text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Order</th>
                                <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wider px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($gifts as $gift)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($gift->logo)
                                                <img src="{{ asset('storage/' . $gift->logo) }}" alt="{{ $gift->website_name }}"
                                                    class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                                    <i data-lucide="globe" class="w-5 h-5 text-indigo-500"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $gift->website_name }}</p>
                                                <a href="{{ $gift->link }}" target="_blank" class="text-xs text-indigo-500 hover:underline cursor-pointer truncate max-w-[200px] block">
                                                    {{ Str::limit($gift->link, 40) }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 max-w-xs truncate">{{ $gift->short_description }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700">
                                            {{ $gift->offer_percentage }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.gifts.toggle', $gift) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="cursor-pointer">
                                                @if($gift->is_active)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-medium text-slate-600">{{ $gift->sort_order }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.gifts.edit', $gift) }}"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                                title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.gifts.destroy', $gift) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this gift offer?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                    title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($gifts->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $gifts->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-16 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-slate-100 rounded-2xl flex items-center justify-center">
                        <i data-lucide="gift" class="w-8 h-8 text-slate-300"></i>
                    </div>
                    <h3 class="text-sm font-medium text-slate-900 mb-1">No gift offers yet</h3>
                    <p class="text-sm text-slate-500 mb-4">Start adding promotional offers from partner websites.</p>
                    <a href="{{ route('admin.gifts.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add First Gift
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
