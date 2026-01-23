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
                <a href="{{ route('services') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('services') ? 'text-blue-600' : '' }}">Services</a>
                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('about') ? 'text-blue-600' : '' }}">About</a>
                <a href="{{ route('tools.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('tools.*') ? 'text-blue-600 font-bold' : '' }}">Tools</a>
                <a href="{{ route('directory.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('directory.*') ? 'text-blue-600 font-bold' : '' }}">Directory</a>

                <a href="{{ route('contact') }}"
                    class="ml-4 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg cursor-pointer">
                    Let's Talk
                </a>

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
            <a href="{{ route('services') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Services</a>
            <a href="{{ route('about') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">About</a>
            <a href="{{ route('tools.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Toolkit</a>
            <a href="{{ route('directory.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer">Directory</a>
            <a href="{{ route('contact') }}"
                class="block px-4 py-3 text-base font-bold text-blue-600 hover:bg-blue-50 rounded-lg cursor-pointer">Book
                a Call</a>
        </div>
    </div>
</nav>
