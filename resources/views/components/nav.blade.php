<nav x-data="{ mobileMenuOpen: false }" class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-display font-bold text-primary tracking-tight">
                    Product<span class="text-accent">OS</span>
                </a>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('portfolio.index') }}"
                    class="text-sm font-medium text-zinc-600 hover:text-primary transition-colors">Case Studies</a>
                <a href="{{ route('services') }}"
                    class="text-sm font-medium text-zinc-600 hover:text-primary transition-colors">Services</a>
                <a href="{{ route('about') }}"
                    class="text-sm font-medium text-zinc-600 hover:text-primary transition-colors">About</a>
                <a href="{{ route('tools.index') }}"
                    class="text-sm font-medium text-zinc-600 hover:text-primary transition-colors">Toolkit</a>

                <a href="{{ route('contact') }}"
                    class="ml-4 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-zinc-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Let's Talk
                </a>

                <!-- Search Trigger -->
                <button onclick="window.location.href='/search?q='"
                    class="p-2 text-zinc-400 hover:text-primary transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-zinc-500 hover:text-primary p-2">
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
    <div x-show="mobileMenuOpen" x-transition x-cloak class="md:hidden bg-white border-t border-zinc-100 h-screen">
        <div class="px-4 pt-4 pb-20 space-y-4">
            <a href="{{ route('portfolio.index') }}"
                class="block px-4 py-3 text-lg font-medium text-zinc-600 hover:bg-zinc-50 rounded-xl">Case Studies</a>
            <a href="{{ route('services') }}"
                class="block px-4 py-3 text-lg font-medium text-zinc-600 hover:bg-zinc-50 rounded-xl">Services</a>
            <a href="{{ route('about') }}"
                class="block px-4 py-3 text-lg font-medium text-zinc-600 hover:bg-zinc-50 rounded-xl">About</a>
            <a href="{{ route('tools.index') }}"
                class="block px-4 py-3 text-lg font-medium text-zinc-600 hover:bg-zinc-50 rounded-xl">Toolkit</a>
            <a href="{{ route('contact') }}"
                class="block px-4 py-3 text-lg font-bold text-accent hover:bg-blue-50 rounded-xl">Book a Call</a>
        </div>
    </div>
</nav>
