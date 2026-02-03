@extends('admin.layout')

@section('title', 'Global Settings')
@section('page-title', 'Global Settings')

@section('content')
    <div x-data="{ activeTab: 'general' }" class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">System Configuration</h1>
                <p class="text-slate-500 mt-1">Manage global application settings.</p>
            </div>
            <button type="submit" form="settings-form"
                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/30 flex items-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Save Changes
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar / Tabs -->
            <div class="lg:w-64 shrink-0">
                <nav class="space-y-1 sticky top-32">
                    @foreach ($groups as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                            :class="activeTab === '{{ $key }}' ?
                                'bg-white shadow-md text-indigo-600 ring-1 ring-black/5' :
                                'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                            class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all">

                            <!-- Simple icon mapping -->
                            @php
                                $icon = match ($key) {
                                    'general' => 'layout-grid',
                                    'contact' => 'phone',
                                    'seo' => 'search',
                                    'social' => 'share-2',
                                    'email' => 'mail',
                                    'maintenance' => 'alert-triangle',
                                    'auth' => 'lock',
                                    'logs' => 'file-text',
                                    'notifications' => 'bell',
                                    default => 'settings',
                                };
                            @endphp
                            <i data-lucide="{{ $icon }}" class="w-4 h-4 mr-3"
                                :class="activeTab === '{{ $key }}' ? 'text-indigo-500' : 'text-slate-400'"></i>
                            {{ $label }}
                        </button>
                    @endforeach
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    @foreach ($groups as $groupKey => $groupLabel)
                        <div x-show="activeTab === '{{ $groupKey }}'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">

                            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                                    <h2 class="text-xl font-bold text-slate-900">{{ $groupLabel }} Settings</h2>
                                    <p class="text-sm text-slate-500 mt-1">Configure {{ strtolower($groupLabel) }} options.
                                    </p>
                                </div>

                                <div class="p-8 space-y-8">
                                    @if (isset($settings[$groupKey]))
                                        @foreach ($settings[$groupKey] as $setting)
                                            <div class="group">
                                                <div class="flex items-center justify-between mb-2">
                                                    <label for="{{ $setting->key }}"
                                                        class="block text-sm font-bold text-slate-700">
                                                        {{ $setting->label ?? ucfirst(str_replace('_', ' ', $setting->key)) }}
                                                    </label>
                                                    @if ($setting->is_locked)
                                                        <span
                                                            class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wider border border-amber-100">System</span>
                                                    @endif
                                                </div>

                                                @if ($setting->description)
                                                    <p class="text-xs text-slate-500 mb-3">{{ $setting->description }}</p>
                                                @endif

                                                <!-- Input Type Rendering -->
                                                @switch($setting->type)
                                                    @case('boolean')
                                                        <div class="flex items-center gap-3">
                                                            <input type="hidden" name="{{ $setting->key }}" value="0">
                                                            <input type="checkbox" id="{{ $setting->key }}"
                                                                name="{{ $setting->key }}" value="1"
                                                                {{ $setting->value ? 'checked' : '' }}
                                                                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20">
                                                            <label for="{{ $setting->key }}"
                                                                class="text-sm font-medium text-slate-600">Enabled</label>
                                                        </div>
                                                    @break

                                                    @case('password')
                                                        <input type="password" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                            value="{{ $setting->value }}"
                                                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium text-slate-700">
                                                    @break

                                                    @case('textarea')
                                                        <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="6"
                                                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium text-slate-700 leading-relaxed font-mono text-sm">{{ $setting->value }}</textarea>
                                                    @break

                                                    @case('text')
                                                    @case('image')
                                                        <div class="flex items-start gap-6">
                                                            @if ($setting->value)
                                                                <div
                                                                    class="shrink-0 p-2 bg-slate-50 rounded-xl border border-slate-200">
                                                                    <img src="{{ Storage::url($setting->value) }}" alt="Preview"
                                                                        class="h-20 w-auto object-contain">
                                                                </div>
                                                            @endif
                                                            <div class="flex-1">
                                                                <input type="file" id="{{ $setting->key }}"
                                                                    name="{{ $setting->key }}" accept="image/*"
                                                                    class="block w-full text-sm text-slate-500
                                                                          file:mr-4 file:py-2.5 file:px-4
                                                                          file:rounded-xl file:border-0
                                                                          file:text-sm file:font-semibold
                                                                          file:bg-indigo-50 file:text-indigo-700
                                                                          hover:file:bg-indigo-100
                                                                          transition-all cursor-pointer">
                                                                <p class="mt-2 text-xs text-slate-400">Allowed: JPG, PNG, WEBP. Max
                                                                    2MB.</p>
                                                            </div>
                                                        </div>
                                                    @break

                                                    @default
                                                        <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                            value="{{ $setting->value }}"
                                                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium text-slate-700">
                                                @endswitch
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-12">
                                            <div
                                                class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                                <i data-lucide="inbox" class="w-6 h-6 text-slate-300"></i>
                                            </div>
                                            <p class="text-slate-500 font-medium">No settings available for this group yet.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </form>
            </div>
        </div>
    </div>
@endsection
