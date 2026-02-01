@extends('admin.layout')

@section('title', 'Activity Logs')
@section('page-title', 'Feature Activity Logs')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                        <i class="fa-solid fa-list-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Usages</p>
                        <h4 class="text-2xl font-bold text-slate-900 font-mono">{{ number_format($stats['total_usages']) }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                        <i class="fa-solid fa-coins text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Credits Consumed</p>
                        <h4 class="text-2xl font-bold text-slate-900 font-mono">{{ number_format($stats['total_credits']) }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <i class="fa-solid fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Success Rate</p>
                        <h4 class="text-2xl font-bold text-slate-900 font-mono">
                            {{ $stats['total_usages'] > 0 ? round(($stats['success_count'] / $stats['total_usages']) * 100, 1) : 0 }}%
                        </h4>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-xl text-red-600">
                        <i class="fa-solid fa-bug text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Failed / Blocked</p>
                        <h4 class="text-2xl font-bold text-slate-900 font-mono">{{ number_format($stats['failed_count']) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 p-4">
            <form action="{{ route('admin.activity-logs.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Search
                        User</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Email..."
                        class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                </div>

                <!-- Feature -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Feature</label>
                    <select name="feature"
                        class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                        <option value="">All Features</option>
                        @foreach ($features as $feature)
                            <option value="{{ $feature->key }}" {{ request('feature') == $feature->key ? 'selected' : '' }}>
                                {{ $feature->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                        <option value="">All Statuses</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="insufficient_credits"
                            {{ request('status') == 'insufficient_credits' ? 'selected' : '' }}>Insufficient Credits
                        </option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Feature
                        </option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">From
                        Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                </div>

                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">To
                            Date</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-colors">
                        Filter
                    </button>
                    @if (request()->anyFilled(['search', 'feature', 'status', 'date_from', 'date_to']))
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Logs Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-semibold text-xs border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Date & Time</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Feature</th>
                            <th class="px-6 py-4 text-center">Cost</th>
                            <th class="px-6 py-4 text-center">Balance</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-slate-900">{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-slate-400 font-mono">{{ $log->created_at->format('H:i:s') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($log->user)
                                        <a href="{{ route('admin.users.edit', $log->user) }}"
                                            class="flex items-center gap-3 group">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs ring-2 ring-white shadow-sm">
                                                {{ substr($log->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div
                                                    class="font-medium text-slate-900 group-hover:text-indigo-600 transition-colors">
                                                    {{ $log->user->name }}</div>
                                                <div class="text-xs text-slate-400">{{ $log->user->email }}</div>
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">Unknown User</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($log->feature)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-xs font-medium border border-slate-200">
                                            @if ($log->feature->icon)
                                                <i data-lucide="{{ $log->feature->icon }}"
                                                    class="w-3.5 h-3.5 text-slate-500"></i>
                                            @endif
                                            {{ $log->feature->name ?? $log->feature_key }}
                                        </span>
                                    @else
                                        <span class="font-mono text-xs text-slate-500">{{ $log->feature_key }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($log->credits_deducted > 0)
                                        <span
                                            class="font-mono font-bold text-slate-900">-{{ $log->credits_deducted }}</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-mono text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                        {{ $log->credits_remaining }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @switch($log->status)
                                        @case('success')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700 border border-green-100 ring-1 ring-green-600/10">
                                                Success
                                            </span>
                                        @break

                                        @case('insufficient_credits')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100 ring-1 ring-amber-600/10">
                                                No Credits
                                            </span>
                                        @break

                                        @case('inactive')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                                Inactive
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100 ring-1 ring-red-600/10">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-xs text-slate-400 font-mono" title="{{ $log->user_agent }}">
                                        {{ Str::limit($log->ip_address, 15) }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fa-solid fa-clipboard-list text-slate-300 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-slate-900">No activity found</h3>
                                        <p class="text-slate-500 mt-1">Try adjusting your filters or wait for user activity.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($logs->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endsection
