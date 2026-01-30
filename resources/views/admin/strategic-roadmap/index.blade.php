@extends('admin.layout')

@section('page-title', 'Strategic Roadmap Sessions')

@section('content')
    <!-- Configuration -->
    <div
        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-[1px] rounded-2xl shadow-lg shadow-indigo-500/10 mb-8">
        <div class="bg-white rounded-[15px] overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-gradient-to-br from-indigo-50 to-purple-50 p-2.5 rounded-xl text-indigo-600 border border-indigo-100/50 shadow-sm">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">AI Configuration</h3>
                        <p class="text-sm text-slate-500">Customize the AI personality and model for each roadmap level</p>
                    </div>
                </div>
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg border border-slate-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-semibold text-slate-600">Active</span>
                </div>
            </div>

            <form action="{{ route('admin.strategic-roadmap.settings') }}" method="POST" class="p-8">
                @csrf

                <!-- AI Provider Section -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-slate-900 mb-2">AI Model Provider</label>
                    <div class="relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-indigo-500 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="cpu" class="w-5 h-5"></i>
                        </div>
                        <select name="provider_id"
                            class="w-full h-12 pl-10 pr-4 bg-slate-50 border-slate-200 text-slate-900 text-sm font-medium rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 hover:bg-white hover:border-indigo-300 transition-all cursor-pointer appearance-none">
                            <option value="">Default (Global Active)</option>
                            @foreach ($providers as $provider)
                                <option value="{{ $provider->id }}"
                                    {{ ($settings['provider_id'] ?? '') == $provider->id ? 'selected' : '' }}>
                                    {{ $provider->name }} ({{ $provider->default_model ?? 'Default' }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-2 font-medium">Select the underlying LLM provider (e.g., Groq,
                        OpenAI) for generation.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Junior Card -->
                    <div
                        class="group relative bg-white hover:bg-blue-50/30 rounded-2xl p-5 border border-slate-200 hover:border-blue-200 transition-all duration-300 hover:shadow-md hover:shadow-blue-500/5">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-100/50 text-blue-600 flex items-center justify-center border border-blue-100 group-hover:scale-110 transition-transform">
                                <span class="text-sm font-black">JR</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Junior PM</h4>
                                <p class="text-[10px] font-semibold text-blue-500 uppercase tracking-wide">Foundation</p>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="prompt_id_junior"
                                class="w-full h-10 pl-3 pr-8 text-xs font-medium border-slate-200 bg-white rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-700 cursor-pointer">
                                <option value="">Default System Prompt</option>
                                @foreach ($prompts as $prompt)
                                    <option value="{{ $prompt->id }}"
                                        {{ ($settings['prompt_id_junior'] ?? '') == $prompt->id ? 'selected' : '' }}>
                                        {{ $prompt->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Mid Card -->
                    <div
                        class="group relative bg-white hover:bg-purple-50/30 rounded-2xl p-5 border border-slate-200 hover:border-purple-200 transition-all duration-300 hover:shadow-md hover:shadow-purple-500/5">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-100/50 text-purple-600 flex items-center justify-center border border-purple-100 group-hover:scale-110 transition-transform">
                                <span class="text-sm font-black">MD</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Mid-Level PM</h4>
                                <p class="text-[10px] font-semibold text-purple-500 uppercase tracking-wide">Growth</p>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="prompt_id_mid"
                                class="w-full h-10 pl-3 pr-8 text-xs font-medium border-slate-200 bg-white rounded-lg focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 text-slate-700 cursor-pointer">
                                <option value="">Default System Prompt</option>
                                @foreach ($prompts as $prompt)
                                    <option value="{{ $prompt->id }}"
                                        {{ ($settings['prompt_id_mid'] ?? '') == $prompt->id ? 'selected' : '' }}>
                                        {{ $prompt->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Senior Card -->
                    <div
                        class="group relative bg-white hover:bg-emerald-50/30 rounded-2xl p-5 border border-slate-200 hover:border-emerald-200 transition-all duration-300 hover:shadow-md hover:shadow-emerald-500/5">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100/50 text-emerald-600 flex items-center justify-center border border-emerald-100 group-hover:scale-110 transition-transform">
                                <span class="text-sm font-black">SR</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Senior PM</h4>
                                <p class="text-[10px] font-semibold text-emerald-500 uppercase tracking-wide">Strategy</p>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="prompt_id_senior"
                                class="w-full h-10 pl-3 pr-8 text-xs font-medium border-slate-200 bg-white rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-700 cursor-pointer">
                                <option value="">Default System Prompt</option>
                                @foreach ($prompts as $prompt)
                                    <option value="{{ $prompt->id }}"
                                        {{ ($settings['prompt_id_senior'] ?? '') == $prompt->id ? 'selected' : '' }}>
                                        {{ $prompt->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <i data-lucide="info" class="w-3 h-3"></i>
                        <span>Changes apply immediately to new sessions.</span>
                    </div>
                    <button type="submit"
                        class="group relative inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 hover:shadow-slate-900/30 hover:-translate-y-0.5">
                        <span class="relative z-10 flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                            Save Configuration
                        </span>
                        <div
                            class="absolute inset-0 rounded-xl ring-2 ring-white/20 group-hover:ring-white/30 transition-all">
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions List -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Product Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center mr-3">
                                        <span
                                            class="text-xs font-bold text-slate-500">{{ substr($session->user->name ?? 'Guest', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $session->user->name ?? 'Guest User' }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $session->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="inline-flex items-center w-fit px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ ucfirst(str_replace('_', ' ', $session->product_type ?? 'N/A')) }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        Stage: {{ ucfirst($session->product_stage ?? '-') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $session->status === 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($session->status === 'generating'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-slate-100 text-slate-600') }}">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($session->progress)
                                    <div class="w-24">
                                        <div class="text-xs font-medium text-slate-700 mb-1">
                                            {{ $session->progress->completed_steps }}/{{ $session->progress->total_steps }}
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                                            <div class="bg-indigo-500 h-1.5 rounded-full"
                                                style="width: {{ $session->progress->total_steps > 0 ? ($session->progress->completed_steps / $session->progress->total_steps) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">No progress</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $session->created_at->format('M d, Y') }}
                                <div class="text-xs text-slate-400">{{ $session->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.strategic-roadmap.show', $session->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                        <i data-lucide="inbox" class="w-6 h-6 text-slate-400"></i>
                                    </div>
                                    <p class="text-sm font-medium">No roadmap sessions found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sessions->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
@endsection
