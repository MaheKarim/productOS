@extends('admin.layout')

@section('title', 'Edit Notice Bar')

@section('page-title', 'Edit Notice Bar')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('admin.notice-bars.index') }}"
                class="p-2 bg-white border border-slate-200 rounded-xl hover:border-slate-300 transition-colors text-slate-500">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="text-xl font-bold text-slate-900">Edit Announcement</h2>
                <p class="text-sm text-slate-500">Update notice content and settings.</p>
            </div>
        </div>

        <form action="{{ route('admin.notice-bars.update', $noticeBar) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Content Section --}}
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-glass">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i data-lucide="type" class="w-5 h-5 text-indigo-500"></i>
                    Content
                </h3>

                <div class="space-y-5">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-1.5">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $noticeBar->title) }}"
                            required maxlength="60"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none font-medium"
                            placeholder="e.g., Scheduled Maintenance">
                        <p class="text-xs text-slate-400 mt-1.5 text-right">Max 60 characters</p>
                    </div>

                    {{-- Message --}}
                    <div>
                        <label for="message" class="block text-sm font-bold text-slate-700 mb-1.5">Message <span
                                class="text-red-500">*</span></label>
                        <textarea name="message" id="message" rows="3" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none font-medium resize-none"
                            placeholder="Enter the main content of your notice...">{{ old('message', $noticeBar->message) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Settings Section --}}
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-glass">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-indigo-500"></i>
                    Settings
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Audience --}}
                    <div>
                        <label for="audience" class="block text-sm font-bold text-slate-700 mb-1.5">Target Audience</label>
                        <select name="audience" id="audience"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none font-medium">
                            <option value="all" {{ old('audience', $noticeBar->audience) == 'all' ? 'selected' : '' }}>
                                All Users</option>
                            <option value="free" {{ old('audience', $noticeBar->audience) == 'free' ? 'selected' : '' }}>
                                Free Plan Only</option>
                            <option value="pro" {{ old('audience', $noticeBar->audience) == 'pro' ? 'selected' : '' }}>
                                Pro Plan Only</option>
                        </select>
                    </div>

                    {{-- Expires At --}}
                    <div>
                        <label for="expires_at" class="block text-sm font-bold text-slate-700 mb-1.5">Expiry Date
                            (Optional)</label>
                        <input type="datetime-local" name="expires_at" id="expires_at"
                            value="{{ old('expires_at', $noticeBar->expires_at ? $noticeBar->expires_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none font-medium text-slate-500">
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    {{-- Dismissible Toggle --}}
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all cursor-pointer group">
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="dismissible" value="1" class="sr-only peer"
                                {{ old('dismissible', $noticeBar->dismissible) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-700 group-hover:text-indigo-700">Allow
                                Dismissal</span>
                            <span class="block text-xs text-slate-500">Users can close this notice permanently.</span>
                        </div>
                    </label>

                    {{-- Active Toggle --}}
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:border-emerald-200 hover:bg-emerald-50/30 transition-all cursor-pointer group">
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                {{ old('is_active', $noticeBar->is_active) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                            </div>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-700 group-hover:text-emerald-700">Set as
                                Active</span>
                            <span class="block text-xs text-slate-500">Publish immediately upon creation.</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.notice-bars.index') }}"
                    class="px-6 py-2.5 rounded-xl text-slate-500 font-bold hover:bg-slate-100 transition-colors">Cancel</a>
                <button type="submit"
                    class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">
                    Update Notice
                </button>
            </div>
        </form>
    </div>
@endsection
