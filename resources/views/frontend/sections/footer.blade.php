@if ($footer = App\Models\FooterSettings::firstActive())
    <footer id="footer" class="relative bg-slate-900 text-white overflow-hidden font-sans">
        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 right-0 w-[500px] h-[500px] bg-teal-500/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2">
            </div>
        </div>

        <div class="max-w-[1200px] mx-auto px-8 relative z-10 pt-24 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">
                {{-- Brand Column --}}
                <div class="lg:col-span-4">
                    <div
                        class="text-3xl font-black tracking-tight mb-6 bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">
                        {{ $footer->logo_text ?? 'productOS' }}
                    </div>
                    <p class="text-slate-400 text-base leading-relaxed mb-8 max-w-sm">
                        {{ $footer->description ?? 'Building growth strategies and the tools to measure them for visionary product teams.' }}
                    </p>
                    <div class="flex items-center space-x-4">
                        @if ($footer->linkedin_url)
                            <a href="{{ $footer->linkedin_url }}"
                                class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if ($footer->twitter_url)
                            <a href="{{ $footer->twitter_url }}"
                                class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-sky-500 hover:text-white transition-all duration-300">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        @endif
                        @if ($footer->email)
                            <a href="mailto:{{ $footer->email }}"
                                class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-teal-500 hover:text-white transition-all duration-300">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Spacer --}}
                <div class="hidden lg:block lg:col-span-1"></div>

                {{-- Links Column 1 --}}
                @if ($footer->column1_links)
                    <div class="lg:col-span-2">
                        <h4 class="font-bold text-white mb-6">Expertise</h4>
                        <ul class="space-y-4 text-sm text-slate-400">
                            @foreach ($footer->column1_links as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '#' }}"
                                        class="hover:text-teal-400 transition-colors flex items-center group">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-slate-600 mr-3 group-hover:bg-teal-400 transition-colors"></span>
                                        {{ $link['text'] ?? 'Link' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Links Column 2 --}}
                @if ($footer->column2_links)
                    <div class="lg:col-span-2">
                        <h4 class="font-bold text-white mb-6">Tools</h4>
                        <ul class="space-y-4 text-sm text-slate-400">
                            @foreach ($footer->column2_links as $link)
                                <li>
                                    <a href="{{ $link['url'] ?? '#' }}"
                                        class="hover:text-blue-400 transition-colors flex items-center group">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full bg-slate-600 mr-3 group-hover:bg-blue-400 transition-colors"></span>
                                        {{ $link['text'] ?? 'Link' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Newsletter / Contact --}}
                <div class="lg:col-span-3">
                    <h4 class="font-bold text-white mb-6">Stay Updated</h4>
                    <p class="text-sm text-slate-400 mb-4">Join 5,000+ PMs receiving weekly cues.</p>
                    <form class="relative">
                        <input type="email" placeholder="Email address"
                            class="w-full bg-slate-800/50 border border-slate-700 rounded-xl py-3 px-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-teal-500 focus:ring-1 focus:ring-teal-500 transition-all">
                        <button type="submit"
                            class="absolute right-2 top-2 p-1.5 bg-teal-500 rounded-lg text-white hover:bg-teal-400 transition-colors">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div
                class="pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
                <div class="mb-4 md:mb-0">
                    &copy; {{ date('Y') }} {{ $footer->copyright_text ?? 'Mahe Karim. All rights reserved.' }}
                </div>
                <div class="flex items-center space-x-8">
                    @if ($footer->privacy_policy_url)
                        <a href="{{ $footer->privacy_policy_url }}" class="hover:text-white transition-colors">
                            Privacy Policy
                        </a>
                    @endif
                    @if ($footer->terms_url)
                        <a href="{{ $footer->terms_url }}" class="hover:text-white transition-colors">
                            Terms of Service
                        </a>
                    @endif
                    <a href="#" class="hover:text-white transition-colors">
                        Sitemap
                    </a>
                </div>
            </div>
        </div>
    </footer>
@endif
