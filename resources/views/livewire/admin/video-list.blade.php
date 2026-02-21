@section('page-title', 'Video Library')

<div class="space-y-6" x-data="{
    showDeleteModal: false,
    deleteVideoId: null,
    deleteVideoTitle: '',
    openDeleteModal(id, title) {
        this.deleteVideoId = id;
        this.deleteVideoTitle = title;
        this.showDeleteModal = true;
    },
    closeDeleteModal() {
        this.showDeleteModal = false;
        this.deleteVideoTitle = '';
        this.deleteVideoId = null;
    },
    confirmDelete() {
        $wire.delete(this.deleteVideoId);
        this.closeDeleteModal();
    }
}">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/25">
                <i data-lucide="video" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-slate-900 tracking-tight">Video Library</h2>
                <p class="text-sm text-slate-500">{{ $videos->total() }} videos in your collection</p>
            </div>
        </div>
        <a href="{{ route('admin.videos.upload') }}"
            class="group inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl font-medium text-sm text-white shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4 transition-transform group-hover:rotate-90 duration-200"></i>
            Add New Video
        </a>
    </div>

    <!-- Filters & Search Card -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/80 shadow-sm shadow-slate-200/50 p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Search -->
            <div class="md:col-span-6 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="search"
                        class="w-4 h-4 text-slate-400 group-focus-within:text-blue-500 transition-colors duration-200"></i>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Search by title, channel or ID..."
                    class="block w-full pl-11 pr-4 py-3 border-0 ring-1 ring-slate-200 rounded-xl bg-slate-50/50 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:bg-white sm:text-sm transition-all duration-200">
            </div>

            <!-- Status Filter -->
            <div class="md:col-span-3 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i data-lucide="activity" class="w-4 h-4 text-slate-400"></i>
                </div>
                <select wire:model.live="status"
                    class="block w-full pl-11 pr-10 py-3 border-0 ring-1 ring-slate-200 rounded-xl bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:bg-white sm:text-sm appearance-none transition-all duration-200 cursor-pointer">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="failed">Failed</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                </div>
            </div>

            <!-- Access Level Filter -->
            <div class="md:col-span-3 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i data-lucide="shield" class="w-4 h-4 text-slate-400"></i>
                </div>
                <select wire:model.live="accessLevel"
                    class="block w-full pl-11 pr-10 py-3 border-0 ring-1 ring-slate-200 rounded-xl bg-slate-50/50 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:bg-white sm:text-sm appearance-none transition-all duration-200 cursor-pointer">
                    <option value="">All Access</option>
                    <option value="free">Free Content</option>
                    <option value="premium">Premium Only</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto" style="max-width: 100%;">
            <table class="w-full" style="min-width: 900px;">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th scope="col" class="px-6 py-4 text-left">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Content</span>
                        </th>
                        <th scope="col" class="px-4 py-4 text-center">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</span>
                        </th>
                        <th scope="col" class="px-4 py-4 text-left">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Metadata</span>
                        </th>
                        <th scope="col" class="px-4 py-4 text-left">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Settings</span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($videos as $video)
                        <tr class="group hover:bg-blue-50/30 transition-colors duration-150">
                            <!-- Content Cell -->
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-4">
                                    <!-- Thumbnail -->
                                    <div
                                        class="relative flex-shrink-0 w-36 aspect-video rounded-xl overflow-hidden ring-1 ring-slate-200/80 shadow-sm group-hover:ring-blue-300/50 group-hover:shadow-md transition-all duration-200">
                                        <img class="w-full h-full object-cover" src="{{ $video->thumbnail_url }}"
                                            alt="{{ $video->title }}">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        </div>
                                        <div
                                            class="absolute bottom-1.5 right-1.5 bg-black/80 backdrop-blur-sm text-white text-[10px] font-semibold px-2 py-0.5 rounded-md">
                                            {{ $video->duration }}
                                        </div>
                                        <a href="{{ route('admin.videos.show', $video) }}"
                                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 cursor-pointer">
                                            <div
                                                class="w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-lg">
                                                <i data-lucide="play"
                                                    class="w-5 h-5 text-slate-900 fill-current ml-0.5"></i>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Info -->
                                    <div class="min-w-0 flex-1 space-y-2">
                                        <h3 class="text-sm font-semibold text-slate-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors duration-200"
                                            title="{{ $video->title }}">
                                            {{ $video->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <span class="flex items-center gap-1.5 truncate max-w-[140px]"
                                                title="{{ $video->channel_name }}">
                                                <i data-lucide="youtube" class="w-3.5 h-3.5 text-red-500"></i>
                                                {{ $video->channel_name }}
                                            </span>
                                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                            <span
                                                class="text-slate-400">{{ $video->upload_date->format('M d, Y') }}</span>
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1.5 text-[10px] text-slate-400 font-mono bg-slate-100/80 px-2 py-1 rounded-md">
                                            <i data-lucide="hash" class="w-2.5 h-2.5"></i>
                                            {{ $video->video_id_str }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status Cell -->
                            <td class="px-4 py-4 text-center">
                                @php
                                    $statusConfig = match ($video->processing_status) {
                                        'completed' => [
                                            'gradient' => 'from-emerald-500 to-green-600',
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-700',
                                            'ring' => 'ring-emerald-500/20',
                                            'icon' => 'check-circle',
                                            'label' => 'Completed',
                                        ],
                                        'processing' => [
                                            'gradient' => 'from-blue-500 to-indigo-600',
                                            'bg' => 'bg-blue-50',
                                            'text' => 'text-blue-700',
                                            'ring' => 'ring-blue-500/20',
                                            'icon' => 'loader-2',
                                            'label' => 'Processing',
                                        ],
                                        'failed' => [
                                            'gradient' => 'from-rose-500 to-red-600',
                                            'bg' => 'bg-rose-50',
                                            'text' => 'text-rose-700',
                                            'ring' => 'ring-rose-500/20',
                                            'icon' => 'x-circle',
                                            'label' => 'Failed',
                                        ],
                                        default => [
                                            'gradient' => 'from-slate-400 to-slate-500',
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-600',
                                            'ring' => 'ring-slate-500/20',
                                            'icon' => 'clock',
                                            'label' => 'Pending',
                                        ],
                                    };
                                @endphp
                                <div class="inline-flex flex-col items-center gap-1.5">
                                    <div
                                        class="flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br {{ $statusConfig['gradient'] }} shadow-sm">
                                        <i data-lucide="{{ $statusConfig['icon'] }}"
                                            class="w-4.5 h-4.5 text-white {{ $video->processing_status === 'processing' ? 'animate-spin' : '' }}"></i>
                                    </div>
                                    <span
                                        class="text-[10px] font-medium {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</span>
                                </div>
                            </td>

                            <!-- Metadata Cell -->
                            <td class="px-4 py-4">
                                <div class="space-y-2.5">
                                    <!-- Topics -->
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($video->topics->take(2) as $topic)
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-medium bg-gradient-to-r from-slate-50 to-slate-100 text-slate-600 ring-1 ring-slate-200/80">
                                                {{ $topic->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400 italic">No topics</span>
                                        @endforelse
                                        @if ($video->topics->count() > 2)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-medium bg-blue-50 text-blue-600 ring-1 ring-blue-200/80">
                                                +{{ $video->topics->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Views -->
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span class="font-medium">{{ number_format($video->view_count) }}</span>
                                        <span class="text-slate-400">views</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Settings Cell -->
                            <td class="px-4 py-4">
                                <div class="flex flex-col gap-2.5">
                                    <!-- AI Provider -->
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="flex items-center justify-center w-7 h-7 rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 shadow-sm">
                                                <i data-lucide="brain-circuit" class="w-3.5 h-3.5 text-white"></i>
                                            </div>
                                            <span
                                                class="text-xs font-semibold text-slate-700">{{ $video->aiProvider->name ?? 'Default' }}</span>
                                        </div>
                                        @if ($video->aiProvider?->default_model)
                                            <div class="ml-9">
                                                <span
                                                    class="inline-flex items-center gap-1 text-[10px] font-medium text-slate-500 bg-slate-100/80 px-2 py-0.5 rounded-md truncate max-w-[130px]"
                                                    title="{{ $video->aiProvider->default_model }}">
                                                    <i data-lucide="cpu" class="w-2.5 h-2.5"></i>
                                                    {{ $video->aiProvider->default_model }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Access Level -->
                                    <div class="flex items-center gap-2">
                                        @if ($video->access_level === 'premium')
                                            <div
                                                class="flex items-center justify-center w-7 h-7 rounded-lg bg-gradient-to-br from-amber-400 to-orange-500 shadow-sm">
                                                <i data-lucide="crown" class="w-3.5 h-3.5 text-white"></i>
                                            </div>
                                            <span class="text-xs font-semibold text-amber-700">Premium</span>
                                        @else
                                            <div
                                                class="flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 ring-1 ring-slate-200">
                                                <i data-lucide="unlock" class="w-3.5 h-3.5 text-slate-500"></i>
                                            </div>
                                            <span class="text-xs font-medium text-slate-600">Free</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Actions Cell -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Retry Button (only for failed) --}}
                                    @if ($video->processing_status === 'failed')
                                        <button wire:click="retry({{ $video->id }})"
                                            wire:confirm="Retry processing this video?"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-rose-500 text-white shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 cursor-pointer"
                                            title="Retry Processing">
                                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    {{-- View Analysis --}}
                                    <a href="{{ route('admin.videos.show', $video) }}"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white ring-1 ring-slate-200 text-slate-500 hover:text-blue-600 hover:ring-blue-300 hover:bg-blue-50 shadow-sm hover:shadow transition-all duration-200 cursor-pointer"
                                        title="View Details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>

                                    {{-- Delete Video - Opens Modal --}}
                                    <button
                                        @click="openDeleteModal({{ $video->id }}, {{ \Illuminate\Support\Js::from($video->title) }})"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white ring-1 ring-slate-200 text-slate-500 hover:text-rose-600 hover:ring-rose-300 hover:bg-rose-50 shadow-sm hover:shadow transition-all duration-200 cursor-pointer"
                                        title="Delete Video">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="max-w-sm mx-auto">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-slate-100 to-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-5 ring-1 ring-slate-200/80">
                                        <i data-lucide="video-off" class="w-10 h-10 text-slate-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-900 mb-2">No videos found</h3>
                                    <p class="text-slate-500 text-sm mb-6">Get started by analyzing your first YouTube
                                        video to unlock AI-powered insights.</p>
                                    <a href="{{ route('admin.videos.upload') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition-all duration-200 cursor-pointer">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                        Add Your First Video
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($videos->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $videos->links(data: ['wire:navigate' => true]) }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal (shadcn Dialog Pattern) -->
    <template x-teleport="body">
        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="closeDeleteModal()" style="display: none;">

            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeDeleteModal()"></div>

            <!-- Modal Content -->
            <div x-show="showDeleteModal" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/50 overflow-hidden">

                <!-- Modal Header -->
                <div class="relative px-6 pt-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 shadow-lg shadow-rose-500/25 flex-shrink-0">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-slate-900">Delete Video</h3>
                            <p class="mt-1 text-sm text-slate-500">This action cannot be undone.</p>
                        </div>
                        <button @click="closeDeleteModal()"
                            class="flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 pb-4">
                    <div class="p-4 bg-rose-50/50 rounded-xl ring-1 ring-rose-100">
                        <p class="text-sm text-slate-700">
                            Are you sure you want to delete
                            <span class="font-semibold text-slate-900 break-words" x-text="deleteVideoTitle"></span>?
                        </p>
                        <p class="mt-2 text-xs text-rose-600">All associated data including AI analysis will be
                            permanently removed.</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button @click="closeDeleteModal()"
                        class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-white rounded-xl ring-1 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300 transition-all duration-200 cursor-pointer">
                        Cancel
                    </button>
                    <button @click="confirmDelete()"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-rose-500 to-red-600 rounded-xl shadow-md shadow-rose-500/25 hover:shadow-lg hover:shadow-rose-500/30 hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
                        <span class="flex items-center gap-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Delete Video
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:updated', () => {
            lucide.createIcons();
        });

        // Handle notification events
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (event) => {
                const type = event.type || 'success';
                const message = event.message || 'Operation completed';

                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg transform transition-all duration-300 translate-x-full ${
                    type === 'success' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center gap-3">
                        <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="w-5 h-5"></i>
                        <span class="font-medium">${message}</span>
                    </div>
                `;

                document.body.appendChild(notification);
                lucide.createIcons();

                // Animate in
                requestAnimationFrame(() => {
                    notification.classList.remove('translate-x-full');
                });

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            });
        });
    </script>
@endpush
@push('styles')
    <style>
        .notification-enter-active,
        .notification-leave-active {
            transition: all 0.3s ease;
        }

        .notification-enter-from,
        .notification-leave-to {
            opacity: 0;
            transform: translateX(100%);
        }
    </style>
@endpush
