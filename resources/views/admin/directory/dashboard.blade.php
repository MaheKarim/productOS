@extends('admin.layout')

@section('title', 'Directory Dashboard')

@section('content')
    <div class="px-8 py-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Directory Dashboard</h1>
            <div class="space-x-3">
                <a href="{{ route('admin.directory.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Add New Item
                </a>
                <a href="{{ route('admin.directory.index', ['status' => 'pending']) }}"
                    class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition">
                    <i class="fa-solid fa-hourglass-half mr-2"></i> Review Pending ({{ $stats['pending'] }})
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-500 text-sm font-semibold uppercase">Total Items</div>
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i class="fa-solid fa-database"></i></div>
                </div>
                <div class="text-3xl font-bold text-slate-900">{{ $stats['total_items'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-500 text-sm font-semibold uppercase">Pending Review</div>
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-lg"><i class="fa-solid fa-clock"></i></div>
                </div>
                <div class="text-3xl font-bold text-slate-900">{{ $stats['pending'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-500 text-sm font-semibold uppercase">Featured Items</div>
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg"><i class="fa-solid fa-star"></i></div>
                </div>
                <div class="text-3xl font-bold text-slate-900">{{ $stats['featured'] }}</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-slate-500 text-sm font-semibold uppercase">Clicks (This Month)</div>
                    <div class="p-2 bg-green-50 text-green-600 rounded-lg"><i class="fa-solid fa-mouse-pointer"></i></div>
                </div>
                <div class="text-3xl font-bold text-slate-900">{{ $stats['clicks_month'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Recent Activity & Breakdown --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Type Breakdown --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800">
                        Distribution by Type
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach (['tools', 'learning', 'companies', 'communities', 'templates'] as $type)
                                <div
                                    class="p-4 rounded-lg bg-slate-50 border border-slate-100 flex flex-col items-center justify-center">
                                    <span class="capitalize text-slate-500 text-sm mb-1">{{ $type }}</span>
                                    <span class="text-xl font-bold text-slate-900">{{ $byType[$type] ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Recent Items --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <span class="font-semibold text-slate-800">Recently Added</span>
                        <a href="{{ route('admin.directory.index') }}"
                            class="text-sm text-blue-600 hover:text-blue-700">View All</a>
                    </div>
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Type</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentItems as $item)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-3 font-medium text-slate-900">{{ $item->name }}</td>
                                    <td class="px-6 py-3"><span class="capitalize">{{ $item->type }}</span></td>
                                    <td class="px-6 py-3">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-right text-slate-400">{{ $item->created_at->format('M d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-slate-400">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right Column: Recent Clicks --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 font-semibold text-slate-800">
                        Recent Clicks
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentClicks as $click)
                            <div class="p-4 flex items-start space-x-3 hover:bg-slate-50/50">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-slate-900 truncate">
                                        {{ $click->directoryItem->name ?? 'Unknown Item' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ $click->clicked_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-sm text-slate-400">No clicks yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
