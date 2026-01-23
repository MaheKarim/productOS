<div>
    {{-- Top Bar --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div class="mb-4 md:mb-0">
            <span class="text-slate-600">Showing <span class="font-bold text-slate-900">{{ $this->items->total() }}</span>
                resources</span>
        </div>

        <div class="flex items-center space-x-4">
            {{-- Search --}}
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search in this category..."
                    class="pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </div>

            {{-- Sort --}}
            <select wire:model.live="sort"
                class="pl-3 pr-8 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="rating">Top Rated</option>
                <option value="featured">Featured First</option>
                <option value="popular">Most Popular</option>
                <option value="newest">Newest Added</option>
                <option value="az">A-Z</option>
            </select>
        </div>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($this->items as $item)
            <livewire:directory.directory-card :item="$item" :key="$item->id" />
        @empty
            <div class="col-span-full py-12 text-center text-slate-500">
                <div class="mb-4 text-4xl text-slate-200">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <p class="text-lg font-medium text-slate-900">No resources found</p>
                <p class="text-sm">Try adjusting your filters or search query.</p>
                <button wire:click="$set('filters', [])"
                    class="mt-4 text-blue-600 hover:text-blue-700 font-medium text-sm">Clear Filters</button>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $this->items->links() }}
    </div>
</div>
