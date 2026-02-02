@extends('admin.layout')

@section('title', 'Edit Notification')

@section('page-title', 'Edit Notification')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            lucide.createIcons();

            // Target type change handler
            const targetTypeSelect = document.getElementById('target_type');
            const targetUsersDiv = document.getElementById('target_users_div');
            const targetRoleDiv = document.getElementById('target_role_div');

            targetTypeSelect.addEventListener('change', function() {
                if (this.value === 'specific') {
                    targetUsersDiv.classList.remove('hidden');
                    targetRoleDiv.classList.add('hidden');
                } else if (this.value === 'role') {
                    targetUsersDiv.classList.add('hidden');
                    targetRoleDiv.classList.remove('hidden');
                } else {
                    targetUsersDiv.classList.add('hidden');
                    targetRoleDiv.classList.add('hidden');
                }
            });

            // Send immediately change handler
            const sendImmediatelyCheckbox = document.getElementById('send_immediately');
            const scheduledAtDiv = document.getElementById('scheduled_at_div');

            sendImmediatelyCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    scheduledAtDiv.classList.add('hidden');
                } else {
                    scheduledAtDiv.classList.remove('hidden');
                }
            });

            // Initialize state
            if (targetTypeSelect.value === 'specific') {
                targetUsersDiv.classList.remove('hidden');
            } else if (targetTypeSelect.value === 'role') {
                targetRoleDiv.classList.remove('hidden');
            }

            if (sendImmediatelyCheckbox.checked) {
                scheduledAtDiv.classList.add('hidden');
            }
        });
    </script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
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
                        <span class="ml-1 text-sm font-medium text-slate-900">Edit #{{ $notification->id }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl border border-slate-200 p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Notification</h1>

            @if ($notification->status === 'expired')
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <div class="flex items-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 mr-3"></i>
                        <div>
                            <p class="text-sm font-bold text-amber-900">Expired Notification</p>
                            <p class="text-xs text-amber-700">This notification has expired and cannot be edited. Please
                                duplicate it to create a new one.</p>
                        </div>
                    </div>
                </div>
            @elseif($notification->status === 'active' && $notification->sent_at)
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <div class="flex items-center">
                        <i data-lucide="info" class="w-5 h-5 text-amber-600 mr-3"></i>
                        <div>
                            <p class="text-sm font-bold text-amber-900">Active Notification</p>
                            <p class="text-xs text-amber-700">This notification has already been sent. You can only update
                                expiration date and display settings.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.notifications.update', $notification) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Basic Information --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-200">Basic Information</h2>

                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $notification->title) }}"
                            required @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500"
                            placeholder="Enter notification title">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700 mb-2">Message <span
                                class="text-red-500">*</span></label>
                        <textarea id="message" name="message" rows="4" required @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 resize-none disabled:bg-slate-100 disabled:text-slate-500"
                            placeholder="Enter notification message">{{ old('message', $notification->message) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 mb-2">Notification Type
                                <span class="text-red-500">*</span></label>
                            <select id="type" name="type" required @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500">
                                <option value="system" {{ $notification->type === 'system' ? 'selected' : '' }}>System
                                    Notification</option>
                                <option value="feature" {{ $notification->type === 'feature' ? 'selected' : '' }}>Feature
                                    Notification</option>
                                <option value="promotional" {{ $notification->type === 'promotional' ? 'selected' : '' }}>
                                    Promotional Notification</option>
                                <option value="alert" {{ $notification->type === 'alert' ? 'selected' : '' }}>Alert/Warning
                                </option>
                                <option value="personal" {{ $notification->type === 'personal' ? 'selected' : '' }}>Personal
                                    Message</option>
                                <option value="credit" {{ $notification->type === 'credit' ? 'selected' : '' }}>
                                    Credit/Billing</option>
                            </select>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-slate-700 mb-2">Priority Level <span
                                    class="text-red-500">*</span></label>
                            <select id="priority" name="priority" required
                                @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500">
                                <option value="low" {{ $notification->priority === 'low' ? 'selected' : '' }}>Low
                                </option>
                                <option value="medium" {{ $notification->priority === 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high" {{ $notification->priority === 'high' ? 'selected' : '' }}>High
                                </option>
                                <option value="urgent" {{ $notification->priority === 'urgent' ? 'selected' : '' }}>Urgent
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Targeting Options --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-200">Targeting Options</h2>

                    <div>
                        <label for="target_type" class="block text-sm font-medium text-slate-700 mb-2">Send To <span
                                class="text-red-500">*</span></label>
                        <select id="target_type" name="target_type" required
                            @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500">
                            <option value="all" {{ $notification->target_type === 'all' ? 'selected' : '' }}>All Users
                            </option>
                            <option value="specific" {{ $notification->target_type === 'specific' ? 'selected' : '' }}>
                                Specific User(s)</option>
                            <option value="role" {{ $notification->target_type === 'role' ? 'selected' : '' }}>User
                                Role/Group</option>
                            <option value="custom" {{ $notification->target_type === 'custom' ? 'selected' : '' }}>Custom
                                Selection</option>
                        </select>
                    </div>

                    <div id="target_users_div" class="{{ $notification->target_type !== 'specific' ? 'hidden' : '' }}">
                        <label for="target_users" class="block text-sm font-medium text-slate-700 mb-2">Select Users</label>
                        <select id="target_users" name="target_users[]" multiple
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 h-40">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, $notification->target_users ?? []) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Hold Ctrl/Cmd to select multiple users</p>
                    </div>

                    <div id="target_role_div" class="{{ $notification->target_type !== 'role' ? 'hidden' : '' }}">
                        <label for="target_role" class="block text-sm font-medium text-slate-700 mb-2">Select Role</label>
                        <select id="target_role" name="target_role"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="">Select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}"
                                    {{ $notification->target_role === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Scheduling --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-200">Scheduling</h2>

                    <div class="flex items-center">
                        <input type="checkbox" id="send_immediately" name="send_immediately" value="1"
                            {{ $notification->status === 'active' && $notification->sent_at ? 'checked disabled' : 'checked' }}
                            class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 disabled:opacity-50">
                        <label for="send_immediately" class="ml-2 text-sm font-medium text-slate-700">Send
                            Immediately</label>
                    </div>

                    <div id="scheduled_at_div" class="hidden">
                        <label for="scheduled_at" class="block text-sm font-medium text-slate-700 mb-2">Schedule
                            For</label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                            value="{{ $notification->scheduled_at ? $notification->scheduled_at->format('Y-m-d\TH:i') : '' }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-slate-700 mb-2">Auto-Expire After
                            (Optional)</label>
                        <input type="datetime-local" id="expires_at" name="expires_at"
                            value="{{ $notification->expires_at ? $notification->expires_at->format('Y-m-d\TH:i') : '' }}"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <p class="text-xs text-slate-500 mt-1">Notification will be automatically removed after this date
                        </p>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-200">Display Settings</h2>

                    <div class="space-y-3">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_dismissible" name="is_dismissible" value="1"
                                {{ $notification->is_dismissible ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="is_dismissible" class="ml-2 text-sm font-medium text-slate-700">Dismissible (users
                                can close)</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="is_persistent" name="is_persistent" value="1"
                                {{ $notification->is_persistent ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="is_persistent" class="ml-2 text-sm font-medium text-slate-700">Persistent (stays
                                until read)</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="show_as_popup" name="show_as_popup" value="1"
                                {{ $notification->show_as_popup ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <label for="show_as_popup" class="ml-2 text-sm font-medium text-slate-700">Show as Popup on
                                Login</label>
                        </div>
                    </div>
                </div>

                {{-- Action Button (Optional) --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 pb-2 border-b border-slate-200">Action Button (Optional)
                    </h2>

                    <div>
                        <label for="action_text" class="block text-sm font-medium text-slate-700 mb-2">Button Text</label>
                        <input type="text" id="action_text" name="action_text"
                            value="{{ old('action_text', $notification->action_text) }}"
                            @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500"
                            placeholder="e.g., View Details, Upgrade Now">
                    </div>

                    <div>
                        <label for="action_url" class="block text-sm font-medium text-slate-700 mb-2">Action URL</label>
                        <input type="url" id="action_url" name="action_url"
                            value="{{ old('action_url', $notification->action_url) }}"
                            @if ($notification->status === 'active' && $notification->sent_at) disabled @endif
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:bg-slate-100 disabled:text-slate-500"
                            placeholder="e.g., https://example.com/page">
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.notifications.show', $notification) }}"
                        class="px-6 py-2.5 text-sm font-medium text-slate-700 hover:text-slate-900 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors">
                        Update Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
