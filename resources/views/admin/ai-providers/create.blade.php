@extends('admin.layout')

@section('title', 'Add AI Provider')
@section('page-title', 'Add AI Provider')

@section('content')
    <div class="max-w-3xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Add New AI Provider</h1>
                <p class="mt-1 text-slate-500">Configure a new AI service integration.</p>
            </div>
            <a href="{{ route('admin.ai-providers.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back
            </a>
        </div>

        <form action="{{ route('admin.ai-providers.store') }}" method="POST" x-data="aiProviderForm()">
            @csrf

            <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                {{-- Provider Selection --}}
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i data-lucide="brain" class="w-5 h-5"></i>
                        </div>
                        Select Provider
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($providerTypes as $slug => $name)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="slug" value="{{ $slug }}" class="peer sr-only"
                                    x-model="selectedProvider" {{ old('slug') === $slug ? 'checked' : '' }} required>
                                <div
                                    class="p-5 rounded-2xl border-2 border-slate-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 hover:border-indigo-300 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg
                                            {{ $slug === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : '' }}
                                            {{ $slug === 'groq' ? 'bg-gradient-to-br from-orange-500 to-amber-500' : '' }}
                                            {{ $slug === 'zai' ? 'bg-gradient-to-br from-cyan-500 to-blue-600' : '' }}
                                            {{ $slug === 'gemini' ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : '' }}
                                            {{ $slug === 'amazon-nova' ? 'bg-gradient-to-br from-amber-500 to-orange-600' : '' }}">
                                            @if ($slug === 'openrouter')
                                                <i data-lucide="route" class="w-6 h-6 text-white"></i>
                                            @elseif ($slug === 'groq')
                                                <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                                            @elseif ($slug === 'gemini')
                                                <i data-lucide="gem" class="w-6 h-6 text-white"></i>
                                            @elseif ($slug === 'amazon-nova')
                                                <i data-lucide="cloud" class="w-6 h-6 text-white"></i>
                                            @else
                                                <i data-lucide="sparkles" class="w-6 h-6 text-white"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $name }}</p>
                                            <p class="text-xs text-slate-500">
                                                @if ($slug === 'openrouter')
                                                    100+ AI models
                                                @elseif ($slug === 'groq')
                                                    Ultra-fast inference
                                                @elseif ($slug === 'gemini')
                                                    Google's flagship AI
                                                @elseif ($slug === 'amazon-nova')
                                                    AWS multimodal AI
                                                @else
                                                    GLM flagship models
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-500 flex items-center justify-center transition-all">
                                    <i data-lucide="check" class="w-3 h-3 text-white hidden peer-checked:block"></i>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- API Configuration --}}
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                            <i data-lucide="key" class="w-5 h-5"></i>
                        </div>
                        API Configuration
                    </h2>

                    <div class="space-y-5">
                        {{-- API Key --}}
                        <div>
                            <label for="api_key" class="block text-sm font-medium text-slate-700 mb-2">API Key <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="api_key" id="api_key" value="{{ old('api_key') }}"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-mono"
                                    placeholder="sk-xxxxxxxxxxxxxxxxxxxxxxxx" required>
                                <button type="button" onclick="togglePasswordVisibility('api_key')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Your API key will be encrypted before storage.</p>
                            @error('api_key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Base URL --}}
                        <div>
                            <label for="base_url" class="block text-sm font-medium text-slate-700 mb-2">Base URL <span
                                    class="text-red-500">*</span></label>
                            <input type="url" name="base_url" id="base_url" x-bind:value="getDefaultUrl()"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="https://api.example.com/v1" required>
                            @error('base_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Default Model --}}
                        <div>
                            <label for="default_model" class="block text-sm font-medium text-slate-700 mb-2">Default
                                Model</label>
                            <div class="flex gap-3">
                                <select name="default_model" id="default_model"
                                    class="flex-1 px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                    x-model="selectedModel">
                                    <option value="">Select a model</option>
                                    <template x-for="(name, id) in getModels()" :key="id">
                                        <option :value="id" x-text="name"></option>
                                    </template>
                                    <option value="custom">Custom model...</option>
                                </select>
                            </div>
                            <div x-show="selectedModel === 'custom'" class="mt-3">
                                <input type="text" name="custom_model"
                                    class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                    placeholder="Enter custom model name">
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
                            <input type="number" name="timeout" id="timeout" value="{{ old('timeout', 30) }}"
                                min="5" max="300"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                            @error('timeout')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Max Tokens --}}
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-slate-700 mb-2">Max
                                Tokens</label>
                            <input type="number" name="max_tokens" id="max_tokens" value="{{ old('max_tokens') }}"
                                min="100" max="128000"
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
                                value="{{ old('rate_limit_per_minute') }}" min="1" max="10000"
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
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <div>
                                <p class="font-medium text-slate-900">Enable Provider</p>
                                <p class="text-xs text-slate-500">Provider will be available for use</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_default" value="1"
                                {{ old('is_default') ? 'checked' : '' }}
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
                        placeholder="Add notes about this provider configuration...">{{ old('description') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="p-6 bg-slate-50/50 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.ai-providers.index') }}"
                        class="px-5 py-2.5 text-slate-600 hover:text-slate-900 font-medium transition-colors cursor-pointer">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                        <i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
                        Create Provider
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function aiProviderForm() {
            return {
                selectedProvider: '{{ old('slug', '') }}',
                selectedModel: '',
                defaultUrls: @json($defaultUrls),
                predefinedModels: @json($predefinedModels),

                getDefaultUrl() {
                    return this.defaultUrls[this.selectedProvider] || '';
                },

                getModels() {
                    return this.predefinedModels[this.selectedProvider] || {};
                }
            }
        }

        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection
