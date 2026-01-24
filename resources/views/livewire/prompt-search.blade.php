<div class="min-h-screen pt-15">
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-16 md:py-24 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 32px 32px;">
            </div>
        </div>

        {{-- Gradient Orbs --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-orange-500/20 rounded-full filter blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                {{-- Badge --}}
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
                    <svg class="w-4 h-4 text-orange-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-white/90 text-sm font-medium">{{ $totalCount }} Curated Prompts</span>
                </div>

                {{-- Title --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 tracking-tight">
                    PromptHub
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-orange-400">
                        for Product Managers
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto mb-8">
                    Copy production-ready AI prompts in 1 click. PRDs, roadmaps, user research, and more.
                </p>

                {{-- Search Bar --}}
                <div class="max-w-2xl mx-auto">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500 to-orange-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition">
                        </div>
                        <div class="relative flex items-center bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl">
                            <svg class="w-5 h-5 text-slate-400 ml-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Search prompts... (e.g., PRD, roadmap, interview)"
                                class="w-full px-4 py-4 bg-transparent text-slate-800 placeholder-slate-400 focus:outline-none text-lg">
                            @if ($search)
                                <button wire:click="$set('search', '')"
                                    class="p-2 mr-2 text-slate-400 hover:text-slate-600 transition cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Filter Pills --}}
                <div class="flex flex-wrap justify-center gap-2 mt-8">
                    <button wire:click="clearFilters"
                        class="px-4 py-2 rounded-full text-sm font-medium transition cursor-pointer
                            {{ !$selectedCategory && !$selectedTool ? 'bg-white text-slate-900' : 'bg-white/10 text-white hover:bg-white/20' }}">
                        All Prompts
                    </button>
                    @foreach ($categories->take(5) as $category)
                        <button wire:click="setCategory({{ $category->id }})"
                            class="px-4 py-2 rounded-full text-sm font-medium transition cursor-pointer
                                {{ $selectedCategory == $category->id ? 'bg-white text-slate-900' : 'bg-white/10 text-white hover:bg-white/20' }}">
                            {{ $category->name }}
                            <span class="ml-1 opacity-60">({{ $category->prompts_count }})</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Prompts (if not searching) --}}
    @if (!$search && !$selectedCategory && $featuredPrompts->count() > 0)
        <section class="py-12 bg-gradient-to-b from-slate-50 to-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <svg class="w-5 h-5 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Featured Prompts
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($featuredPrompts as $prompt)
                        <div
                            class="group relative bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer">
                            <div class="absolute top-3 right-3">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <svg class="w-3 h-3 mr-1 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                </span>
                            </div>

                            <a href="{{ route('prompts.show', $prompt->slug) }}" class="block mb-3">
                                <h3
                                    class="font-semibold text-slate-800 group-hover:text-blue-600 transition pr-16 line-clamp-2">
                                    {{ $prompt->title }}
                                </h3>
                            </a>

                            <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                                {{ Str::limit($prompt->description, 80) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg">
                                        {{ $prompt->category->name ?? 'General' }}
                                    </span>
                                    <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                                        {{ $prompt->ai_tool_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    {{ number_format($prompt->copy_count) }} copies
                                </span>
                                <button x-data="{ copied: false }"
                                    @click="
                                        navigator.clipboard.writeText($refs.promptText{{ $prompt->id }}.value);
                                        copied = true;
                                        $wire.trackCopy({{ $prompt->id }});
                                        setTimeout(() => copied = false, 2000);
                                    "
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition cursor-pointer">
                                    <template x-if="!copied">
                                        <span class="flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Copy
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="flex items-center text-emerald-200">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Copied!
                                        </span>
                                    </template>
                                </button>
                                <textarea x-ref="promptText{{ $prompt->id }}" class="hidden">{{ $prompt->prompt_text }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Main Content --}}
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Sidebar Filters (Desktop) --}}
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <div class="sticky top-24 space-y-6">
                        {{-- Categories --}}
                        <div class="bg-white rounded-2xl border border-slate-200 p-5">
                            <h3 class="font-semibold text-slate-800 mb-4">Categories</h3>
                            <div class="space-y-2">
                                @foreach ($categories as $category)
                                    <button wire:click="setCategory({{ $category->id }})"
                                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm transition cursor-pointer
                                            {{ $selectedCategory == $category->id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                                        <span>{{ $category->name }}</span>
                                        <span
                                            class="text-xs {{ $selectedCategory == $category->id ? 'text-blue-500' : 'text-slate-400' }}">
                                            {{ $category->prompts_count }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- AI Tool --}}
                        <div class="bg-white rounded-2xl border border-slate-200 p-5">
                            <h3 class="font-semibold text-slate-800 mb-4">AI Tool</h3>
                            <div class="space-y-2">
                                @foreach (['universal' => 'Universal', 'chatgpt' => 'ChatGPT', 'claude' => 'Claude', 'gemini' => 'Gemini'] as $key => $label)
                                    <button wire:click="setTool('{{ $key }}')"
                                        class="w-full flex items-center px-3 py-2 rounded-lg text-sm transition cursor-pointer
                                            {{ $selectedTool === $key ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Difficulty --}}
                        <div class="bg-white rounded-2xl border border-slate-200 p-5">
                            <h3 class="font-semibold text-slate-800 mb-4">Difficulty</h3>
                            <div class="space-y-2">
                                @foreach (['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $key => $label)
                                    <button wire:click="setDifficulty('{{ $key }}')"
                                        class="w-full flex items-center px-3 py-2 rounded-lg text-sm transition cursor-pointer
                                            {{ $selectedDifficulty === $key ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                                        <span
                                            class="w-2 h-2 rounded-full mr-2 
                                            {{ $key === 'beginner' ? 'bg-emerald-500' : '' }}
                                            {{ $key === 'intermediate' ? 'bg-amber-500' : '' }}
                                            {{ $key === 'advanced' ? 'bg-red-500' : '' }}
                                        "></span>
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Clear Filters --}}
                        @if ($selectedCategory || $selectedTool || $selectedDifficulty || $search)
                            <button wire:click="clearFilters"
                                class="w-full px-4 py-2 text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition cursor-pointer">
                                Clear All Filters
                            </button>
                        @endif
                    </div>
                </aside>

                {{-- Prompts Grid --}}
                <div class="flex-1">
                    {{-- Sort & Count Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="text-slate-600">
                            <span class="font-semibold text-slate-800">{{ $prompts->total() }}</span> prompts found
                            @if ($search)
                                for "<span class="font-medium">{{ $search }}</span>"
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-500">Sort by:</span>
                            <select wire:model.live="sortBy"
                                class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
                                <option value="popular">Most Popular</option>
                                <option value="recent">Recently Added</option>
                                <option value="copies">Most Copied</option>
                                <option value="az">A-Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Mobile Filters Toggle --}}
                    <div class="lg:hidden mb-4" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-700 cursor-pointer">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filters
                            </span>
                            <svg class="w-5 h-5 transition" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-collapse class="mt-4 space-y-4">
                            {{-- Mobile filter buttons --}}
                            <div class="flex flex-wrap gap-2">
                                @foreach ($categories as $category)
                                    <button wire:click="setCategory({{ $category->id }})"
                                        class="px-3 py-1.5 rounded-full text-xs font-medium transition cursor-pointer
                                            {{ $selectedCategory == $category->id ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $category->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Prompts List --}}
                    <div class="space-y-4">
                        @forelse($prompts as $prompt)
                            <div
                                class="group bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                    <div class="flex-1">
                                        <a href="{{ route('prompts.show', $prompt->slug) }}"
                                            class="block group/link">
                                            <h3
                                                class="text-lg font-semibold text-slate-800 group-hover/link:text-blue-600 transition mb-2">
                                                {{ $prompt->title }}
                                            </h3>
                                        </a>

                                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($prompt->description ?? $prompt->prompt_text, 150) }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg">
                                                {{ $prompt->category->name ?? 'General' }}
                                            </span>
                                            <span
                                                class="px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                                                {{ $prompt->ai_tool_label }}
                                            </span>
                                            <span
                                                class="px-2.5 py-1 rounded-lg text-xs font-medium
                                                {{ $prompt->difficulty_level === 'beginner' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                                {{ $prompt->difficulty_level === 'intermediate' ? 'bg-amber-50 text-amber-700' : '' }}
                                                {{ $prompt->difficulty_level === 'advanced' ? 'bg-red-50 text-red-700' : '' }}
                                            ">
                                                {{ ucfirst($prompt->difficulty_level) }}
                                            </span>

                                            @if ($prompt->use_case_tags)
                                                @foreach (array_slice($prompt->use_case_tags ?? [], 0, 3) as $tag)
                                                    <span
                                                        class="px-2 py-1 bg-slate-50 text-slate-500 text-xs rounded-lg">
                                                        #{{ $tag }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex md:flex-col items-center gap-3 md:text-right">
                                        <div class="flex items-center gap-4 text-sm text-slate-400 mb-2">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ number_format($prompt->view_count) }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                                {{ number_format($prompt->copy_count) }}
                                            </span>
                                        </div>

                                        <div class="flex gap-2">
                                            <a href="{{ route('prompts.show', $prompt->slug) }}"
                                                class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition cursor-pointer">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>

                                            <button x-data="{ copied: false }"
                                                @click="
                                                    navigator.clipboard.writeText($refs.promptTextCard{{ $prompt->id }}.value);
                                                    copied = true;
                                                    $wire.trackCopy({{ $prompt->id }});
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl transition cursor-pointer"
                                                :class="copied ? 'bg-emerald-600 text-white' :
                                                    'bg-blue-600 text-white hover:bg-blue-700'">
                                                <template x-if="!copied">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1.5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                        Copy Prompt
                                                    </span>
                                                </template>
                                                <template x-if="copied">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1.5" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Copied!
                                                    </span>
                                                </template>
                                            </button>
                                            <textarea x-ref="promptTextCard{{ $prompt->id }}" class="hidden">{{ $prompt->prompt_text }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-lg font-medium text-slate-800 mb-2">No prompts found</h3>
                                <p class="text-slate-500 mb-4">Try adjusting your search or filters.</p>
                                <button wire:click="clearFilters"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition cursor-pointer">
                                    Clear Filters
                                </button>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($prompts->hasPages())
                        <div class="mt-8">
                            {{ $prompts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
