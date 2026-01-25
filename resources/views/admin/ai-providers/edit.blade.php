@extends('admin.layout')

@section('title', 'Edit AI Provider')
@section('page-title', 'Edit AI Provider')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg
                    {{ $provider->slug === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : '' }}
                    {{ $provider->slug === 'groq' ? 'bg-gradient-to-br from-orange-500 to-amber-500' : '' }}
                    {{ $provider->slug === 'zai' ? 'bg-gradient-to-br from-cyan-500 to-blue-600' : '' }}
                    {{ $provider->slug === 'gemini' ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : '' }}">
                    @if ($provider->slug === 'openrouter')
                        <i data-lucide="route" class="w-7 h-7 text-white"></i>
                    @elseif ($provider->slug === 'groq')
                        <i data-lucide="zap" class="w-7 h-7 text-white"></i>
                    @elseif ($provider->slug === 'gemini')
                        <i data-lucide="gem" class="w-7 h-7 text-white"></i>
                    @else
                        <i data-lucide="sparkles" class="w-7 h-7 text-white"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit {{ $provider->name }}</h1>
                    <p class="mt-1 text-slate-500">Update provider configuration and settings.</p>
                </div>
            </div>
            <a href="{{ route('admin.ai-providers.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back
            </a>
        </div>

        <form action="{{ route('admin.ai-providers.update', $provider) }}" method="POST" x-data="editProviderForm()">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                {{-- Current API Key Info --}}
                <div class="p-6 border-b border-slate-100 bg-indigo-50/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i data-lucide="shield-check" class="w-6 h-6 text-teal-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Current API Key</p>
                                <p class="text-lg font-mono font-bold text-slate-900">{{ $provider->getMaskedApiKey() }}</p>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="updateApiKey"
                                class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm font-medium text-slate-700">Update API Key</span>
                        </label>
                    </div>
                </div>

                {{-- API Key Update (conditional) --}}
                <div x-show="updateApiKey" x-transition class="p-6 border-b border-slate-100 bg-amber-50/30">
                    <label for="api_key" class="block text-sm font-medium text-slate-700 mb-2">New API Key</label>
                    <div class="relative">
                        <input type="password" name="api_key" id="api_key"
                            class="w-full px-4 py-3 bg-white border border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all font-mono"
                            placeholder="Enter new API key">
                        <button type="button" onclick="togglePasswordVisibility('api_key')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-amber-600">Leave empty to keep the current API key.</p>
                    @error('api_key')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- API Configuration --}}
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                        </div>
                        API Configuration
                    </h2>

                    <div class="space-y-5">
                        {{-- Base URL --}}
                        <div>
                            <label for="base_url" class="block text-sm font-medium text-slate-700 mb-2">Base URL <span
                                    class="text-red-500">*</span></label>
                            <input type="url" name="base_url" id="base_url"
                                value="{{ old('base_url', $provider->base_url) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                required>
                            @error('base_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Default Model (Searchable) --}}
                        <div x-data="modelSelector({
                            initial: '{{ old('default_model', $provider->default_model) }}',
                            predefined: {{ json_encode($predefinedModels) }},
                            discovered: {{ json_encode($discoveredModels->map(fn($m) => ['id' => $m->model_name, 'name' => $m->display_name])) }}
                        })" class="relative" @click.outside="close()">

                            <label for="default_model" class="block text-sm font-medium text-slate-700 mb-2">Default
                                Model</label>

                            {{-- Specific Hidden Input for Form Submission --}}
                            <input type="hidden" name="default_model" x-model="value">

                            {{-- Search Input / Display --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
                                </div>
                                <input type="text" x-model="search" @focus="open()" @input="open()"
                                    @keydown.enter.prevent="selectCustom()" @keydown.escape="close()"
                                    class="w-full pl-10 pr-10 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                    placeholder="Search or enter model name..." autocomplete="off">

                                {{-- Clear/Chevron Icon --}}
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                                    @click="toggle()">
                                    <template x-if="search">
                                        <i data-lucide="x" class="h-4 w-4 text-slate-400 hover:text-slate-600"
                                            @click.stop="clear()"></i>
                                    </template>
                                    <template x-if="!search">
                                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400"></i>
                                    </template>
                                </div>
                            </div>

                            {{-- Dropdown Results --}}
                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute z-50 mt-1 w-full bg-white rounded-xl shadow-xl border border-slate-100 max-h-60 overflow-auto"
                                style="display: none;">

                                {{-- Discovered Models Group --}}
                                <template x-if="filteredDiscovered.length > 0">
                                    <div>
                                        <div
                                            class="px-3 py-2 text-xs font-bold text-slate-500 bg-slate-50 uppercase tracking-wider">
                                            Discovered Models</div>
                                        <template x-for="model in filteredDiscovered" :key="model.id">
                                            <div @click="select(model.id)"
                                                class="px-4 py-2 hover:bg-indigo-50 cursor-pointer flex items-center justify-between group">
                                                <span x-text="model.name"
                                                    class="font-medium text-slate-700 group-hover:text-indigo-700"></span>
                                                <span x-text="model.id"
                                                    class="text-xs text-slate-400 group-hover:text-indigo-500 font-mono"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                {{-- Predefined Models Group --}}
                                <template x-if="filteredPredefined.length > 0">
                                    <div>
                                        <div
                                            class="px-3 py-2 text-xs font-bold text-slate-500 bg-slate-50 uppercase tracking-wider border-t border-slate-100">
                                            Recommended Models</div>
                                        <template x-for="(name, id) in filteredPredefined" :key="id">
                                            <div @click="select(id)"
                                                class="px-4 py-2 hover:bg-indigo-50 cursor-pointer flex items-center justify-between group">
                                                <span x-text="name"
                                                    class="font-medium text-slate-700 group-hover:text-indigo-700"></span>
                                                <span x-text="id"
                                                    class="text-xs text-slate-400 group-hover:text-indigo-500 font-mono"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                {{-- Custom Input Option --}}
                                <div @click="selectCustom()"
                                    class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-t border-slate-100"
                                    x-show="search && !hasExactMatch">
                                    <div class="flex items-center text-indigo-600">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        <span class="font-medium">Use custom model: <span x-text="search"
                                                class="font-bold"></span></span>
                                    </div>
                                </div>

                                {{-- No Results --}}
                                <div x-show="!search && filteredDiscovered.length === 0 && Object.keys(filteredPredefined).length === 0"
                                    class="px-4 py-8 text-center text-slate-500">
                                    <p>No models found.</p>
                                    <p class="text-xs mt-1">Type to enter a custom model ID.</p>
                                </div>
                            </div>

                            @error('default_model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Rate Limiting & Settings --}}
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <i data-lucide="gauge" class="w-5 h-5"></i>
                        </div>
                        Rate Limiting & Settings
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        {{-- Timeout --}}
                        <div>
                            <label for="timeout" class="block text-sm font-medium text-slate-700 mb-2">Timeout
                                (seconds)</label>
                            <input type="number" name="timeout" id="timeout"
                                value="{{ old('timeout', $provider->timeout) }}" min="5" max="300"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                            @error('timeout')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Max Tokens --}}
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-slate-700 mb-2">Max
                                Tokens</label>
                            <input type="number" name="max_tokens" id="max_tokens"
                                value="{{ old('max_tokens', $provider->max_tokens) }}" min="100" max="128000"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="Default">
                            @error('max_tokens')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rate Limit --}}
                        <div>
                            <label for="rate_limit_per_minute" class="block text-sm font-medium text-slate-700 mb-2">Rate
                                Limit / min</label>
                            <input type="number" name="rate_limit_per_minute" id="rate_limit_per_minute"
                                value="{{ old('rate_limit_per_minute', $provider->rate_limit_per_minute) }}"
                                min="1" max="10000"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="Unlimited">
                            @error('rate_limit_per_minute')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status & Default --}}
                <div class="p-6 border-b border-slate-100">
                    <div class="flex flex-col md:flex-row gap-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $provider->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <p class="font-medium text-slate-900">Enable Provider</p>
                                <p class="text-xs text-slate-500">Provider will be available for use</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_default" value="1"
                                {{ old('is_default', $provider->is_default) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <p class="font-medium text-slate-900">Set as Default</p>
                                <p class="text-xs text-slate-500">Use as primary provider</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Description --}}
                <div class="p-6 border-b border-slate-100">
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description
                        (optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all resize-none"
                        placeholder="Add notes about this provider configuration...">{{ old('description', $provider->description) }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="p-6 bg-slate-50/50 flex items-center justify-between">
                    <form action="{{ route('admin.ai-providers.test', $provider) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-xl font-medium transition-colors cursor-pointer">
                            <i data-lucide="wifi" class="w-4 h-4 mr-2"></i>
                            Test Connection
                        </button>
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.ai-providers.index') }}"
                            class="px-5 py-2.5 text-slate-600 hover:text-slate-900 font-medium transition-colors cursor-pointer">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                            <i data-lucide="save" class="w-4 h-4 inline mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Manage Models Link --}}
        <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i data-lucide="layers" class="w-5 h-5 text-slate-400"></i>
                    <div>
                        <p class="font-medium text-slate-900">Per-Model Rate Limits</p>
                        <p class="text-sm text-slate-500">Configure rate limits for individual models</p>
                    </div>
                </div>
                <a href="{{ route('admin.ai-providers.models', $provider) }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 hover:text-indigo-600 hover:border-indigo-200 transition-all cursor-pointer">
                    Manage Models
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
        function editProviderForm() {
            return {
                updateApiKey: false
            }
        }

        function modelSelector(config) {
            return {
                value: config.initial || '',
                search: config.initial || '',
                isOpen: false,
                predefined: config.predefined || {},
                discovered: config.discovered || [],

                init() {
                    // If initial value exists, set the search/display text
                    if (this.value) {
                        // Check predefined
                        if (this.predefined[this.value]) {
                            this.search = this.predefined[this.value];
                        }
                        // Check discovered
                        else {
                            const found = this.discovered.find(m => m.id === this.value);
                            if (found) {
                                this.search = found.name;
                            } else {
                                // Custom value
                                this.search = this.value;
                            }
                        }
                    }
                },

                get filteredPredefined() {
                    if (!this.search) return this.predefined;
                    // If search matches ID exactly, return that
                    if (this.predefined[this.search]) return {
                        [this.search]: this.predefined[this.search]
                    };

                    const term = this.search.toLowerCase();
                    return Object.fromEntries(
                        Object.entries(this.predefined).filter(([id, name]) =>
                            name.toLowerCase().includes(term) || id.toLowerCase().includes(term)
                        )
                    );
                },

                get filteredDiscovered() {
                    if (!this.search) return this.discovered;
                    const term = this.search.toLowerCase();
                    return this.discovered.filter(m =>
                        m.name.toLowerCase().includes(term) || m.id.toLowerCase().includes(term)
                    );
                },

                get hasExactMatch() {
                    // Check if current search matches an existing ID
                    return this.discovered.some(m => m.id === this.search) ||
                        Object.keys(this.predefined).includes(this.search);
                },

                open() {
                    this.isOpen = true;
                },
                close() {
                    this.isOpen = false;
                },
                toggle() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) this.$nextTick(() => this.$el.querySelector('input').focus());
                },

                select(id) {
                    this.value = id;
                    // Find name for display
                    if (this.predefined[id]) {
                        this.search = this.predefined[id];
                    } else {
                        const found = this.discovered.find(m => m.id === id);
                        if (found) this.search = found.name;
                        else this.search = id;
                    }
                    this.close();
                },

                selectCustom() {
                    if (this.search) {
                        this.value = this.search;
                        this.close();
                    }
                },

                clear() {
                    this.search = '';
                    this.value = '';
                    this.open();
                    this.$nextTick(() => this.$el.querySelector('input').focus());
                }
            }
        }

        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection
