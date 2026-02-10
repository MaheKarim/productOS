@extends('admin.layout')

@section('title', 'Add Sitemap URL')
@section('page-title', 'Add Sitemap URL')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-premium overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Add New URL</h3>
                <p class="text-sm text-slate-500 mt-1">Add a custom URL to your sitemap</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.sitemap.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- URL -->
                <div>
                    <label for="url" class="block text-sm font-bold text-slate-700 mb-2">URL *</label>
                    <input type="text" name="url" id="url" value="{{ old('url') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="/your-page or https://external.com/page" required>
                    <p class="text-xs text-slate-500 mt-1">Enter a relative path (e.g., /about) or full URL for external
                        links</p>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Display Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="About Us Page">
                    <p class="text-xs text-slate-500 mt-1">A friendly name to identify this URL in the admin panel</p>
                </div>

                <!-- Type & Priority Row -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-bold text-slate-700 mb-2">Type *</label>
                        <select name="type" id="type" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @foreach ($typeOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-bold text-slate-700 mb-2">Priority *</label>
                        <input type="number" name="priority" id="priority" step="0.1" min="0.0" max="1.0"
                            value="{{ old('priority', '0.5') }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            required>
                        <p class="text-xs text-slate-500 mt-1">0.0 (lowest) to 1.0 (highest)</p>
                    </div>
                </div>

                <!-- Changefreq & Lastmod Row -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="changefreq" class="block text-sm font-bold text-slate-700 mb-2">Change Frequency
                            *</label>
                        <select name="changefreq" id="changefreq" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @foreach ($changefreqOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('changefreq', 'weekly') == $value ? 'selected' : '' }}>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="lastmod" class="block text-sm font-bold text-slate-700 mb-2">Last Modified</label>
                        <input type="date" name="lastmod" id="lastmod"
                            value="{{ old('lastmod', now()->format('Y-m-d')) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-bold text-slate-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    <p class="text-xs text-slate-500 mt-1">Lower numbers appear first</p>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-bold text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        placeholder="Internal notes about this URL...">{{ old('notes') }}</textarea>
                </div>

                <!-- Is Active -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" checked
                        class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="text-sm font-medium text-slate-700">Active (include in sitemap)</label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.sitemap.index') }}"
                        class="px-5 py-2.5 text-slate-700 font-bold text-sm rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/25">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add URL
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
