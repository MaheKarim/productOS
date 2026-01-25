@extends('admin.layout')

@section('title', 'AI Providers')
@section('page-title', 'AI Providers')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">AI Provider Configuration</h1>
                <p class="mt-1 text-slate-500">Manage your AI service integrations and API connections.</p>
            </div>
            <a href="{{ route('admin.ai-providers.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Add Provider
            </a>
        </div>

        {{-- Provider Stats Bar --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Providers</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $providers->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="brain" class="w-6 h-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Active</p>
                        <p class="text-2xl font-bold text-teal-600">{{ $providers->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-6 h-6 text-teal-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-premium">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Default Provider</p>
                        <p class="text-lg font-bold text-slate-900">
                            {{ $providers->where('is_default', true)->first()?->name ?? 'None' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <i data-lucide="star" class="w-6 h-6 text-amber-500"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Providers Grid --}}
        @if ($providers->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center shadow-premium">
                <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="brain" class="w-10 h-10 text-slate-400"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">No AI Providers Configured</h3>
                <p class="text-slate-500 mb-6">Get started by adding your first AI provider integration.</p>
                <a href="{{ route('admin.ai-providers.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all cursor-pointer">
                    <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                    Add Your First Provider
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($providers as $provider)
                    <div
                        class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-premium hover:shadow-lg transition-all duration-300 cursor-pointer group">
                        {{-- Card Header --}}
                        <div class="p-6 border-b border-slate-100">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg
                                        {{ $provider->slug === 'openrouter' ? 'bg-gradient-to-br from-violet-500 to-purple-600' : '' }}
                                        {{ $provider->slug === 'groq' ? 'bg-gradient-to-br from-orange-500 to-amber-500' : '' }}
                                        {{ $provider->slug === 'zai' ? 'bg-gradient-to-br from-cyan-500 to-blue-600' : '' }}">
                                        @if ($provider->slug === 'openrouter')
                                            <i data-lucide="route" class="w-7 h-7 text-white"></i>
                                        @elseif ($provider->slug === 'groq')
                                            <i data-lucide="zap" class="w-7 h-7 text-white"></i>
                                        @else
                                            <i data-lucide="sparkles" class="w-7 h-7 text-white"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-bold text-slate-900">{{ $provider->name }}</h3>
                                            @if ($provider->is_default)
                                                <span
                                                    class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 rounded-full">Default</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-500">{{ $provider->slug }}</p>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                <div class="flex items-center gap-2">
                                    @if ($provider->is_active)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-teal-500 rounded-full mr-1.5 animate-pulse"></span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-full">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6 space-y-4">
                            {{-- API Key --}}
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                        <i data-lucide="key" class="w-4 h-4 text-slate-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">API Key</p>
                                        <p class="text-sm font-mono font-medium text-slate-700">
                                            {{ $provider->getMaskedApiKey() }}</p>
                                    </div>
                                </div>
                                <i data-lucide="shield-check" class="w-5 h-5 text-teal-500"></i>
                            </div>

                            {{-- Config Details --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-slate-50 rounded-xl">
                                    <p class="text-xs text-slate-500 mb-0.5">Default Model</p>
                                    <p class="text-sm font-medium text-slate-700 truncate">
                                        {{ $provider->default_model ?: 'Not set' }}</p>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl">
                                    <p class="text-xs text-slate-500 mb-0.5">Timeout</p>
                                    <p class="text-sm font-medium text-slate-700">{{ $provider->timeout }}s</p>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl">
                                    <p class="text-xs text-slate-500 mb-0.5">Max Tokens</p>
                                    <p class="text-sm font-medium text-slate-700">
                                        {{ $provider->max_tokens ? number_format($provider->max_tokens) : 'Default' }}</p>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl">
                                    <p class="text-xs text-slate-500 mb-0.5">Rate Limit</p>
                                    <p class="text-sm font-medium text-slate-700">
                                        {{ $provider->rate_limit_per_minute ? $provider->rate_limit_per_minute . '/min' : 'Unlimited' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Card Footer Actions --}}
                        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                {{-- Test Connection --}}
                                <form action="{{ route('admin.ai-providers.test', $provider) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer">
                                        <i data-lucide="wifi" class="w-3.5 h-3.5 mr-1.5"></i>
                                        Test
                                    </button>
                                </form>

                                {{-- Toggle Active --}}
                                <form action="{{ route('admin.ai-providers.toggle', $provider) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium {{ $provider->is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-teal-600 hover:bg-teal-50' }} rounded-lg transition-colors cursor-pointer">
                                        <i data-lucide="{{ $provider->is_active ? 'pause' : 'play' }}"
                                            class="w-3.5 h-3.5 mr-1.5"></i>
                                        {{ $provider->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>

                                @if (!$provider->is_default)
                                    <form action="{{ route('admin.ai-providers.set-default', $provider) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-amber-600 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer">
                                            <i data-lucide="star" class="w-3.5 h-3.5 mr-1.5"></i>
                                            Set Default
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.ai-providers.models', $provider) }}"
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                    title="Manage Models">
                                    <i data-lucide="layers" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.ai-providers.edit', $provider) }}"
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                                    title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.ai-providers.destroy', $provider) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this provider?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                        title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Info Section --}}
        <div class="mt-8 p-6 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="info" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">Supported Providers</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Currently supports <strong>OpenRouter</strong> (access to 100+ models including GPT-4, Claude,
                        Llama),
                        <strong>Groq</strong> (ultra-fast inference with Llama and Mixtral models), and
                        <strong>Z.AI</strong> (GLM flagship models with state-of-the-art performance).
                        API keys are securely encrypted before storage.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
