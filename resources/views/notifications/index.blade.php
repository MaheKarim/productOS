@extends('user.layout')

@section('title', 'Notification Center')
@section('header', 'Notification Center')

@push('head')
    <style>
        .notification-card {
            transition: all 0.2s ease-in-out;
        }

        .notification-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .notification-unread {
            border-left: 4px solid #6366F1;
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.05) 0%, transparent 100%);
        }

        .notification-read {
            border-left: 4px solid transparent;
        }
    </style>
@endpush

@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons if available
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Poll for unread count every 30 seconds
            setInterval(updateUnreadCountPage, 30000);

            function updateUnreadCountPage() {
                fetch('{{ route('notifications.unread-count') }}')
                    .then(response => response.json())
                    .then(data => {
                        updateBadgePage(data.count, data.display);
                    });
            }

            function updateBadgePage(count, display) {
                const badge = document.getElementById('notification-badge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = display;
                        badge.classList.remove('hidden');
                        badge.classList.add('animate-pulse');
                        setTimeout(() => badge.classList.remove('animate-pulse'), 1000);
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            }

            // Mark as read on click
            document.querySelectorAll('.notification-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (!e.target.closest('.notification-actions')) {
                        const notificationId = this.dataset.notificationId;
                        markAsReadPage(notificationId, this);
                    }
                });
            });

            window.markAsReadPage = function(id, element) {
                fetch('{{ route('notifications.read', ':id') }}'.replace(':id', id), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            element.classList.remove('notification-unread');
                            element.classList.add('notification-read');
                            const unreadDot = element.querySelector('.unread-dot');
                            if (unreadDot) unreadDot.remove();
                            updateBadgePage(data.unread_count, data.unread_count > 99 ? '99+' : data
                                .unread_count);
                        }
                    });
            }

            // Mark all as read
            document.getElementById('mark-all-read')?.addEventListener('click', function() {
                fetch('{{ route('notifications.mark-all-read') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            });

            // Filter handling
            const filterSelects = document.querySelectorAll(
                'select[name="status"], select[name="type"], select[name="priority"]');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });
        });
    </script>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Notification Center</h1>
                <p class="text-slate-500 mt-1">Manage your notifications</p>
            </div>
            <div class="flex items-center space-x-3">
                @if ($unreadCount > 0)
                    <button id="mark-all-read"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        <i data-lucide="check-double" class="w-4 h-4 mr-2"></i>
                        Mark All as Read
                    </button>
                @endif
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
            <form action="{{ route('notifications.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <div class="relative">
                            <i data-lucide="search"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search notifications..."
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        </div>
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <select name="status"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>

                    {{-- Type Filter --}}
                    <div>
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
                </div>
            </form>
        </div>

        {{-- Notifications List --}}
        <div class="space-y-4">
            @forelse($notifications as $userNotification)
                <div class="notification-card {{ $userNotification->is_read ? 'notification-read' : 'notification-unread' }} bg-white rounded-2xl border border-slate-200 p-6 cursor-pointer"
                    data-notification-id="{{ $userNotification->id }}">
                    <div class="flex items-start">
                        {{-- Icon --}}
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4 flex-shrink-0"
                            style="background-color: {{ $userNotification->notification->color_code }}20">
                            <i class="{{ $userNotification->notification->icon_class }} text-xl"
                                style="color: {{ $userNotification->notification->color_code }}"></i>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center">
                                    @if (!$userNotification->is_read)
                                        <span class="unread-dot w-2 h-2 bg-indigo-600 rounded-full mr-2"></span>
                                    @endif
                                    <h3
                                        class="text-lg font-bold {{ $userNotification->is_read ? 'text-slate-700' : 'text-slate-900' }}">
                                        {{ $userNotification->notification->title }}
                                    </h3>
                                </div>
                                <div class="notification-actions flex items-center space-x-2 ml-4">
                                    {{-- Action Button --}}
                                    @if ($userNotification->notification->action_text && $userNotification->notification->action_url)
                                        <a href="{{ $userNotification->notification->action_url }}" target="_blank"
                                            onclick="event.stopPropagation();"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                            {{ $userNotification->notification->action_text }}
                                            <i data-lucide="external-link" class="w-3 h-3 ml-1"></i>
                                        </a>
                                    @endif

                                    {{-- Mark as Read/Unread --}}
                                    @if ($userNotification->is_read)
                                        <button
                                            onclick="event.stopPropagation(); markAsRead({{ $userNotification->id }}, this.closest('.notification-card'))"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="Mark as unread">
                                            <i data-lucide="mail" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        <button
                                            onclick="event.stopPropagation(); markAsRead({{ $userNotification->id }}, this.closest('.notification-card'))"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="Mark as read">
                                            <i data-lucide="mail-open" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    {{-- Dismiss --}}
                                    @if ($userNotification->canBeDismissed())
                                        <form action="{{ route('notifications.dismiss', $userNotification) }}"
                                            method="POST" class="inline" onclick="event.stopPropagation();">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                                                title="Dismiss">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('notifications.destroy', $userNotification) }}" method="POST"
                                        class="inline"
                                        onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this notification?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="text-sm {{ $userNotification->is_read ? 'text-slate-500' : 'text-slate-700' }} mb-3">
                                {{ $userNotification->notification->message }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3 text-xs text-slate-500">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full font-medium"
                                        style="background-color: {{ $userNotification->notification->color_code }}20; color: {{ $userNotification->notification->color_code }}">
                                        {{ ucfirst($userNotification->notification->type) }}
                                    </span>
                                    <span>{{ $userNotification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="bell-off" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No notifications</h3>
                    <p class="text-slate-500">You're all caught up! Check back later for new notifications.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
@endsection
