@section('page-title', 'New Video Analysis')

<div class="max-w-5xl mx-auto space-y-6">
    <!-- Back Link -->
    <div>
        <a href="{{ route('admin.videos.index') }}"
            class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
            Back to Library
        </a>
    </div>

    @if (session()->has('message'))
        <div
            class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                        <i data-lucide="youtube" class="w-5 h-5 mr-2 text-red-500"></i>
                        Import Video
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Enter a YouTube URL to fetch metadata and start AI analysis.
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <form wire:submit.prevent="save" id="upload-form">
                        <!-- URL Input -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-slate-700">YouTube URL</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i data-lucide="link" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <input type="text" wire:model.blur="url"
                                    placeholder="https://youtube.com/watch?v=..."
                                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-soft">
                            </div>
                            @error('url')
                                <p class="text-rose-500 text-xs flex items-center mt-1">
                                    <i data-lucide="alert-circle" class="w-3 h-3 mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            <!-- Loading State for URL fetch -->
                            <div wire:loading wire:target="url"
                                class="text-indigo-600 text-xs font-medium flex items-center mt-2 animate-pulse">
                                <i data-lucide="loader-2" class="w-3.5 h-3.5 mr-1.5 animate-spin"></i>
                                Fetching video metadata...
                            </div>

                            @if ($error)
                                <div
                                    class="text-rose-600 text-sm mt-2 flex items-start bg-rose-50 p-3 rounded-lg border border-rose-100">
                                    <i data-lucide="alert-triangle" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                                    {{ $error }}
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                            <!-- AI Provider -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">AI Model</label>
                                <div class="relative">
                                    <select wire:model="ai_provider_id"
                                        class="block w-full pl-3 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm appearance-none cursor-pointer transition-soft">
                                        <option value="">Select Provider</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->name }}
                                                ({{ $provider->default_model ?? 'Default' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                                    </div>
                                </div>
                                @error('ai_provider_id')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Topic Override -->
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-slate-700">Topic Category</label>
                                <div class="relative">
                                    <select wire:model="topic_id"
                                        class="block w-full pl-3 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm appearance-none cursor-pointer transition-soft">
                                        <option value="">Auto-Detect (AI)</option>
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Access Level -->
                        <div class="pt-4 space-y-3">
                            <label class="block text-sm font-medium text-slate-700">Content Access</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer relative group">
                                    <input type="radio" wire:model="access_level" value="free" class="peer sr-only">
                                    <div
                                        class="p-4 rounded-xl border-2 border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 transition-all flex items-center">
                                        <div
                                            class="w-5 h-5 rounded-full border-2 border-slate-300 mr-3 peer-checked:border-indigo-500 peer-checked:bg-indigo-500 flex items-center justify-center">
                                            <div
                                                class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-slate-900">Free Content</span>
                                            <span class="block text-xs text-slate-500">Available to everyone</span>
                                        </div>
                                        <i data-lucide="unlock"
                                            class="w-5 h-5 text-slate-400 ml-auto peer-checked:text-indigo-500"></i>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="radio" wire:model="access_level" value="premium"
                                        class="peer sr-only">
                                    <div
                                        class="p-4 rounded-xl border-2 border-slate-200 bg-white hover:bg-slate-50 peer-checked:border-amber-500 peer-checked:bg-amber-50/50 transition-all flex items-center">
                                        <div
                                            class="w-5 h-5 rounded-full border-2 border-slate-300 mr-3 peer-checked:border-amber-500 peer-checked:bg-amber-500 flex items-center justify-center">
                                            <div
                                                class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100">
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-slate-900">Premium Only</span>
                                            <span class="block text-xs text-slate-500">Subscribers only</span>
                                        </div>
                                        <i data-lucide="crown"
                                            class="w-5 h-5 text-slate-400 ml-auto peer-checked:text-amber-500"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- System Prompt -->
                        <div class="pt-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-slate-700">Analysis Instructions</label>
                            </div>

                            <!-- Prompt Selector -->
                            <div class="relative">
                                <select wire:model.live="system_prompt_id"
                                    class="block w-full pl-3 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm appearance-none cursor-pointer transition-soft">
                                    <option value="">Custom Instructions</option>
                                    @foreach ($systemPrompts as $prompt)
                                        <option value="{{ $prompt->id }}">{{ $prompt->name }}
                                            {{ $prompt->is_default ? '(Default)' : '' }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                                </div>
                            </div>

                            <!-- Content Editor -->
                            <div class="relative">
                                <textarea wire:model="system_prompt" rows="5" placeholder="Enter custom AI instructions here..."
                                    class="block w-full p-3 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm font-mono text-xs transition-soft"></textarea>
                                <div class="absolute bottom-2 right-2 text-[10px] text-slate-400">
                                    Markdown Supported
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-6 bg-slate-50/50 border-t border-slate-200/60 flex items-center justify-between">
                    <button type="button" onclick="history.back()"
                        class="px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-medium text-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500/20 transition-soft">
                        Cancel
                    </button>
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-soft shadow-lg shadow-indigo-500/30 disabled:opacity-70 disabled:cursor-not-allowed">
                        <i data-lucide="sparkles" class="w-4 h-4 mr-2"></i>
                        Start Analysis
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Column -->
        <div class="lg:col-span-1">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Preview</h3>

            @if ($metadata)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden sticky top-6">
                    <!-- Thumbnail -->
                    <div class="relative aspect-video bg-black">
                        <img src="{{ $metadata['thumbnail_url'] }}" alt="Thumbnail"
                            class="w-full h-full object-cover">
                        <div
                            class="absolute bottom-2 right-2 bg-black/80 text-white text-xs font-bold px-1.5 py-0.5 rounded">
                            {{ $metadata['duration'] }}
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <h4 class="font-bold text-slate-900 leading-snug text-lg line-clamp-2">
                                {{ $metadata['title'] }}</h4>
                            <div class="flex items-center mt-3">
                                @if (isset($metadata['channel_logo']))
                                    <img src="{{ $metadata['channel_logo'] }}"
                                        class="w-8 h-8 rounded-full mr-2.5 border border-slate-200">
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-slate-900">{{ $metadata['channel_name'] }}
                                    </div>
                                    <div class="text-xs text-slate-500">{{ $metadata['view_count'] }} views</div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                            <div class="flex items-center text-xs text-slate-500">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 mr-2"></i>
                                Uploaded: {{ \Carbon\Carbon::parse($metadata['upload_date'])->format('M d, Y') }}
                            </div>
                            <div class="flex items-center text-xs text-slate-500">
                                <i data-lucide="tag" class="w-3.5 h-3.5 mr-2"></i>
                                ID: <code
                                    class="bg-slate-100 px-1 py-0.5 rounded ml-1">{{ $metadata['video_id_str'] }}</code>
                            </div>
                        </div>

                        <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                            <div class="flex items-start">
                                <i data-lucide="info" class="w-4 h-4 text-indigo-500 mt-0.5 mr-2 flex-shrink-0"></i>
                                <p class="text-xs text-indigo-700 leading-relaxed">
                                    Ready to process. We'll fetch the transcript and generate AI analysis immediately.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300 p-8 flex flex-col items-center justify-center text-center h-64 sticky top-6">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm mb-3">
                        <i data-lucide="monitor-play" class="w-6 h-6 text-slate-400"></i>
                    </div>
                    <h4 class="text-slate-900 font-medium text-sm">No Video Selected</h4>
                    <p class="text-slate-500 text-xs mt-1 max-w-[200px]">
                        Paste a valid YouTube URL in the form to see a preview here.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:updated', () => {
            lucide.createIcons();
        });
    </script>
@endpush
