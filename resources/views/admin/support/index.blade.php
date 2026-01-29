@extends('admin.layout')

@section('title', 'Support Section')
@section('page-title', 'Support Section')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Support Section</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage your Buy Me A Coffee settings</p>
        </div>
        @if ($support->id)
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $support->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-800 border-gray-200' }}">
                    <span
                        class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $support->is_active ? 'bg-green-600' : 'bg-gray-500' }}"></span>
                    {{ $support->is_active ? 'Active' : 'Hidden' }}
                </span>
            </div>
        @endif
    </div>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <form action="{{ route('admin.support-section.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Main Settings --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- General Content Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <h3 class="font-semibold text-slate-900">Content & Messaging</h3>
                            <span class="text-xs font-medium px-2 py-1 bg-slate-100 text-slate-600 rounded">Step 1</span>
                        </div>
                        <div class="p-6 space-y-6">
                            {{-- Headline --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Headline</label>
                                <input type="text" name="headline" value="{{ old('headline', $support->headline) }}"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm"
                                    placeholder="e.g. Enjoying These Tools?">
                                @error('headline')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Supporting Text</label>
                                <textarea name="body_text" rows="3"
                                    class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm resize-none"
                                    placeholder="Briefly explain why users should support you...">{{ old('body_text', $support->body_text) }}</textarea>
                                @error('body_text')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="border-t border-slate-100 pt-5">
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Buy Me A Coffee Link</label>
                                <div class="flex rounded-lg shadow-sm">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </span>
                                    <input type="url" name="buymeacoffee_url"
                                        value="{{ old('buymeacoffee_url', $support->buymeacoffee_url) }}"
                                        class="flex-1 min-w-0 block w-full bg-white border border-slate-300 rounded-r-lg px-3 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
                                        placeholder="https://buymeacoffee.com/yourprofile">
                                </div>
                                <p class="text-xs text-slate-500 mt-1.5">Your personal support page URL</p>
                                @error('buymeacoffee_url')
                                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Progress Bar Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div class="flex items-center gap-2">
                                <h3 class="font-semibold text-slate-900">Goal Progress</h3>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_progress_bar" value="1"
                                    {{ old('show_progress_bar', $support->show_progress_bar) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Label</label>
                                    <input type="text" name="progress_label"
                                        value="{{ old('progress_label', $support->progress_label) }}"
                                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="Goal Name">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Current</label>
                                    <input type="number" name="progress_value"
                                        value="{{ old('progress_value', $support->progress_value) }}"
                                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="e.g. 45">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Target</label>
                                    <input type="number" name="progress_goal"
                                        value="{{ old('progress_goal', $support->progress_goal) }}"
                                        class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        placeholder="e.g. 100">
                                </div>
                            </div>

                            {{-- Minimal Progress Preview --}}
                            @if ($support->progress_value && $support->progress_goal)
                                <div class="mt-6 pt-6 border-t border-slate-100">
                                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                                        <span>Preview: {{ $support->progress_label ?? 'Goal' }}</span>
                                        <span class="font-medium text-blue-600">{{ $support->progress_percentage }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500 rounded-full"
                                            style="width: {{ $support->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Column: Sidebar --}}
                <div class="space-y-6">
                    {{-- Avatar Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="font-semibold text-sm text-slate-900">Profile Image</h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-4 mb-4">
                                @if ($support->image_url)
                                    <img src="{{ $support->image_url }}" alt="Profile"
                                        class="w-16 h-16 rounded-full object-cover border-2 border-slate-100">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center border-2 border-slate-50 text-slate-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <label class="cursor-pointer inline-block">
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-300 rounded-md text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Change Photo
                                        </span>
                                        <input type="file" name="image" accept="image/*" class="hidden">
                                    </label>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500">Recommended: Square, JPG/PNG, max 2MB.</p>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="font-semibold text-sm text-slate-900">Connect</h3>
                        </div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">Twitter / X</label>
                                <input type="url" name="twitter_url"
                                    value="{{ old('twitter_url', $support->twitter_url) }}"
                                    class="w-full bg-white border border-slate-300 rounded-md px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://x.com/username">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-700 mb-1">LinkedIn</label>
                                <input type="url" name="linkedin_url"
                                    value="{{ old('linkedin_url', $support->linkedin_url) }}"
                                    class="w-full bg-white border border-slate-300 rounded-md px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    placeholder="https://linkedin.com/in/username">
                            </div>
                        </div>
                    </div>

                    {{-- Visibility Toggle (Stacked) --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-5 flex items-center justify-between">
                            <div>
                                <span class="block text-sm font-semibold text-slate-900">Visibility</span>
                                <span class="block text-xs text-slate-500">Enable on public site</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $support->is_active ?? true) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Primary Action --}}
                    <button type="submit"
                        class="w-full px-4 py-3 bg-orange-500 text-white font-bold rounded-lg hover:bg-orange-600 transition-all shadow-md shadow-orange-500/20 text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Save Changes
                    </button>

                </div>
            </div>
        </form>
    </div>
@endsection
