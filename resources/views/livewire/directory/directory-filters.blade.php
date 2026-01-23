<div class="space-y-12">
    {{-- Sector Selection --}}
    <div class="sector-matrix">
        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-6 flex items-center">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 mr-3"></span> Sector Mapping
        </h4>
        <div class="flex flex-wrap gap-2">
            @foreach ($categories as $cat)
                <button wire:click="$set('filters.category', '{{ $cat->slug }}')"
                    class="relative px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 {{ ($filters['category'] ?? '') == $cat->slug ? 'bg-indigo-600 text-white shadow-[0_0_20px_rgba(79,70,229,0.4)] border-indigo-500' : 'bg-white/5 border border-white/10 text-slate-400 hover:bg-white/10' }}">
                    {{ $cat->name }}
                    @if (($filters['category'] ?? '') == $cat->slug)
                        <span class="absolute -top-1 -right-1 flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-400"></span>
                        </span>
                    @endif
                </button>
            @endforeach
            <button wire:click="$set('filters.category', '')"
                class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 {{ ($filters['category'] ?? '') == '' ? 'bg-slate-700 text-white shadow-xl' : 'bg-white/5 border border-white/10 text-slate-400 hover:bg-white/10' }}">
                All Nodes
            </button>
        </div>
    </div>

    {{-- Parameters Matrix --}}
    @if (in_array($type, ['tools', 'learning']))
        <div>
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-6 flex items-center">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 mr-3"></span> Fiscal Logic
            </h4>
            <div class="grid grid-cols-2 gap-3">
                @foreach (['all' => 'Deep Scan', 'free' => 'Open Source', 'freemium' => 'Hybrid', 'paid' => 'Premium'] as $value => $label)
                    <button wire:click="$set('filters.pricing', '{{ $value }}')"
                        class="px-3 py-3 rounded-2xl text-[9px] font-bold uppercase tracking-wider transition-all {{ ($filters['pricing'] ?? 'all') == $value ? 'bg-cyan-500/20 border border-cyan-500/40 text-cyan-400' : 'bg-white/[0.03] border border-white/5 text-slate-500 hover:border-white/10 hover:text-white' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Difficulty Matrix --}}
    @if ($type === 'learning')
        <div>
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-6 flex items-center">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-3"></span> Level Logic
            </h4>
            <div class="space-y-2">
                @foreach (['all' => 'Universal', 'beginner' => 'Foundation', 'intermediate' => 'Standard', 'advanced' => 'Enterprise'] as $value => $label)
                    <button wire:click="$set('filters.difficulty', '{{ $value }}')"
                        class="w-full text-left px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.15em] transition-all {{ ($filters['difficulty'] ?? 'all') == $value ? 'bg-blue-600 text-white shadow-lg' : 'bg-white/[0.03] border border-white/5 text-slate-500 hover:bg-white/5' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recruitment Matrix --}}
    @if ($type === 'companies')
        <div class="pt-6 border-t border-white/5">
            <button wire:click="$toggle('filters.hiring')"
                class="group w-full flex items-center justify-between px-6 py-5 rounded-[1.8rem] transition-all {{ $filters['hiring'] ?? false ? 'bg-green-500 shadow-[0_0_30px_rgba(34,197,94,0.3)]' : 'bg-white/[0.03] border border-white/10' }}">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full {{ $filters['hiring'] ?? false ? 'bg-white/20' : 'bg-green-500/20' }} flex items-center justify-center mr-4">
                        <i
                            class="fa-solid fa-briefcase text-xs {{ $filters['hiring'] ?? false ? 'text-white' : 'text-green-500' }}"></i>
                    </div>
                    <div>
                        <div
                            class="text-[10px] font-black uppercase tracking-widest {{ $filters['hiring'] ?? false ? 'text-white' : 'text-slate-200' }}">
                            Hiring Mode</div>
                        <div
                            class="text-[8px] font-bold uppercase tracking-widest {{ $filters['hiring'] ?? false ? 'text-green-100' : 'text-slate-500' }}">
                            Active Intelligence</div>
                    </div>
                </div>
                <div class="w-6 h-6 rounded-full border border-white/20 flex items-center justify-center">
                    <div
                        class="w-2 h-2 rounded-full {{ $filters['hiring'] ?? false ? 'bg-white animate-pulse' : 'bg-slate-700' }}">
                    </div>
                </div>
            </button>
        </div>
    @endif
</div>
