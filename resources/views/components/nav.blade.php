<nav x-data="{ mobileMenuOpen: false }"
    class="fixed top-8 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-slate-900 tracking-tight">
                    Product<span class="text-blue-600">OS</span>
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('portfolio.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('portfolio.*') ? 'text-blue-600' : '' }}">Case
                    Studies</a>

                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">About</a>
                <a href="{{ route('prompts.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('prompts.*') ? 'text-blue-600 font-bold' : '' }}">Prompts</a>
                <a href="{{ route('books.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                    Library
                </a>
                <a href="{{ route('tools.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('tools.*') ? 'text-blue-600 font-bold' : '' }}">Tools</a>
                <a href="{{ route('directory.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('directory.*') ? 'text-blue-600 font-bold' : '' }}">Directory</a>
                <a href="{{ route('roadmap.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('roadmap.*') ? 'text-blue-600 font-bold' : '' }}">Roadmap</a>
                <a href="{{ route('yt-summarize.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('yt-summarize.*') ? 'text-blue-600 font-bold' : '' }}">YT
                    Summarize</a>

                <a href="{{ route('contact') }}"
                    class="ml-4 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg cursor-pointer">
                    Let's Talk
                </a>

                <!-- Auth Buttons -->
                @guest
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all cursor-pointer">
                        Get Started
                    </a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                        class="px-4 py-2 bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-semibold rounded-lg hover:shadow-lg hover:shadow-violet-500/30 transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>
                @endguest

                <!-- Search Trigger -->
                <a href="{{ route('search') }}"
                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-slate-500 hover:text-blue-600 p-2 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden bg-white border-t border-slate-100">
        <div class="px-4 pt-4 pb-6 space-y-2">
            <a href="{{ route('portfolio.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Case
                Studies</a>

            <a href="{{ route('about') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">About</a>
            <a href="{{ route('prompts.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Prompts</a>
            <a href="{{ route('books.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Library</a>
            <a href="{{ route('tools.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Toolkit</a>
            <a href="{{ route('directory.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Directory</a>
            <a href="{{ route('roadmap.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('roadmap.*') ? 'text-blue-600 font-bold' : '' }}">Roadmap</a>
            <a href="{{ route('yt-summarize.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('yt-summarize.*') ? 'text-blue-600 font-bold' : '' }}">YT
                Summarize</a>
            <a href="{{ route('contact') }}"
                class="block px-4 py-3 text-base font-bold text-blue-600 hover:bg-blue-50 rounded-lg cursor-pointer">Book
                a Call</a>

            <!-- Mobile Auth Buttons -->
            <div class="border-t border-slate-200 mt-2 pt-2 space-y-2">
                @guest
                    <a href="{{ route('login') }}"
                        class="block px-4 py-3 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-violet-600 rounded-lg cursor-pointer text-center">Get
                        Started</a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                        class="flex items-center gap-2 px-4 py-3 text-base font-bold text-white bg-gradient-to-r from-violet-600 to-purple-600 rounded-lg cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>
