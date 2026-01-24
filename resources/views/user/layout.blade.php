<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - ProductOS</title>

    <!-- Scripts & CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js for Roadmap Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'dm-sans': ['"DM Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
    @stack('head')
</head>

<body class="bg-slate-50 text-slate-900 h-full flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-100 hidden md:flex flex-col">
        <div class="p-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    P
                </div>
                <span
                    class="font-bold text-xl tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors">ProductOS</span>
            </a>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto py-4">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Main</p>

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i
                    class="fa-solid fa-border-all text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                Dashboard
            </a>

            <a href="{{ route('career-compass.history') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('career-compass.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i
                    class="fa-solid fa-compass text-lg {{ request()->routeIs('career-compass.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                Career Compass
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i
                    class="fa-regular fa-user text-lg {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                My Profile
            </a>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Coming Soon</p>
            </div>

            {{-- Placeholder Links for Future Features --}}
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all opacity-50 cursor-not-allowed"
                title="Coming Soon">
                <i class="fa-solid fa-bell text-lg text-slate-400"></i>
                Notifications
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-all opacity-50 cursor-not-allowed"
                title="Coming Soon">
                <i class="fa-solid fa-file-invoice-dollar text-lg text-slate-400"></i>
                Billing
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600 transition-all">
                    <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Nav Toggle (Simple implementation) -->
    <div x-data="{ open: false }" class="md:hidden">
        <!-- Overlay -->
        <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 z-40 backdrop-blur-sm"
            style="display: none;"></div>

        <!-- Mobile Sidebar -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-white z-50 shadow-2xl flex flex-col" style="display: none;">

            <div class="p-6 flex justify-between items-center border-b border-slate-100">
                <span class="font-bold text-xl text-slate-900">ProductOS</span>
                <button @click="open = false" class="text-slate-400 hover:text-slate-900">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-3 rounded-lg text-slate-900 bg-slate-50 font-medium">Dashboard</a>
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-3 rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium">My
                    Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="pt-4 mt-4 border-t border-slate-100">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-red-600 font-medium">Sign Out</button>
                </form>
            </nav>
        </div>

        <!-- Mobile Header Bar -->
        <div
            class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-slate-100 z-30 flex items-center justify-between px-4">
            <button @click="open = true" class="text-slate-500 p-2">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="font-bold text-lg text-slate-900">ProductOS</span>
            <div class="w-8"></div> <!-- Spacer -->
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Header -->
        <header
            class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 absolute top-0 left-0 right-0 z-20 md:static">
            <h1 class="text-xl font-bold text-slate-900 hidden md:block">@yield('header', 'Dashboard')</h1>

            <div class="flex items-center gap-4 ml-auto">
                <span class="text-sm text-slate-500 hidden sm:block">Welcome back, <span
                        class="font-semibold text-slate-900">{{ Auth::user()->name }}</span></span>
                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 overflow-hidden">
                    @if (Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-500 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}</div>
                    @endif
                </div>
            </div>
        </header>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8 pt-20 md:pt-8">
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @livewireScripts
</body>

</html>
