<div>
    {{-- Operation Bar --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
        <div class="mb-4 md:mb-0">
            <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] flex items-center">
                <span class="w-2 h-2 rounded-full bg-indigo-500 mr-3 animate-pulse"></span>
                Local Registry: <span class="ml-2 text-white">{{ $this->items->total() }} Entities</span>
            </h4>
        </div>

        <div class="flex items-center space-x-4 w-full md:w-auto">
            {{-- Augmented Search --}}
            <div class="relative flex-1 md:flex-initial">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Initialize Deep Scan..."
                    class="w-full md:w-72 bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl py-3 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-all">
                <i
                    class="fa-solid fa-satellite-dish absolute left-4 top-1/2 -translate-y-1/2 text-indigo-400 text-sm"></i>
            </div>

            {{-- Logic Sort --}}
            <select wire:model.live="sort"
                class="bg-white/[0.03] backdrop-blur-xl border border-white/10 rounded-2xl py-3 pl-4 pr-10 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/30 cursor-pointer appearance-none">
                <option value="rating" class="bg-[#0F172A]">Top Tier</option>
                <option value="featured" class="bg-[#0F172A]">High Priority</option>
                <option value="popular" class="bg-[#0F172A]">Most Accessed</option>
                <option value="newest" class="bg-[#0F172A]">Recent Entry</option>
                <option value="az" class="bg-[#0F172A]">Linear A-Z</option>
            </select>
        </div>
    </div>

    {{-- Intelligence Matrix (Grid) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($this->items as $item)
            <livewire:directory.directory-card :item="$item" :key="$item->id" />
        @empty
            <div class="col-span-full py-24 text-center group">
                <div class="relative inline-block mb-8">
                    <div
                        class="absolute -inset-4 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all">
                    </div>
                    <i
                        class="fa-solid fa-microchip text-6xl text-slate-800 relative z-10 group-hover:text-indigo-400/30 transition-colors"></i>
                </div>
                <h3 class="text-2xl font-black text-white mb-2 tracking-tight">Zero Results Initialized</h3>
                <p class="text-slate-500 font-light mb-8 max-w-sm mx-auto">The matrix could not locate any entities
                    matching your current logic parameters.</p>
                <button wire:click="$set('filters', [])"
                    class="px-8 py-3 bg-white/[0.05] border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest text-indigo-400 hover:bg-white hover:text-black transition-all">
                    Reset Matrix Logic
                </button>
            </div>
        @endforelse
    </div>

    {{-- Data Pagination --}}
    <div class="mt-16">
        {{ $this->items->links() }}
    </div>
</div>
