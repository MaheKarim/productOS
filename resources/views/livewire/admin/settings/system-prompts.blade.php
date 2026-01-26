@section('page-title', 'System Prompts')

<div class="space-y-6">
    <!-- Header controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="relative max-w-sm w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search prompts..."
                class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-soft">
        </div>
        <button wire:click="openCreateModal"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-soft shadow-sm">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Add New Prompt
        </button>
    </div>

    <!-- Messages -->
    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg flex items-center">
            <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($prompts as $prompt)
            <div
                class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full group">
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-2">
                            <div
                                class="p-2 {{ $prompt->is_default ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600' }} rounded-lg">
                                <i data-lucide="{{ $prompt->is_default ? 'shield-check' : 'terminal' }}"
                                    class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900 line-clamp-1" title="{{ $prompt->name }}">
                                    {{ $prompt->name }}</h3>
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">{{ $prompt->type }}</span>
                            </div>
                        </div>
                        @if ($prompt->is_default)
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800">
                                Default
                            </span>
                        @endif
                    </div>

                    <p class="text-slate-500 text-sm mb-4 line-clamp-2 h-10">
                        {{ $prompt->description ?? 'No description provided.' }}</p>

                    <div
                        class="bg-slate-50 rounded-lg p-3 border border-slate-100 font-mono text-xs text-slate-600 line-clamp-3">
                        {{ $prompt->content }}
                    </div>
                </div>

                <div
                    class="px-5 py-3 bg-slate-50 border-t border-slate-100 rounded-b-xl flex justify-between items-center">
                    <span class="text-xs text-slate-400">Updated {{ $prompt->updated_at->diffForHumans() }}</span>
                    <div class="flex gap-2">
                        <button wire:click="openEditModal({{ $prompt->id }})"
                            class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-white rounded-md transition-colors"
                            title="Edit">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </button>

                        @if (!$prompt->is_default)
                            <button wire:click="delete({{ $prompt->id }})"
                                wire:confirm="Are you sure? This cannot be undone."
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-white rounded-md transition-colors"
                                title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px] transition-opacity" wire:click="closeModal"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div
                    class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-3xl sm:w-full animate-in fade-in zoom-in-95 duration-200 border border-slate-100">

                    <!-- Header -->
                    <div class="bg-white px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900" id="modal-title">
                                {{ $editingPrompt ? 'Edit System Prompt' : 'Create New System Prompt' }}
                            </h3>
                            <p class="text-sm text-slate-500 mt-0.5">Define instructions for the AI analysis engine.</p>
                        </div>
                        <button wire:click="closeModal" class="text-slate-400 hover:text-slate-500 transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-slate-700">Prompt Name</label>
                                <input type="text" wire:model="form.name" placeholder="e.g., Marketing Analysis"
                                    class="block w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-soft">
                                @error('form.name')
                                    <span class="text-rose-500 text-xs flex items-center mt-1"><i data-lucide="alert-circle"
                                            class="w-3 h-3 mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="space-y-1.5">
                                <label class="block text-sm font-medium text-slate-700">Description</label>
                                <input type="text" wire:model="form.description"
                                    placeholder="Brief summary of purpose..."
                                    class="block w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-soft">
                                @error('form.description')
                                    <span class="text-rose-500 text-xs flex items-center mt-1"><i data-lucide="alert-circle"
                                            class="w-3 h-3 mr-1"></i>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Prompt Editor -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-slate-700">System Instructions</label>
                                <span class="text-xs font-mono text-slate-400 bg-slate-100 px-2 py-0.5 rounded">Markdown
                                    Supported</span>
                            </div>
                            <div class="relative group">
                                <textarea wire:model="form.content" rows="12"
                                    class="block w-full p-4 bg-slate-900 border border-slate-800 rounded-xl text-slate-50 font-mono text-sm leading-relaxed placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-soft resize-y theme-scroll"
                                    placeholder="You are an expert analyzer..."></textarea>
                                <!-- Editor decorations -->
                                <div
                                    class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                    <div class="w-2 h-2 rounded-full bg-slate-700"></div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500">
                                <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                                For JSON output, explicitly specify the structure using <code>{json}</code> in your
                                prompt.
                            </p>
                            @error('form.content')
                                <span class="text-rose-500 text-xs flex items-center mt-1"><i data-lucide="alert-circle"
                                        class="w-3 h-3 mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-end items-center gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-medium text-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500/20 transition-soft">
                            Cancel
                        </button>
                        <button type="button" wire:click="save" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-soft shadow-lg shadow-indigo-500/30 disabled:opacity-70 disabled:cursor-not-allowed">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                            {{ $editingPrompt ? 'Save Changes' : 'Create Prompt' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
