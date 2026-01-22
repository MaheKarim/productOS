<header id="header" class="sticky top-0 z-50 glass border-b border-gray-100/50 shadow-sm transition-all duration-300">
    <div class="max-w-[1200px] mx-auto px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-teal-900">productOS</a>
            </div>

            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('tools') }}"
                    class="text-slate-700 font-medium hover:text-primary transition-default cursor-pointer {{ request()->routeIs('tools') ? 'text-primary' : '' }}">ProductOS</a>
                <a href="{{ route('home') }}#portfolio"
                    class="text-slate-700 font-medium hover:text-primary transition-default cursor-pointer">Portfolio</a>
                <a href="{{ route('home') }}#services"
                    class="text-slate-700 font-medium hover:text-primary transition-default cursor-pointer">Services</a>
                <a href="{{ route('home') }}#about"
                    class="text-slate-700 font-medium hover:text-primary transition-default cursor-pointer">About</a>
            </nav>

            <div class="flex items-center space-x-4">
                <button
                    class="hidden md:flex items-center space-x-2 px-4 py-2 text-sm text-slate-600 hover:text-primary transition-default">
                    <i class="fa-solid fa-search"></i>
                    <span>Search</span>
                    <kbd class="px-2 py-1 text-xs bg-gray-100 rounded">⌘K</kbd>
                </button>
                <a href="{{ route('home') }}#contact"
                    class="gradient-primary text-white font-semibold px-6 py-3 rounded-lg hover:shadow-level-2 transition-medium cursor-pointer">Let's
                    Talk</a>
            </div>
        </div>
    </div>
</header>
