@extends('admin.layout')

@section('title', 'Notifications Management')

@section('page-title', 'Notifications Management')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            lucide.createIcons();
        });
    </script>
@endpush

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Notifications</h1>
                <p class="text-sm text-slate-500 mt-1">Manage and send notifications to users</p>
            </div>
            <a href="{{ route('admin.notifications.create') }}"
                class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create Notification
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Sent</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ \App\Models\Notification::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="send" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Active</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ \App\Models\Notification::active()->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="activity" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Scheduled</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">
                            {{ \App\Models\Notification::scheduled()->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Draft</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ \App\Models\Notification::draft()->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="file" class="w-6 h-6 text-slate-600"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters and Search --}}
        <div class="bg-white rounded-2xl p-6 border border-slate-200">
            <form action="{{ route('admin.notifications.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Search</label>
                        <div class="relative">
                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title or content..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        </div>
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled
                            </option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>

                    {{-- Type Filter --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Type</label>
                        <select name="type"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="">All Types</option>
                            <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>System</option>
                            <option value="feature" {{ request('type') == 'feature' ? 'selected' : '' }}>Feature</option>
                            <option value="promotional" {{ request('type') == 'promotional' ? 'selected' : '' }}>
                                Promotional</option>
                            <option value="alert" {{ request('type') == 'alert' ? 'selected' : '' }}>Alert</option>
                            <option value="personal" {{ request('type') == 'personal' ? 'selected' : '' }}>Personal
                            </option>
                            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit/Billing
                            </option>
                        </select>
                    </div>

                    {{-- Target Type Filter --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Target</label>
                        <select name="target_type"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="">All Targets</option>
                            <option value="all" {{ request('target_type') == 'all' ? 'selected' : '' }}>All Users
                            </option>
                            <option value="specific" {{ request('target_type') == 'specific' ? 'selected' : '' }}>Specific
                                Users</option>
                            <option value="role" {{ request('target_type') == 'role' ? 'selected' : '' }}>Role-based
                            </option>
                            <option value="custom" {{ request('target_type') == 'custom' ? 'selected' : '' }}>Custom
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.notifications.index') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Clear Filters
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        {{-- Notifications Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Title
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Type
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Target
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sent
                                Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Read
                                Rate</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($notifications as $notification)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">#{{ $notification->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                                            style="background-color: {{ $notification->color_code }}20">
                                            <i class="{{ $notification->icon_class }} text-sm"
                                                style="color: {{ $notification->color_code }}"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900 max-w-xs truncate">
                                                {{ $notification->title }}</p>
                                            <p class="text-xs text-slate-500 max-w-xs truncate">
                                                {{ Str::limit($notification->message, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        style="background-color: {{ $notification->color_code }}20; color: {{ $notification->color_code }}">
                                        {{ ucfirst($notification->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ ucfirst($notification->target_type) }}
                                    @if ($notification->target_role)
                                        <span class="text-xs text-slate-500">({{ $notification->target_role }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @switch($notification->status)
                                        @case('draft')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                                Draft
                                            </span>
                                        @break

                                        @case('scheduled')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                Scheduled
                                            </span>
                                        @break

                                        @case('active')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                Active
                                            </span>
                                        @break

                                        @case('expired')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                Expired
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    @if ($notification->sent_at)
                                        {{ $notification->sent_at->format('M j, Y g:i A') }}
                                    @else
                                        <span class="text-slate-400">Not sent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-full bg-slate-200 rounded-full h-2 mr-2" style="width: 60px;">
                                            <div class="bg-indigo-600 h-2 rounded-full"
                                                style="width: {{ $notification->read_rate }}%"></div>
                                        </div>
                                        <span
                                            class="text-sm font-medium text-slate-900">{{ $notification->read_rate }}%</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $notification->read_count }}/{{ $notification->total_recipients }} read</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.notifications.show', $notification) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="View Details">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{ route('admin.notifications.analytics', $notification) }}"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="View Analytics">
                                            <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                                        </a>
                                        @if ($notification->status === 'draft' || $notification->status === 'scheduled')
                                            <a href="{{ route('admin.notifications.edit', $notification) }}"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="Edit">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.notifications.duplicate', $notification) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="Duplicate"
                                                onclick="return confirm('Are you sure you want to duplicate this notification?')">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                        @if ($notification->status !== 'active')
                                            <form action="{{ route('admin.notifications.destroy', $notification) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this notification? This action cannot be undone.')">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                                <i data-lucide="bell-off" class="w-8 h-8 text-slate-400"></i>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900 mb-1">No notifications found</h3>
                                            <p class="text-sm text-slate-500 mb-4">Get started by creating your first
                                                notification</p>
                                            <a href="{{ route('admin.notifications.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                Create Notification
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                        <p class="text-sm text-slate-500">
                            Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of
                            {{ $notifications->total() }} notifications
                        </p>
                        {{ $notifications->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    @endsection
