<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 sticky top-24">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-slate-900 text-lg">Filters</h3>
    </div>

    <div class="space-y-8">
        {{-- Category Filter --}}
        <div>
            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">Categories</h4>
            <div class="space-y-2">
                @foreach ($categories as $cat)
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="radio" wire:model.live="filters.category" value="{{ $cat->slug }}"
                            class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                        <span
                            class="text-slate-600 group-hover:text-blue-600 transition-colors text-sm">{{ $cat->name }}</span>
                    </label>
                @endforeach
                <label class="flex items-center space-x-3 cursor-pointer group">
                    <input type="radio" wire:model.live="filters.category" value=""
                        class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                    <span class="text-slate-600 group-hover:text-blue-600 transition-colors text-sm italic">All
                        Categories</span>
                </label>
            </div>
        </div>

        {{-- Pricing Filter (Tools/Learning) --}}
        @if (in_array($type, ['tools', 'learning']))
            <div>
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">Pricing</h4>
                <div class="space-y-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.pricing" value="all"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Any Price</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.pricing" value="free"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Free</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.pricing" value="freemium"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Freemium</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.pricing" value="paid"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Paid</span>
                    </label>
                </div>
            </div>
        @endif

        {{-- Difficulty (Learning) --}}
        @if ($type === 'learning')
            <div>
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">Level</h4>
                <div class="space-y-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.difficulty" value="all"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Any Level</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.difficulty" value="beginner"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Beginner</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.difficulty" value="intermediate"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Intermediate</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" wire:model.live="filters.difficulty" value="advanced"
                            class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-slate-600 text-sm">Advanced</span>
                    </label>
                </div>
            </div>
        @endif

        {{-- Hiring (Companies) --}}
        @if ($type === 'companies')
            <div>
                <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">Jobs</h4>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" wire:model.live="filters.hiring"
                        class="w-4 h-4 text-green-600 rounded focus:ring-green-500">
                    <span class="text-slate-700 font-medium text-sm">Hiring Now</span>
                </label>
            </div>
        @endif

    </div>
</div>
