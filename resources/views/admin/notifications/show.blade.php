@extends('admin.layout')

@section('title', 'View Notification')

@section('page-title', 'View Notification')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
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
                        <span class="ml-1 text-sm font-medium text-slate-900">#{{ $notification->id }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Notification Preview Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-8">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mr-4"
                        style="background-color: {{ $notification->color_code }}20">
                        <i class="{{ $notification->icon_class }} text-2xl"
                            style="color: {{ $notification->color_code }}"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $notification->title }}</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                style="background-color: {{ $notification->color_code }}20; color: {{ $notification->color_code }}">
                                {{ ucfirst($notification->type) }}
                            </span>
                            <span
                                class="text-xs text-slate-500">{{ $notification->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @if ($notification->status === 'draft' || $notification->status === 'scheduled')
                        <a href="{{ route('admin.notifications.edit', $notification) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                            <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i>
                            Edit
                        </a>
                    @endif
                    <a href="{{ route('admin.notifications.analytics', $notification) }}"
                        class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition-colors">
                        <i data-lucide="bar-chart-2" class="w-4 h-4 mr-2"></i>
                        Analytics
                    </a>
                </div>
            </div>

            <div class="bg-slate-50 rounded-xl p-6 mb-6">
                <p class="text-slate-700 whitespace-pre-wrap">{{ $notification->message }}</p>
            </div>

            {{-- Action Button Preview --}}
            @if ($notification->action_text && $notification->action_url)
                <a href="{{ $notification->action_url }}" target="_blank"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                    {{ $notification->action_text }}
                    <i data-lucide="external-link" class="w-4 h-4 ml-2"></i>
                </a>
            @endif
        </div>

        {{-- Notification Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Targeting</h2>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Target Type</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ ucfirst($notification->target_type) }}</dd>
                    </div>
                    @if ($notification->target_role)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Target Role</dt>
                            <dd class="text-sm font-medium text-slate-900">{{ ucfirst($notification->target_role) }}</dd>
                        </div>
                    @endif
                    @if ($notification->target_users && count($notification->target_users) > 0)
                        <div>
                            <dt class="text-sm text-slate-500 mb-2">Target Users</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ count($notification->target_users) }} users selected
                            </dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Total Recipients</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ $notification->total_recipients }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Settings</h2>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Status</dt>
                        <dd>
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
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Priority</dt>
                        <dd class="text-sm font-medium text-slate-900">{{ ucfirst($notification->priority) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Dismissible</dt>
                        <dd class="text-sm font-medium text-slate-900">
                            {{ $notification->is_dismissible ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Persistent</dt>
                        <dd class="text-sm font-medium text-slate-900">
                            {{ $notification->is_persistent ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-slate-500">Show as Popup</dt>
                        <dd class="text-sm font-medium text-slate-900">
                            {{ $notification->show_as_popup ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    @if ($notification->scheduled_at)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Scheduled For</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ $notification->scheduled_at->format('M j, Y g:i A') }}
                            </dd>
                        </div>
                    @endif
                    @if ($notification->expires_at)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Expires At</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ $notification->expires_at->format('M j, Y g:i A') }}
                            </dd>
                        </div>
                    @endif
                    @if ($notification->sent_at)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Sent At</dt>
                            <dd class="text-sm font-medium text-slate-900">
                                {{ $notification->sent_at->format('M j, Y g:i A') }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Engagement Stats --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Engagement Overview</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-slate-900">{{ $notification->total_recipients }}</p>
                    <p class="text-xs text-slate-500 mt-1">Total Recipients</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-700">{{ $notification->read_count }}</p>
                    <p class="text-xs text-slate-500 mt-1">Read</p>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-amber-700">{{ $notification->unread_count }}</p>
                    <p class="text-xs text-slate-500 mt-1">Unread</p>
                </div>
                <div class="bg-indigo-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-indigo-700">{{ $notification->read_rate }}%</p>
                    <p class="text-xs text-slate-500 mt-1">Read Rate</p>
                </div>
            </div>
        </div>

        {{-- Recipient List --}}
        <div class="bg-white rounded-2xl border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900">Recipient Engagement</h2>
                    <span class="text-sm text-slate-500">{{ $notification->userNotifications()->count() }}
                        recipients</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Read
                                At</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Dismissed At</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Action Clicked</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($notification->userNotifications as $userNotification)
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
                                    No recipients yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
