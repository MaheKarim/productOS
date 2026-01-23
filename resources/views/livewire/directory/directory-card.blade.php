<div
    class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full relative">
    {{-- Featured Badge --}}
    @if ($item->is_featured && $item->pricing_model == 'paid')
        <div class="absolute top-4 right-4">
            <span
                class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold uppercase rounded leading-none border border-amber-100 flex items-center">
                <i class="fa-solid fa-star mr-1 text-[8px]"></i> Promoted
            </span>
        </div>
    @endif

    <div class="flex items-start justify-between mb-4">
        {{-- Logo --}}
        <div
            class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0">
            @if ($item->logo_path)
                <img src="{{ Storage::url($item->logo_path) }}" alt="{{ $item->name }}"
                    class="w-full h-full object-cover">
            @else
                <span class="text-lg font-bold text-slate-300">{{ substr($item->name, 0, 1) }}</span>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <div class="flex-grow mb-4">
        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-1 line-clamp-1">
            {{ $item->name }}</h3>
        <p class="text-xs text-slate-500 mb-3 line-clamp-2 min-h-[2.5em]">{{ $item->tagline }}</p>

        {{-- Meta Badges --}}
        <div class="flex flex-wrap gap-2 text-[10px] font-bold uppercase tracking-wide">
            @if ($item->pricing_model)
                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded">{{ ucfirst($item->pricing_model) }}</span>
            @endif
            @if ($item->difficulty_level)
                <span
                    class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded">{{ ucfirst($item->difficulty_level) }}</span>
            @endif
            @if ($item->is_hiring)
                <span class="px-2 py-1 bg-green-50 text-green-600 rounded">Hiring</span>
            @endif
            @if ($item->category && $item->type === 'tools')
                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded">{{ $item->category }}</span>
            @endif
        </div>
    </div>

    {{-- Footer / CTA --}}
    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
        <div class="text-xs text-slate-400 font-medium flex items-center">
            <i class="fa-regular fa-eye mr-1"></i> {{ $item->view_count }}
        </div>

        <button
            @click="fetch('/directory/track-click/{{ $item->uuid }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); window.open('{{ $item->website_url }}', '_blank');"
            class="text-sm font-bold text-slate-900 group-hover:text-blue-600 flex items-center transition-colors">
            Visit <i class="fa-solid fa-arrow-up-right-from-square ml-1.5 text-xs"></i>
        </button>
    </div>
</div>
