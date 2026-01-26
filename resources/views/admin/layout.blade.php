<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - ProductOS Admin</title>

    <!-- Scripts & CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        secondary: '#3B82F6',
                        cta: '#F97316',
                        dashboard: {
                            sidebar: '#0F172A',
                            bg: '#F8FAFC',
                            card: '#FFFFFF',
                            text: '#1E293B'
                        },
                        indigo: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            500: '#6366F1',
                            600: '#4F46E5',
                            700: '#4338CA',
                            900: '#312E81'
                        }
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'Inter', 'system-ui', 'sans-serif'],
                        display: ['DM Sans', 'sans-serif']
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                        'premium': '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.01)'
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');

        body {
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-item-active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            font-weight: 500;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E2E8F0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #CBD5E1;
        }

        .transition-soft {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gradient-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #2563EB 100%);
        }
    </style>
</head>

<body class="h-full overflow-hidden">
    <div class="flex h-screen bg-dashboard-bg">
        <!-- Sidebar -->
        <aside
            class="hidden md:flex md:w-72 md:flex-col fixed h-full bg-dashboard-sidebar text-slate-300 z-50 transition-soft">
            <div class="flex flex-col flex-grow pt-8 overflow-y-auto">
                {{-- Logo Section --}}
                <div class="flex items-center flex-shrink-0 px-8 mb-10">
                    <div
                        class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-indigo-500/30">
                        <i data-lucide="layers" class="text-white w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white tracking-tight">ProductOS</span>
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest leading-none">Admin
                            Panel</p>
                    </div>
                </div>

                {{-- Sidebar Search --}}
                <div class="px-6 mb-8">
                    <div class="relative group">
                        <i data-lucide="search"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-hover:text-indigo-400 transition-colors"></i>
                        <input type="text" id="sidebar-search" placeholder="Search modules..."
                            class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-800 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition-soft"
                            onkeyup="filterMenuItems()">
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-4 space-y-1" id="sidebar-menu">
                    <div class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">General</div>

                    <a href="{{ route('admin.dashboard') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="dashboard">
                        <i data-lucide="layout-dashboard"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        Dashboard
                    </a>

                    <div class="pt-6 px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Content
                        Management</div>

                    {{-- Tools Management --}}
                    <a href="{{ route('admin.tools.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.tools.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="tools">
                        <i data-lucide="calculator"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.tools.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        Tools
                        <span
                            class="ml-auto px-2 py-0.5 text-[10px] rounded-full bg-indigo-500/20 text-indigo-400 font-bold">{{ \App\Models\Tool::count() }}</span>
                    </a>

                    {{-- Prompt Library Management --}}
                    <a href="{{ route('admin.prompts.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.prompts.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="prompts">
                        <i data-lucide="message-square-text"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.prompts.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        Prompt Library
                        <span
                            class="ml-auto px-2 py-0.5 text-[10px] rounded-full bg-amber-500/20 text-amber-400 font-bold">{{ \App\Models\Prompt::count() }}</span>
                    </a>

                    {{-- Roadmap Management --}}
                    <a href="{{ route('admin.roadmap.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.roadmap.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="roadmap">
                        <i data-lucide="map"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.roadmap.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        PM Roadmap
                        <span
                            class="ml-auto px-2 py-0.5 text-[10px] rounded-full bg-teal-500/20 text-teal-400 font-bold">{{ \App\Models\RoadmapTopic::count() }}</span>
                    </a>

                    {{-- Directory Management --}}
                    <div class="cms-settings-group mb-2">
                        <button onclick="toggleDirectoryMenu()"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800/50 hover:text-white transition-soft {{ request()->routeIs('admin.directory.*') ? 'bg-slate-800/50 text-white' : '' }}">
                            <div class="flex items-center">
                                <i data-lucide="folder-open"
                                    class="mr-3 w-5 h-5 {{ request()->routeIs('admin.directory.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                                Directory
                            </div>
                            <i data-lucide="chevron-down" id="directory-chevron"
                                class="w-4 h-4 transition-transform duration-300"></i>
                        </button>

                        <div id="directory-menu"
                            class="hidden mt-1 px-6 space-y-1 overflow-hidden transition-all duration-300">
                            <a href="{{ route('admin.directory.index') }}"
                                class="menu-item group flex items-center px-4 py-2.5 text-xs font-medium rounded-lg transition-soft {{ request()->routeIs('admin.directory.index') || request()->routeIs('admin.directory.create') || request()->routeIs('admin.directory.edit') ? 'text-white bg-white/5' : 'text-slate-500 hover:text-white' }}"
                                data-menu-name="directory-items">
                                <i data-lucide="list" class="mr-3 w-4 h-4"></i>
                                All Items
                            </a>
                            <a href="{{ route('admin.directory.categories.index') }}"
                                class="menu-item group flex items-center px-4 py-2.5 text-xs font-medium rounded-lg transition-soft {{ request()->routeIs('admin.directory.categories.*') ? 'text-white bg-white/5' : 'text-slate-500 hover:text-white' }}"
                                data-menu-name="directory-categories">
                                <i data-lucide="tags" class="mr-3 w-4 h-4"></i>
                                Categories
                            </a>
                        </div>
                    </div>

                    <div class="pt-6 px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">System
                    </div>

                    <a href="{{ route('admin.users.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="users">
                        <i data-lucide="users"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        User Management
                    </a>

                    <a href="{{ route('admin.ai-providers.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.ai-providers.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="ai-providers">
                        <i data-lucide="brain"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.ai-providers.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        AI Providers
                    </a>

                    <a href="{{ route('admin.videos.index') }}"
                        class="menu-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.videos.*') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}"
                        data-menu-name="yt-summarize">
                        <i data-lucide="youtube"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.videos.*') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        YT Summarize
                    </a>
                    {{-- Collapsible CMS Group --}}
                    <div class="cms-settings-group">
                        <button onclick="toggleCmsSettings()"
                            class="w-full group flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800/50 hover:text-white transition-soft">
                            <div class="flex items-center">
                                <i data-lucide="layout-template"
                                    class="mr-3 w-5 h-5 text-slate-500 group-hover:text-indigo-400"></i>
                                CMS Settings
                            </div>
                            <i data-lucide="chevron-down" id="cms-chevron"
                                class="w-4 h-4 transition-transform duration-300"></i>
                        </button>

                        <div id="cms-settings-menu"
                            class="hidden mt-1 px-6 space-y-1 overflow-hidden transition-all duration-300">
                            @php
                                $cmsItems = [
                                    [
                                        'route' => 'admin.hero.index',
                                        'icon' => 'monitor',
                                        'label' => 'Hero Section',
                                        'name' => 'hero',
                                    ],
                                    [
                                        'route' => 'admin.about.index',
                                        'icon' => 'info',
                                        'label' => 'About Me',
                                        'name' => 'about',
                                    ],
                                    [
                                        'route' => 'admin.services.index',
                                        'icon' => 'zap',
                                        'label' => 'Services',
                                        'name' => 'services',
                                    ],
                                    [
                                        'route' => 'admin.projects.index',
                                        'icon' => 'briefcase',
                                        'label' => 'Impact Projects',
                                        'name' => 'projects',
                                    ],
                                    [
                                        'route' => 'admin.testimonials.index',
                                        'icon' => 'message-square',
                                        'label' => 'Testimonials',
                                        'name' => 'testimonials',
                                    ],
                                    [
                                        'route' => 'admin.footer.index',
                                        'icon' => 'layout',
                                        'label' => 'Footer',
                                        'name' => 'footer',
                                    ],
                                ];
                            @endphp

                            @foreach ($cmsItems as $item)
                                <a href="{{ route($item['route']) }}"
                                    class="menu-item group flex items-center px-4 py-2.5 text-xs font-medium rounded-lg transition-soft {{ request()->is('admin/' . str_replace('.index', '', $item['route']) . '*') ? 'text-white bg-white/5' : 'text-slate-500 hover:text-white' }}"
                                    data-menu-name="{{ $item['name'] }}">
                                    <i data-lucide="{{ $item['icon'] }}" class="mr-3 w-4 h-4"></i>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-6 px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">System
                    </div>
                    <a href="{{ route('admin.settings.index') }}"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.settings.index') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}">
                        <i data-lucide="settings"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.settings.index') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        Settings
                    </a>

                    <a href="{{ route('admin.settings.prompts') }}"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-soft {{ request()->routeIs('admin.settings.prompts') ? 'sidebar-item-active' : 'hover:bg-slate-800/50 hover:text-white' }}">
                        <i data-lucide="terminal"
                            class="mr-3 w-5 h-5 {{ request()->routeIs('admin.settings.prompts') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}"></i>
                        System Prompts
                    </a>
                </nav>

                {{-- User Profile Card / Footer --}}
                <div class="p-4 mt-auto border-t border-slate-800/50">
                    <div class="bg-white/5 rounded-2xl p-4 flex items-center">
                        @if (Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                class="w-10 h-10 rounded-full object-cover mr-3 border border-indigo-500/30">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center mr-3">
                                <span
                                    class="text-indigo-400 font-bold">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="mr-2">
                            <p class="text-xs font-bold text-white truncate w-24">
                                {{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-[10px] text-slate-500 truncate w-24">Administrator</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 hover:text-red-400 transition-colors">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="flex-1 w-full md:ml-72 flex flex-col min-h-screen overflow-y-auto relative">
            <!-- Top Header (Glassmorphism) -->
            <header
                class="sticky top-0 z-40 w-full glass border-b border-slate-200/60 px-8 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="md:hidden p-2 text-slate-600">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center space-x-6">
                    {{-- Global Search Toggle --}}
                    <div
                        class="hidden lg:flex items-center bg-slate-100 rounded-full px-4 py-1.5 border border-slate-200 transition-soft focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:bg-white w-64">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 mr-2"></i>
                        <input type="text" placeholder="Jump to..."
                            class="bg-transparent border-none text-xs focus:ring-0 w-full placeholder-slate-400 text-slate-600">
                        <span
                            class="text-[10px] text-slate-400 bg-slate-200 px-1.5 py-0.5 rounded font-bold uppercase tracking-widest ml-2">⌘K</span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-soft">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span
                                class="absolute top-2 right-2 w-2 h-2 bg-indigo-600 rounded-full border-2 border-white"></span>
                        </button>
                        <div class="w-px h-6 bg-slate-200"></div>
                        <a href="{{ url('/') }}" target="_blank"
                            class="flex items-center space-x-2 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                            <span>Live Site</span>
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Content -->
            <div class="p-8">
                {{-- Session Messages --}}
                @if (session('success'))
                    <div
                        class="mb-8 p-4 bg-teal-50 border border-teal-200 rounded-2xl flex items-center space-x-3 animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-8 h-8 rounded-full bg-teal-500/20 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-teal-600"></i>
                        </div>
                        <span class="text-sm font-medium text-teal-900">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div
                        class="mb-8 p-4 bg-red-50 border border-red-100 rounded-2xl animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                            </div>
                            <span class="text-sm font-bold text-red-900">Action Required</span>
                        </div>
                        <ul class="ml-11 text-sm text-red-700 space-y-1">
                            @if (session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>

            {{-- Admin Footer --}}
            <footer
                class="mt-auto p-8 border-t border-slate-200/60 bg-white/50 text-slate-500 flex justify-between items-center text-[11px] font-medium uppercase tracking-widest">
                <div>&copy; {{ date('Y') }} ProductOS Manager. Build v2.4</div>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-indigo-600 transition-colors">Documentation</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Support</a>
                </div>
            </footer>
        </main>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Toggle CMS Settings dropdown with animation
        function toggleCmsSettings() {
            const menu = document.getElementById('cms-settings-menu');
            const chevron = document.getElementById('cms-chevron');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.style.maxHeight = '500px';
                }, 10);
                chevron.classList.add('rotate-180');
            } else {
                menu.style.maxHeight = '0px';
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
                chevron.classList.remove('rotate-180');
            }
        }

        // Filter menu items based on search
        function filterMenuItems() {
            const searchTerm = document.getElementById('sidebar-search').value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-item');
            const sections = document.querySelectorAll('.cms-settings-group');
            const cmsMenu = document.getElementById('cms-settings-menu');
            const cmsChevron = document.getElementById('cms-chevron');

            let matchingCms = false;

            menuItems.forEach(item => {
                const name = item.getAttribute('data-menu-name').toLowerCase();
                const text = item.innerText.toLowerCase();

                if (name.includes(searchTerm) || text.includes(searchTerm)) {
                    item.style.display = 'flex';
                    if (item.closest('#cms-settings-menu')) matchingCms = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (searchTerm !== '' && matchingCms) {
                cmsMenu.classList.remove('hidden');
                cmsMenu.style.maxHeight = '500px';
                cmsChevron.classList.add('rotate-180');
            } else if (searchTerm === '') {
                // Keep current state logic handles it below
            }
        }

        // Toggle Directory menu
        function toggleDirectoryMenu() {
            const menu = document.getElementById('directory-menu');
            const chevron = document.getElementById('directory-chevron');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.style.maxHeight = '500px';
                }, 10);
                chevron.classList.add('rotate-180');
            } else {
                menu.style.maxHeight = '0px';
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
                chevron.classList.remove('rotate-180');
            }
        }

        // Keep CMS Settings open if on any CMS route
        document.addEventListener('DOMContentLoaded', function() {
            const path = window.location.pathname;

            // CMS Auto-Open
            const isCms = ['/admin/hero', '/admin/about', '/admin/services', '/admin/projects',
                    '/admin/testimonials', '/admin/footer'
                ]
                .some(r => path.startsWith(r));

            if (isCms) {
                const menu = document.getElementById('cms-settings-menu');
                const chevron = document.getElementById('cms-chevron');
                menu.classList.remove('hidden');
                menu.style.maxHeight = '500px';
                chevron.classList.add('rotate-180');
            }

            // Directory Auto-Open
            if (path.startsWith('/admin/directory')) {
                const dirMenu = document.getElementById('directory-menu');
                const dirChevron = document.getElementById('directory-chevron');
                dirMenu.classList.remove('hidden');
                dirMenu.style.maxHeight = '500px';
                dirChevron.classList.add('rotate-180');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
