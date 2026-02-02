{{-- Trusted Marquee Section --}}
<section class="py-10 bg-slate-50 border-y border-slate-200 overflow-hidden">
    <div class="relative w-full">
        <div class="absolute z-10 top-0 left-0 h-full w-24 bg-gradient-to-r from-slate-50 to-transparent"></div>
        <div class="absolute z-10 top-0 right-0 h-full w-24 bg-gradient-to-l from-slate-50 to-transparent"></div>

        <div class="flex whitespace-nowrap overflow-hidden group">
            <div class="flex animate-marquee gap-16 px-8 items-center">
                {{-- Content duplicated for infinite scroll effect --}}
                @for ($i = 0; $i < 2; $i++)
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Microsoft</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Google</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Spotify</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Amazon</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Airbnb</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Uber</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Atlassian</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Notion</span>
                    </div>
                @endfor
            </div>
            <div class="flex animate-marquee gap-16 px-8 items-center" aria-hidden="true">
                {{-- Duplicate for seamless loop --}}
                @for ($i = 0; $i < 2; $i++)
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Microsoft</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Google</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Spotify</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Amazon</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Airbnb</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Uber</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Atlassian</span>
                    </div>
                    <div
                        class="flex items-center gap-3 opacity-50 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        <span class="text-xl font-bold text-slate-400">Notion</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    </style>
</section>
