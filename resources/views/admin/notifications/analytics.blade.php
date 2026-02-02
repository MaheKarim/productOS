@extends('admin.layout')

@section('title', 'Notification Analytics')

@section('page-title', 'Notification Analytics')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Initialize charts
            const ctx = document.getElementById('engagementChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Read', 'Unread', 'Dismissed'],
                    datasets: [{
                        data: [
                            {{ $analytics['read_count'] }},
                            {{ $analytics['unread_count'] }},
                            {{ $notification->userNotifications()->where('is_dismissed', true)->count() }}
                        ],
                        backgroundColor: [
                            '#10B981', // Green
                            '#F59E0B', // Amber
                            '#6B7280' // Gray
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        {{-- Breadcrumb --}}
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.notifications.index') }}"
                        class="text-sm font-medium text-slate-500 hover:text-slate-700">
                        Notifications
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                        <span class="ml-1 text-sm font-medium text-slate-900">Analytics</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Notification Info --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4"
                    style="background-color: {{ $notification->color_code }}20">
                    <i class="{{ $notification->icon_class }} text-2xl" style="color: {{ $notification->color_code }}"></i>
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-slate-900">{{ $notification->title }}</h1>
                    <p class="text-sm text-slate-500 mt-1">Sent on
                        {{ $notification->sent_at ? $notification->sent_at->format('M j, Y g:i A') : 'Not sent' }}</p>
                </div>
                <a href="{{ route('admin.notifications.show', $notification) }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Notification
                </a>
            </div>
        </div>

        {{-- Key Metrics --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Recipients</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $analytics['total_recipients'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Read Count</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $analytics['read_count'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="eye" class="w-6 h-6 text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Unread Count</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $analytics['unread_count'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="eye-off" class="w-6 h-6 text-amber-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Read Rate</p>
                        <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $analytics['read_rate'] }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="percent" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Engagement Chart --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Engagement Distribution</h2>
                <div class="h-64">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>

            {{-- Additional Metrics --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Additional Metrics</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i data-lucide="mouse-pointer-click" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Action Click Rate</p>
                                <p class="text-lg font-bold text-slate-900">{{ $analytics['action_click_rate'] }}%</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center mr-3">
                                <i data-lucide="x-circle" class="w-5 h-5 text-slate-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Dismiss Rate</p>
                                <p class="text-lg font-bold text-slate-900">{{ $analytics['dismiss_rate'] }}%</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Total Read</p>
                                <p class="text-lg font-bold text-slate-900">{{ $analytics['read_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User Engagement Table --}}
        <div class="bg-white rounded-2xl border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">User Engagement Details</h2>
                    <span class="text-sm text-slate-500">{{ $userEngagement->total() }} recipients</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Read
                                At</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Dismissed At</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Action
                                Clicked</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($userEngagement as $userNotification)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($userNotification->user->avatar)
                                            <img src="{{ $userNotification->user->avatar }}"
                                                alt="{{ $userNotification->user->name }}"
                                                class="w-8 h-8 rounded-full object-cover mr-3">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($userNotification->user->name) }}&background=6366f1&color=ffffff"
                                                alt="{{ $userNotification->user->name }}"
                                                class="w-8 h-8 rounded-full object-cover mr-3">
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">
                                                {{ $userNotification->user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $userNotification->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($userNotification->is_read)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Read
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                            Unread
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    @if ($userNotification->read_at)
                                        {{ $userNotification->read_at->format('M j, Y g:i A') }}
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    @if ($userNotification->dismissed_at)
                                        {{ $userNotification->dismissed_at->format('M j, Y g:i A') }}
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($userNotification->action_clicked)
                                        <span class="inline-flex items-center text-green-600">
                                            <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                                            Yes
                                        </span>
                                    @else
                                        <span class="text-slate-400">No</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                    No engagement data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($userEngagement->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 flex items-center justify-between">
                    <p class="text-sm text-slate-500">
                        Showing {{ $userEngagement->firstItem() }} to {{ $userEngagement->lastItem() }} of
                        {{ $userEngagement->total() }} recipients
                    </p>
                    {{ $userEngagement->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection
