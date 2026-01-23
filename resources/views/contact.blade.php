<x-layout.app>
    <x-slot:title>Connect - ProductOS</x-slot:title>

    <div class="relative py-24 sm:py-32 bg-slate-50 overflow-hidden min-h-screen flex items-center justify-center">
        {{-- Background Accents --}}
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-indigo-100/50 rounded-full mix-blend-multiply blur-3xl opacity-60 animate-blob">
        </div>
        <div
            class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-blue-100/50 rounded-full mix-blend-multiply blur-3xl opacity-60 animate-blob animation-delay-2000">
        </div>

        <div class="relative w-full max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white border border-slate-200 shadow-sm text-slate-600 text-xs font-bold uppercase tracking-widest mb-6 hover:scale-105 transition-transform cursor-default">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                    Open to Opportunities
                </div>
                <h1
                    class="text-5xl md:text-7xl font-display font-black text-slate-900 tracking-tight mb-6 leading-tight">
                    Let's <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Connect.</span>
                </h1>
                <p class="text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                    Building the future of product management. Reach out for collaborations, consulting, or just to say
                    hi.
                </p>
            </div>

            {{-- 2x2 Standard Bento Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 auto-rows-[240px]">

                {{-- LinkedIn --}}
                <a href="#" target="_blank"
                    class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#0077B5] text-white flex items-center justify-center shadow-lg shadow-blue-900/10 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-brands fa-linkedin-in text-2xl"></i>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            <i
                                class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                            LinkedIn</h3>
                        <p class="text-slate-500 mt-2 text-sm font-medium">Professional updates & case studies.</p>
                    </div>
                </a>

                {{-- Twitter / X --}}
                <a href="#" target="_blank"
                    class="group relative bg-black rounded-[2rem] p-8 shadow-xl shadow-slate-900/20 hover:shadow-2xl hover:shadow-slate-900/30 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1 text-white">
                    <div
                        class="absolute right-0 top-0 w-32 h-32 bg-slate-800 rounded-full blur-3xl opacity-50 group-hover:opacity-75 transition-opacity">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div
                            class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-300 border border-slate-700">
                            <i class="fa-brands fa-x-twitter text-2xl"></i>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-black transition-all duration-300">
                            <i
                                class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold">X (Twitter)</h3>
                        <p class="text-slate-400 mt-2 text-sm font-medium">@ProductOS_BD</p>
                    </div>
                </a>

                {{-- Email --}}
                <a href="mailto:hello@productOS.bd"
                    class="group relative bg-white rounded-[2rem] p-8 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-orange-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div
                            class="w-14 h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-envelope text-2xl"></i>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                            <i
                                class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                            Email</h3>
                        <p class="text-slate-500 mt-2 text-sm font-medium truncate">hello@productOS.bd</p>
                    </div>
                </a>

                {{-- Buy Me a Coffee --}}
                <a href="#" target="_blank"
                    class="group relative bg-[#FFDD00] rounded-[2rem] p-8 shadow-xl shadow-amber-400/20 hover:shadow-2xl hover:shadow-amber-400/30 transition-all duration-300 overflow-hidden flex flex-col justify-between hover:-translate-y-1 text-slate-900">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div
                            class="w-14 h-14 rounded-2xl bg-black/5 text-slate-900 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-mug-hot text-2xl"></i>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-black/5 flex items-center justify-center text-slate-700 group-hover:bg-slate-900 group-hover:text-[#FFDD00] transition-all duration-300">
                            <i
                                class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold">Support</h3>
                        <p class="text-slate-800/80 mt-2 text-sm font-bold">Buy Me a Coffee</p>
                    </div>
                </a>

                {{-- Location (Full Width) --}}
                <a href="#"
                    class="group relative md:col-span-2 bg-slate-900 rounded-[2rem] p-8 shadow-xl shadow-slate-900/20 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 min-h-[200px] flex items-end">
                    <div
                        class="absolute inset-0 bg-[url('https://maps.googleapis.com/maps/api/staticmap?center=Dhaka&zoom=13&size=800x400&maptype=roadmap&style=feature:all|element:all|saturation:-100|lightness:10&key=YOUR_API_KEY_HERE')] bg-cover bg-center opacity-30 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>

                    <div class="relative z-10 flex items-end justify-between w-full">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                <span
                                    class="text-xs font-bold uppercase tracking-widest text-green-400">Headquarters</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Dhaka, Bangladesh</h3>
                            <p class="text-slate-400 text-sm mt-1">123 Innovation Dr, Tech City</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-white group-hover:text-slate-900 transition-all duration-300 border border-white/10">
                            <i class="fa-solid fa-location-arrow text-lg"></i>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>

    {{-- Custom Animations --}}
    <style>
        @keyframes blob {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }

            33% {
                transform: translate(-50%, -50%) scale(1.1);
            }

            66% {
                transform: translate(-50%, -50%) scale(0.9);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</x-layout.app>
