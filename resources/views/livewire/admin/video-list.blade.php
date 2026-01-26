@section('page-title', 'Video Library')

<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-2">
            <h2 class="text-lg font-medium text-slate-900">Manage Videos</h2>
            <span
                class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">{{ $videos->total() }}</span>
        </div>
        <a href="{{ route('admin.videos.upload') }}"
            class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-soft shadow-lg shadow-indigo-500/30">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Add New Video
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-200/60">
        <!-- Search -->
        <div class="md:col-span-6 relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="search"
                    class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Search by title, channel or ID..."
                class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm transition-soft">
        </div>

        <!-- Status Filter -->
        <div class="md:col-span-3 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="filter" class="w-4 h-4 text-slate-400"></i>
            </div>
            <select wire:model.live="status"
                class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm appearance-none transition-soft cursor-pointer">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
            </div>
        </div>

        <!-- Access Level Filter -->
        <div class="md:col-span-3 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
            </div>
            <select wire:model.live="accessLevel"
                class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-700 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 sm:text-sm appearance-none transition-soft cursor-pointer">
                <option value="">All Access Levels</option>
                <option value="free">Free Content</option>
                <option value="premium">Premium Only</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
            </div>
        </div>
    </div>

    <!-- Content Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50/80 backdrop-blur">
                    <tr>
                        <th scope="col"
                            class="pl-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Content</th>
                        <th scope="col"
                            class="px-4 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-32">
                            Status</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Metadata</th>
                        <th scope="col"
                            class="px-4 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Settings</th>
                        <th scope="col"
                            class="pr-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider w-24">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($videos as $video)
                        <tr class="group hover:bg-slate-50 transition-colors duration-200">
                            <!-- Content -->
                            <td class="pl-6 py-4">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="relative flex-shrink-0 w-32 aspect-video bg-slate-100 rounded-lg overflow-hidden border border-slate-200 shadow-sm group-hover:shadow-md transition-shadow">
                                        <img class="w-full h-full object-cover" src="{{ $video->thumbnail_url }}"
                                            alt="{{ $video->title }}">
                                        <div
                                            class="absolute bottom-1 right-1 bg-black/80 backdrop-blur-[2px] text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">
                                            {{ $video->duration }}
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm font-semibold text-slate-900 leading-tight mb-1 line-clamp-2"
                                            title="{{ $video->title }}">
                                            {{ $video->title }}
                                        </h3>
                                        <div class="flex items-center text-xs text-slate-500 gap-2 mb-1.5">
                                            <span class="flex items-center truncate max-w-[150px]"
                                                title="{{ $video->channel_name }}">
                                                <i data-lucide="youtube"
                                                    class="w-3 h-3 mr-1 text-red-500 fill-current"></i>
                                                {{ $video->channel_name }}
                                            </span>
                                            <span class="w-0.5 h-0.5 rounded-full bg-slate-300"></span>
                                            <span>{{ $video->upload_date->format('M d, Y') }}</span>
                                        </div>
                                        <div
                                            class="inline-flex items-center text-[10px] text-slate-400 font-mono bg-slate-50 px-1.5 py-0.5 rounded border border-slate-100">
                                            ID: {{ $video->video_id_str }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-4 text-center">
                                @php
                                    $statusConfig = match ($video->processing_status) {
                                        'completed' => [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-700',
                                            'border' => 'border-emerald-200',
                                            'icon' => 'check-circle',
                                        ],
                                        'processing' => [
                                            'bg' => 'bg-indigo-50',
                                            'text' => 'text-indigo-700',
                                            'border' => 'border-indigo-200',
                                            'icon' => 'loader-2',
                                        ],
                                        'failed' => [
                                            'bg' => 'bg-rose-50',
                                            'text' => 'text-rose-700',
                                            'border' => 'border-rose-200',
                                            'icon' => 'x-circle',
                                        ],
                                        default => [
                                            'bg' => 'bg-slate-50',
                                            'text' => 'text-slate-700',
                                            'border' => 'border-slate-200',
                                            'icon' => 'clock',
                                        ],
                                    };
                                @endphp
                                <div class="inline-flex items-center justify-center p-1.5 rounded-lg border {{ $statusConfig['border'] }} {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}"
                                    title="Status: {{ ucfirst($video->processing_status) }}">
                                    <i data-lucide="{{ $statusConfig['icon'] }}"
                                        class="w-5 h-5 {{ $video->processing_status === 'processing' ? 'animate-spin' : '' }}"></i>
                                </div>
                            </td>

                            <!-- Metadata -->
                            <td class="px-4 py-4">
                                <div class="space-y-2">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($video->topics->take(2) as $topic)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-white text-slate-600 border border-slate-200 shadow-sm">
                                                {{ $topic->name }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-slate-400 italic">No topics</span>
                                        @endforelse
                                        @if ($video->topics->count() > 2)
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-medium bg-slate-50 text-slate-500 border border-slate-200">
                                                +{{ $video->topics->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-500">
                                        <span class="flex items-center" title="Views">
                                            <i data-lucide="eye" class="w-3 h-3 mr-1"></i>
                                            {{ number_format($video->view_count) }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Settings -->
                            <td class="px-4 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <div class="p-1 bg-indigo-50 rounded text-indigo-600">
                                            <i data-lucide="brain-circuit" class="w-3 h-3"></i>
                                        </div>
                                        <span
                                            class="text-xs font-medium text-slate-700">{{ $video->aiProvider->name ?? 'Default' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        @if ($video->access_level === 'premium')
                                            <div class="p-1 bg-amber-50 rounded text-amber-600">
                                                <i data-lucide="crown" class="w-3 h-3"></i>
                                            </div>
                                            <span class="text-xs font-medium text-amber-700">Premium</span>
                                        @else
                                            <div class="p-1 bg-slate-50 rounded text-slate-500">
                                                <i data-lucide="unlock" class="w-3 h-3"></i>
                                            </div>
                                            <span class="text-xs font-medium text-slate-600">Free</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="pr-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.videos.show', $video) }}"
                                        class="p-2 bg-white text-slate-400 border border-slate-200 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 rounded-lg transition-all shadow-sm"
                                        title="View Analysis">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>

                                    <button wire:click="delete({{ $video->id }})"
                                        wire:confirm="Are you sure? This cannot be undone."
                                        class="p-2 bg-white text-slate-400 border border-slate-200 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 rounded-lg transition-all shadow-sm"
                                        title="Delete Video">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <i data-lucide="film" class="w-8 h-8 text-slate-300"></i>
                                    </div>
                                    <h3 class="text-slate-900 font-semibold mb-1">No videos found</h3>
                                    <p class="text-slate-500 text-sm mb-6">Get started by analyzing your first YouTube
                                        video.</p>
                                    <a href="{{ route('admin.videos.upload') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        New Analysis
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $videos->links() }}
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
