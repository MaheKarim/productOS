<x-layout.app title="{{ $prompt->seo_title ?? $prompt->title }} - PromptHub">
    <div class="min-h-screen pt-[92px] bg-gradient-to-br from-slate-50 via-white to-blue-50/30">
        {{-- Breadcrumb with Glass Effect --}}
        <div class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-[72px] z-30">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center space-x-2 text-sm">
                    <a href="{{ route('prompts.index') }}"
                        class="text-slate-500 hover:text-blue-600 transition font-medium">
                        PromptHub
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('prompts.index', ['category' => $prompt->category_id]) }}"
                        class="text-slate-500 hover:text-blue-600 transition">
                        {{ $prompt->category->name ?? 'General' }}
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-slate-800 font-medium truncate max-w-xs">{{ $prompt->title }}</span>
                </nav>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header Card with Glassmorphism --}}
            <div
                class="relative bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 md:p-8 mb-6 overflow-hidden">
                {{-- Decorative gradient orb --}}
                <div
                    class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-blue-400/20 to-orange-400/20 rounded-full blur-3xl">
                </div>

                <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                    <div>
                        @if ($prompt->is_featured)
                            <span
                                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200/50 mb-4 shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1.5 fill-current" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Featured Prompt
                            </span>
                        @endif

                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900 mb-4 tracking-tight">
                            {{ $prompt->title }}
                        </h1>

                        @if ($prompt->description)
                            <p class="text-lg text-slate-600 mb-5 leading-relaxed">
                                {{ $prompt->description }}
                            </p>
                        @endif

                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 text-sm font-semibold rounded-xl border border-blue-100">
                                {{ $prompt->category->name ?? 'General' }}
                            </span>
                            <span
                                class="px-3 py-1.5 bg-slate-100/80 text-slate-700 text-sm font-medium rounded-xl border border-slate-200/50">
                                {{ $prompt->ai_tool_label }}
                            </span>
                            <span
                                class="px-3 py-1.5 rounded-xl text-sm font-medium border
                                {{ $prompt->difficulty_level === 'beginner' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : '' }}
                                {{ $prompt->difficulty_level === 'intermediate' ? 'bg-amber-50 text-amber-700 border-amber-100' : '' }}
                                {{ $prompt->difficulty_level === 'advanced' ? 'bg-red-50 text-red-700 border-red-100' : '' }}
                            ">
                                {{ ucfirst($prompt->difficulty_level) }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-5 text-sm text-slate-500 bg-slate-50/50 px-4 py-3 rounded-2xl border border-slate-100">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="font-semibold text-slate-700">{{ number_format($prompt->view_count) }}</span>
                        </span>
                        <div class="w-px h-5 bg-slate-200"></div>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1.5 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span id="copyCount"
                                class="font-semibold text-slate-700">{{ number_format($prompt->copy_count) }}</span>
                        </span>
                    </div>
                </div>

                {{-- Use Case Tags --}}
                @if ($prompt->use_case_tags && count($prompt->use_case_tags) > 0)
                    <div class="flex flex-wrap gap-2 pt-5 border-t border-slate-100/80">
                        @foreach ($prompt->use_case_tags as $tag)
                            <span
                                class="px-3 py-1.5 bg-gradient-to-r from-slate-50 to-slate-100 text-slate-600 text-sm rounded-xl border border-slate-200/50 font-medium">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- The Prompt Card --}}
            <div class="relative bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 md:p-8 mb-6 overflow-hidden"
                x-data="{ copied: false }">
                {{-- Decorative gradient --}}
                <div
                    class="absolute -bottom-16 -left-16 w-32 h-32 bg-gradient-to-tr from-blue-400/10 to-purple-400/10 rounded-full blur-2xl">
                </div>

                <div class="relative flex items-center justify-between mb-5">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center">
                        <span
                            class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        The Prompt
                    </h2>
                    <button
                        @click="
                            navigator.clipboard.writeText($refs.promptText.textContent);
                            copied = true;
                            fetch('{{ route('prompts.copy', $prompt->id) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }})
                                .then(r => r.json())
                                .then(data => { document.getElementById('copyCount').textContent = data.copy_count.toLocaleString(); });
                            setTimeout(() => copied = false, 2000);
                        "
                        class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 cursor-pointer shadow-lg"
                        :class="copied ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-emerald-500/25' :
                            'bg-gradient-to-r from-blue-500 to-indigo-600 text-white hover:from-blue-600 hover:to-indigo-700 shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5'">
                        <template x-if="!copied">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                Copy Prompt
                            </span>
                        </template>
                        <template x-if="copied">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Copied!
                            </span>
                        </template>
                    </button>
                </div>

                <div x-ref="promptText"
                    class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-100 rounded-2xl p-6 font-mono text-sm leading-relaxed overflow-x-auto whitespace-pre-wrap border border-slate-700/50 shadow-inner">
                    {{-- Code pattern overlay --}}
                    <div class="absolute inset-0 opacity-5"
                        style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 20px 20px;">
                    </div>
                    <span class="relative">{{ $prompt->prompt_text }}</span>
                </div>
            </div>

            {{-- Example Output --}}
            @if ($prompt->example_output)
                <div
                    class="relative bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 md:p-8 mb-6 overflow-hidden">
                    <div
                        class="absolute -top-16 -right-16 w-32 h-32 bg-gradient-to-br from-emerald-400/10 to-teal-400/10 rounded-full blur-2xl">
                    </div>

                    <h2 class="relative text-xl font-bold text-slate-800 mb-5 flex items-center">
                        <span
                            class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Example Output
                    </h2>
                    <div
                        class="relative prose prose-slate max-w-none bg-gradient-to-br from-slate-50 to-emerald-50/30 rounded-2xl p-6 border border-slate-200/80">
                        {!! Str::markdown($prompt->example_output) !!}
                    </div>
                </div>
            @endif

            {{-- Tips for Best Results --}}
            @if ($prompt->tips && count($prompt->tips) > 0)
                <div
                    class="relative bg-gradient-to-br from-blue-50/80 via-indigo-50/50 to-purple-50/30 backdrop-blur-xl rounded-3xl border border-blue-100/50 shadow-xl shadow-blue-200/30 p-6 md:p-8 mb-6 overflow-hidden">
                    <div
                        class="absolute -bottom-16 -right-16 w-40 h-40 bg-gradient-to-br from-blue-400/20 to-indigo-400/20 rounded-full blur-3xl">
                    </div>

                    <h2 class="relative text-xl font-bold text-slate-800 mb-5 flex items-center">
                        <span
                            class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </span>
                        Tips for Best Results
                    </h2>
                    <ul class="relative space-y-4">
                        @foreach ($prompt->tips as $tip)
                            <li
                                class="flex items-start bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-white/80 shadow-sm">
                                <span
                                    class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span class="text-slate-700 font-medium">{{ $tip }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Related Prompts --}}
            @if ($relatedPrompts->count() > 0)
                <div
                    class="relative bg-white/70 backdrop-blur-xl rounded-3xl border border-white/50 shadow-xl shadow-slate-200/50 p-6 md:p-8 overflow-hidden">
                    <div
                        class="absolute -top-16 -left-16 w-32 h-32 bg-gradient-to-br from-orange-400/10 to-pink-400/10 rounded-full blur-2xl">
                    </div>

                    <h2 class="relative text-xl font-bold text-slate-800 mb-5 flex items-center">
                        <span
                            class="w-8 h-8 bg-gradient-to-br from-orange-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </span>
                        Related Prompts
                    </h2>
                    <div class="relative grid gap-4">
                        @foreach ($relatedPrompts as $related)
                            <a href="{{ route('prompts.show', $related->slug) }}"
                                class="flex items-center justify-between p-5 bg-gradient-to-r from-slate-50/80 to-white rounded-2xl hover:from-blue-50/50 hover:to-white border border-slate-100 hover:border-blue-200 transition-all duration-300 group cursor-pointer hover:shadow-lg hover:shadow-blue-100/50 hover:-translate-y-0.5">
                                <div>
                                    <h3 class="font-semibold text-slate-800 group-hover:text-blue-600 transition mb-1">
                                        {{ $related->title }}
                                    </h3>
                                    <p class="text-sm text-slate-500">
                                        {{ $related->ai_tool_label }} • {{ ucfirst($related->difficulty_level) }}
                                    </p>
                                </div>
                                <div
                                    class="w-10 h-10 bg-slate-100 group-hover:bg-blue-100 rounded-xl flex items-center justify-center transition">
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Back Button --}}
            <div class="mt-10 text-center">
                <a href="{{ route('prompts.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm text-slate-700 font-semibold rounded-2xl border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 cursor-pointer shadow-lg shadow-slate-200/50 hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Prompt Library
                </a>
            </div>
        </div>
    </div>
</x-layout.app>
