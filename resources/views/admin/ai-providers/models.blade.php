@extends('admin.layout')

@section('title', 'Manage Models - ' . $provider->name)
@section('page-title', 'Model Configuration')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $provider->slug === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : 'bg-gradient-to-br from-orange-500 to-amber-500' }} shadow-lg">
                    @if ($provider->slug === 'openrouter')
                        <i data-lucide="route" class="w-7 h-7 text-white"></i>
                    @else
                        <i data-lucide="zap" class="w-7 h-7 text-white"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $provider->name }} Models</h1>
                    <p class="mt-1 text-slate-500">Configure per-model rate limits and settings.</p>
                </div>
            </div>
            <a href="{{ route('admin.ai-providers.edit', $provider) }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm cursor-pointer">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Provider
            </a>
        </div>

        {{-- Add Model Form --}}
        <form action="{{ route('admin.ai-providers.models.store', $provider) }}" method="POST" class="mb-8">
            @csrf
            <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                        </div>
                        Add Model Configuration
                    </h2>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Model Selection --}}
                        <div class="md:col-span-2" x-data="{ customModel: false }">
                            <label for="model_name" class="block text-sm font-medium text-slate-700 mb-2">Model <span
                                    class="text-red-500">*</span></label>
                            <select name="model_name" id="model_name"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                x-on:change="customModel = $event.target.value === 'custom'" required>
                                <option value="">Select a model</option>
                                @foreach ($predefinedModels as $modelId => $modelName)
                                    <option value="{{ $modelId }}">{{ $modelName }}</option>
                                @endforeach
                                <option value="custom">Custom model...</option>
                            </select>
                            <input type="text" name="custom_model_name" x-show="customModel"
                                class="w-full mt-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="Enter custom model name">
                            @error('model_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Rate Limit --}}
                        <div>
                            <label for="rate_limit" class="block text-sm font-medium text-slate-700 mb-2">Rate / min</label>
                            <input type="number" name="rate_limit_per_minute" id="rate_limit" min="1" max="10000"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="Unlimited">
                        </div>

                        {{-- Max Tokens --}}
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-slate-700 mb-2">Max Tokens</label>
                            <input type="number" name="max_tokens_limit" id="max_tokens" min="100" max="128000"
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"
                                placeholder="Default">
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked
                                class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-slate-700">Active</span>
                        </label>

                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all cursor-pointer">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Add Model
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Models List --}}
        <div class="bg-white rounded-2xl shadow-premium border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                    </div>
                    Configured Models
                    <span
                        class="ml-2 px-2 py-0.5 text-xs font-bold bg-slate-100 text-slate-600 rounded-full">{{ $models->count() }}</span>
                </h2>
            </div>

            @if ($models->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="layers" class="w-8 h-8 text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">No Models Configured</h3>
                    <p class="text-slate-500 text-sm">Add model-specific rate limits using the form above.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($models as $model)
                        <div class="p-5 hover:bg-slate-50/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                                        <i data-lucide="cpu" class="w-5 h-5 text-slate-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $model->display_name }}</p>
                                        <p class="text-xs text-slate-500 font-mono">{{ $model->model_name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-6">
                                    {{-- Rate Limit Badge --}}
                                    <div class="text-center">
                                        <p class="text-xs text-slate-500">Rate Limit</p>
                                        <p class="font-bold text-slate-900">
                                            {{ $model->rate_limit_per_minute ? $model->rate_limit_per_minute . '/min' : 'Unlimited' }}
                                        </p>
                                    </div>

                                    {{-- Max Tokens Badge --}}
                                    <div class="text-center">
                                        <p class="text-xs text-slate-500">Max Tokens</p>
                                        <p class="font-bold text-slate-900">
                                            {{ $model->max_tokens_limit ? number_format($model->max_tokens_limit) : 'Default' }}
                                        </p>
                                    </div>

                                    {{-- Status --}}
                                    @if ($model->is_active)
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded-full">Active</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">Inactive</span>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.ai-providers.models.destroy', [$provider, $model]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Remove this model configuration?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="mt-6 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
            <div class="flex items-start gap-3">
                <i data-lucide="info" class="w-5 h-5 text-indigo-500 flex-shrink-0 mt-0.5"></i>
                <p class="text-sm text-indigo-900">
                    Per-model configurations override the provider-level settings. Models not listed here will use the
                    provider's default rate limit
                    ({{ $provider->rate_limit_per_minute ? $provider->rate_limit_per_minute . '/min' : 'unlimited' }}).
                </p>
            </div>
        </div>
    </div>
@endsection
