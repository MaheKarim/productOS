<nav x-data="{ mobileMenuOpen: false, extraDropdownOpen: false }"
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
                <a href="{{ route('prompts.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('prompts.*') ? 'text-blue-600 font-bold' : '' }}">Prompts</a>
                <a href="{{ route('books.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                    Library
                </a>
                <a href="{{ route('tools.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('tools.*') ? 'text-blue-600 font-bold' : '' }}">Tools</a>

                <a href="{{ route('roadmap.index') }}"
                    class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer {{ request()->routeIs('roadmap.*') ? 'text-blue-600 font-bold' : '' }}">Roadmap</a>

                <!-- Extra Dropdown -->
                <div class="relative" @click.away="extraDropdownOpen = false">
                    <button @click="extraDropdownOpen = !extraDropdownOpen"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors cursor-pointer flex items-center gap-1 focus:outline-none {{ request()->routeIs('about') || request()->routeIs('directory.*') || request()->routeIs('yt-summarize.*') ? 'text-blue-600 font-bold' : '' }}">
                        Extra 🚀
                        <svg class="w-4 h-4 transition-transform duration-200"
                            :class="extraDropdownOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="extraDropdownOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl z-50 overflow-hidden"
                        style="display: none;">
                        <a href="{{ route('about') }}"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors {{ request()->routeIs('about') ? 'text-blue-600 font-bold' : '' }}">About</a>
                        <a href="{{ route('directory.index') }}"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors {{ request()->routeIs('directory.*') ? 'text-blue-600 font-bold' : '' }}">Directory</a>
                        <a href="{{ route('yt-summarize.index') }}"
                            class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors {{ request()->routeIs('yt-summarize.*') ? 'text-blue-600 font-bold' : '' }}">YT
                            Summarize</a>
                    </div>
                </div>

                <a href="#support-section"
                    class="text-sm font-medium text-slate-600 hover:text-amber-600 transition-colors cursor-pointer flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20.216 6.415l-.132-.666c-.119-.598-.388-1.163-1.001-1.379-.197-.069-.42-.098-.57-.241-.152-.143-.196-.366-.231-.572-.065-.378-.125-.756-.192-1.133-.057-.325-.102-.69-.25-.987-.195-.4-.597-.634-.996-.788a5.723 5.723 0 00-.626-.194c-1-.263-2.05-.36-3.077-.416a25.834 25.834 0 00-3.7.062c-.915.083-1.88.184-2.75.5-.318.116-.646.256-.888.501-.297.302-.393.77-.177 1.146.154.267.415.456.692.58.36.162.737.284 1.123.366 1.075.238 2.189.331 3.287.37 1.218.05 2.437.01 3.65-.118.299-.033.598-.073.896-.119.352-.054.578-.513.474-.834-.124-.383-.457-.531-.834-.473-.466.074-.96.108-1.382.146-1.177.08-2.358.082-3.536.006a22.228 22.228 0 01-1.157-.107c-.086-.01-.18-.025-.258-.036-.243-.036-.484-.08-.724-.13-.111-.027-.111-.185 0-.212h.005c.277-.06.557-.108.838-.147h.002c.131-.009.263-.032.394-.048a25.076 25.076 0 013.426-.12c.674.019 1.347.067 2.017.144l.228.031c.267.04.533.088.798.145.392.085.895.113 1.07.542.055.137.08.288.111.431l.319 1.484a.237.237 0 01-.199.284h-.003c-.037.006-.075.01-.112.015a36.704 36.704 0 01-4.743.295 37.059 37.059 0 01-4.699-.304c-.14-.017-.293-.042-.417-.06-.326-.048-.649-.108-.973-.161-.393-.065-.768-.032-1.123.161-.29.16-.527.404-.675.701-.154.316-.199.66-.267 1-.069.34-.176.707-.135 1.056.087.753.613 1.365 1.37 1.502a39.69 39.69 0 0011.343.376.483.483 0 01.535.53l-.071.697-1.018 9.907c-.041.41-.047.832-.125 1.237-.122.637-.553 1.028-1.182 1.171-.577.131-1.165.2-1.756.205-.656.004-1.31-.025-1.966-.022-.699.004-1.556-.06-2.095-.58-.475-.458-.54-1.174-.605-1.793l-.731-7.013-.322-3.094c-.037-.351-.286-.695-.678-.678-.336.015-.718.3-.678.679l.228 2.185.949 9.112c.147 1.344 1.174 2.068 2.446 2.272.742.12 1.503.144 2.257.156.966.016 1.942.053 2.892-.122 1.408-.258 2.465-1.198 2.616-2.657.34-3.332.663-6.66.972-9.993l.091-.879a.484.484 0 01.651-.407c.514.194 1.077.272 1.62.226.769-.066 1.325-.563 1.495-1.345.163-.754.122-1.527-.086-2.264z" />
                    </svg>
                    Support
                </a>

                <!-- Search Trigger -->
                <a href="{{ route('search') }}"
                    class="p-2 text-slate-400 hover:text-blue-600 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
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
            <a href="{{ route('prompts.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('prompts.*') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">Prompts</a>
            <a href="{{ route('books.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('books.index') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">Library</a>
            <a href="{{ route('tools.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('tools.*') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">Toolkit</a>
            <a href="{{ route('roadmap.index') }}"
                class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('roadmap.*') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">Roadmap</a>

            <!-- Mobile Extra Section -->
            <div class="pt-4 pb-2 border-t border-slate-50">
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Extra 🚀</p>
                <a href="{{ route('about') }}"
                    class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('about') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">About</a>
                <a href="{{ route('directory.index') }}"
                    class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('directory.*') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">Directory</a>
                <a href="{{ route('yt-summarize.index') }}"
                    class="block px-4 py-3 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg cursor-pointer {{ request()->routeIs('yt-summarize.*') ? 'text-blue-600 font-bold bg-slate-50' : '' }}">YT
                    Summarize</a>
            </div>

            <a href="#support-section"
                class="block px-4 py-3 text-base font-medium text-amber-600 hover:bg-amber-50 rounded-lg cursor-pointer">☕
                Support</a>

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
