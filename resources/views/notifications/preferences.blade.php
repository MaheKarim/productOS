@extends('layouts.app')

@section('title', 'Notification Preferences')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Handle form submission
            document.getElementById('preferences-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = {};

                formData.forEach((value, key) => {
                    if (value === 'on') {
                        data[key] = true;
                    } else if (value === 'off') {
                        data[key] = false;
                    } else {
                        data[key] = value;
                    }
                });

                fetch('{{ route('notifications.update-preferences') }}', {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className =
                                'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-in slide-in-from-right-4 duration-500';
                            alertDiv.innerHTML = `
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium">Preferences saved successfully!</span>
                            </div>
                        `;
                            document.body.appendChild(alertDiv);

                            setTimeout(() => {
                                alertDiv.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error saving preferences:', error);
                    });
            });
        });
    </script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Notification Preferences</h1>
            <p class="text-slate-500 mt-2">Customize how you receive notifications</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <form id="preferences-form" class="space-y-0">
                {{-- Global Settings --}}
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Global Settings</h2>

                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-slate-900">Enable Notifications</h3>
                            <p class="text-xs text-slate-500 mt-1">Turn off all notifications</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="enable_notifications"
                                {{ auth()->user()->notification_preferences->enable_notifications ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Notification Types --}}
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Notification Types</h2>
                    <p class="text-sm text-slate-500 mb-6">Choose which types of notifications you want to receive</p>

                    <div class="space-y-4">
                        {{-- System Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">System Notifications</h3>
                                    <p class="text-xs text-slate-500">General announcements and updates</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_system"
                                    {{ auth()->user()->notification_preferences->receive_system ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        {{-- Feature Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">Feature Notifications</h3>
                                    <p class="text-xs text-slate-500">New features and updates</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_features"
                                    {{ auth()->user()->notification_preferences->receive_features ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        {{-- Promotional Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-megaphone text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">Promotional Notifications</h3>
                                    <p class="text-xs text-slate-500">Offers and discounts</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_promotional"
                                    {{ auth()->user()->notification_preferences->receive_promotional ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        {{-- Alert Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">Alerts & Warnings</h3>
                                    <p class="text-xs text-slate-500">Important alerts and maintenance</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_alerts"
                                    {{ auth()->user()->notification_preferences->receive_alerts ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        {{-- Personal Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-teal-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">Personal Messages</h3>
                                    <p class="text-xs text-slate-500">Targeted individual messages</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_personal"
                                    {{ auth()->user()->notification_preferences->receive_personal ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        {{-- Credit/Billing Notifications --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-coins text-amber-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-slate-900">Credit/Billing</h3>
                                    <p class="text-xs text-slate-500">Credit updates and payment reminders</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="receive_credit"
                                    {{ auth()->user()->notification_preferences->receive_credit ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Display Settings --}}
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Display Settings</h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-slate-900">Show Popups on Login</h3>
                                <p class="text-xs text-slate-500">Display notifications as modal popups</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_popups"
                                    {{ auth()->user()->notification_preferences->show_popups ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-slate-900">Auto-Mark as Read</h3>
                                <p class="text-xs text-slate-500">Automatically mark notifications as read when viewed</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="auto_mark_read"
                                    {{ auth()->user()->notification_preferences->auto_mark_read ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-slate-900">Group by Date</h3>
                                <p class="text-xs text-slate-500">Group notifications by date in notification center</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="group_by_date"
                                    {{ auth()->user()->notification_preferences->group_by_date ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Cleanup Settings --}}
                <div class="p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Cleanup Settings</h2>
                    <p class="text-sm text-slate-500 mb-6">Automatically clean up old notifications</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="auto_archive_after_days" class="block text-sm font-medium text-slate-700 mb-2">
                                Auto-Archive Read Notifications
                            </label>
                            <select id="auto_archive_after_days" name="auto_archive_after_days"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                <option value="0"
                                    {{ auth()->user()->notification_preferences->auto_archive_after_days == 0 ? 'selected' : '' }}>
                                    Never</option>
                                <option value="7"
                                    {{ auth()->user()->notification_preferences->auto_archive_after_days == 7 ? 'selected' : '' }}>
                                    After 7 days</option>
                                <option value="30"
                                    {{ auth()->user()->notification_preferences->auto_archive_after_days == 30 ? 'selected' : '' }}>
                                    After 30 days</option>
                                <option value="60"
                                    {{ auth()->user()->notification_preferences->auto_archive_after_days == 60 ? 'selected' : '' }}>
                                    After 60 days</option>
                            </select>
                        </div>

                        <div>
                            <label for="auto_delete_after_days" class="block text-sm font-medium text-slate-700 mb-2">
                                Auto-Delete Archived Notifications
                            </label>
                            <select id="auto_delete_after_days" name="auto_delete_after_days"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                                <option value="0"
                                    {{ auth()->user()->notification_preferences->auto_delete_after_days == 0 ? 'selected' : '' }}>
                                    Never</option>
                                <option value="30"
                                    {{ auth()->user()->notification_preferences->auto_delete_after_days == 30 ? 'selected' : '' }}>
                                    After 30 days</option>
                                <option value="60"
                                    {{ auth()->user()->notification_preferences->auto_delete_after_days == 60 ? 'selected' : '' }}>
                                    After 60 days</option>
                                <option value="90"
                                    {{ auth()->user()->notification_preferences->auto_delete_after_days == 90 ? 'selected' : '' }}>
                                    After 90 days</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="p-6 bg-slate-50">
                    <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
