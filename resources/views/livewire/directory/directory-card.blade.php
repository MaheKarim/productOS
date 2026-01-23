<div
    class="relative bg-white/[0.03] backdrop-blur-2xl border border-white/5 rounded-[2.5rem] p-8 hover:bg-white/[0.07] hover:border-white/10 transition-all duration-500 group flex flex-col h-full overflow-hidden hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.5)]">

    {{-- High-fidelity Ambient Glow --}}
    <div
        class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-500/5 group-hover:bg-indigo-500/20 blur-2xl transition-all duration-500 rounded-full">
    </div>

    {{-- Promoted Unit Badge --}}
    @if ($item->is_featured && $item->pricing_model == 'paid')
        <div class="absolute top-6 right-6 z-20">
            <span
                class="px-3 py-1 bg-amber-500/10 text-amber-500 text-[8px] font-black uppercase tracking-[0.2em] rounded-full border border-amber-500/20 shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                <i class="fa-solid fa-bolt mr-1.5 animate-pulse text-[7px]"></i> Verified
            </span>
        </div>
    @endif

    <div class="flex items-start justify-between mb-8 relative z-10">
        {{-- Identity Module --}}
        <div
            class="w-20 h-20 rounded-[1.3rem] bg-slate-900/80 p-0.5 border border-white/5 shadow-inner group-hover:scale-110 transition-transform duration-500">
            @if ($item->logo_path)
                <img src="{{ Storage::url($item->logo_path) }}" alt="{{ $item->name }}"
                    class="w-full h-full object-cover rounded-[1.2rem]">
            @else
                <div class="w-full h-full flex items-center justify-center bg-indigo-500/5 rounded-[1.2rem]">
                    <span
                        class="text-2xl font-black text-indigo-400 group-hover:text-indigo-300 transition-colors uppercase">{{ substr($item->name, 0, 1) }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Data Block --}}
    <div class="flex-grow mb-8 relative z-10">
        <div class="flex items-center space-x-2 text-[9px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-3">
            <span>{{ ucfirst($item->type) }}</span>
            <span class="w-1 h-1 rounded-full bg-slate-800"></span>
            <span class="text-slate-500">{{ $item->category }}</span>
        </div>

        <h3
            class="text-2xl font-bold text-white group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-slate-400 transition-all mb-2 tracking-tight">
            {{ $item->name }}</h3>
        <p
            class="text-sm text-slate-400/80 font-light leading-relaxed mb-6 line-clamp-2 min-h-[3em] group-hover:text-slate-300 transition-colors">
            {{ $item->tagline }}</p>

        {{-- Capability Tags --}}
        <div class="flex flex-wrap gap-2">
            @if ($item->pricing_model)
                <span
                    class="px-2.5 py-1 bg-white/[0.05] border border-white/5 text-slate-400 text-[9px] font-black uppercase tracking-wider rounded-lg">{{ ucfirst($item->pricing_model) }}</span>
            @endif
            @if ($item->difficulty_level)
                <span
                    class="px-2.5 py-1 bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-[9px] font-black uppercase tracking-wider rounded-lg">{{ ucfirst($item->difficulty_level) }}</span>
            @endif
            @if ($item->is_hiring)
                <span
                    class="px-2.5 py-1 bg-green-500/10 border border-green-500/20 text-green-400 text-[9px] font-black uppercase tracking-wider rounded-lg animate-pulse">Hiring</span>
            @endif
        </div>
    </div>

    {{-- Action Matrix --}}
    <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between relative z-10">
        <div
            class="text-[10px] text-slate-500 font-bold flex items-center group-hover:text-slate-400 transition-colors">
            <i class="fa-solid fa-chart-line mr-2 text-indigo-500/50"></i> {{ number_format($item->view_count) }}
            Engagements
        </div>

        <button
            @click="fetch('/directory/track-click/{{ $item->uuid }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); window.open('{{ $item->website_url }}', '_blank');"
            class="group/btn relative px-5 py-2.5 text-xs font-black uppercase tracking-widest text-white transition-all overflow-hidden rounded-xl bg-white/[0.05] hover:bg-white text-slate-900 group-hover:text-slate-900 group-hover:bg-white transition-all duration-300">
            <span class="relative z-10 flex items-center">
                Initialize <i
                    class="fa-solid fa-arrow-right-long ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
            </span>
        </button>
    </div>
</div>
