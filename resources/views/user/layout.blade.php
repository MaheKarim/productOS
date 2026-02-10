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
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Raleway', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Raleway', sans-serif;
        }
    </style>
    @stack('head')
</head>

<body class="bg-slate-50 text-slate-900 h-full flex overflow-hidden">

    <!-- Sidebar -->
    @inject('featureService', 'App\Services\FeatureAccessService')
    <aside class="w-64 bg-white hidden md:flex flex-col shadow-sm" x-data="{
        search: '',
        items: [
            { id: 'dashboard', label: 'Dashboard', route: '{{ route('dashboard') }}', icon: 'dashboard', section: 'Main' },
            { id: 'career-compass', label: 'Career Compass', route: '{{ route('career-compass.history') }}', icon: 'map', section: 'Main' },
            { id: 'strategic-roadmap', label: 'Strategic Roadmap', route: '{{ route('user.strategic-roadmap.index') }}', icon: 'roadmap', section: 'Main' },
            { id: 'resume-builder', label: 'Resume Analyzer', route: '{{ route('resume-builder.index') }}', icon: 'file-text', section: 'Main' },
            { id: 'job-analyze', label: 'Job Analyze', route: '{{ route('user.job-analyze.index') }}', icon: 'search', section: 'Main' },
            { id: 'icp-builder', label: 'ICP Generator', route: '{{ route('icp-builder.index') }}', icon: 'target', section: 'Main' },
            { id: 'yt-summarizer', label: 'YT Summarizer', route: '{{ route('user.yt-summarize.index') }}', icon: 'video', section: 'Main' },
            { id: 'profile', label: 'Profile', route: '{{ route('profile.edit') }}', icon: 'user', section: 'Account' },
            { id: 'interview-prep', label: 'Interview Prep', route: '#', icon: 'clipboard-list', section: 'Account' },
            { id: 'feedback', label: 'Feedback', route: '{{ route('feedback.dashboard') }}', icon: 'message-circle', section: 'Account' },
            { id: 'settings', label: 'Settings', route: '#', icon: 'settings', section: 'Support' },
            { id: 'help', label: 'Help', route: '#', icon: 'help', section: 'Support' }
        ],
        highlight(text) {
            if (!this.search.trim()) return text;
            const regex = new RegExp(`(${this.search.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<mark class=\'bg-yellow-200 rounded-px px-0.5 text-slate-900\'>$1</mark>');
        },
        isVisible(item) {
            if (!this.search.trim()) return true;
            return item.label.toLowerCase().includes(this.search.toLowerCase());
        },
        isSectionVisible(section) {
            if (!this.search.trim()) return true;
            return this.items.some(item => item.section === section && this.isVisible(item));
        }
    }">
        <!-- Brand Header -->
        <div class="px-4 py-5 border-b border-slate-100">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group cursor-pointer">
                <div
                    class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-500/20">
                    P
                </div>
                <div>
                    <span class="font-semibold text-slate-900 block leading-tight">ProductOS</span>
                    <span class="text-xs text-slate-400">Dashboard</span>
                </div>
            </a>
        </div>

        <!-- Search -->
        <div class="px-3 py-3">
            <div
                class="flex items-center gap-2 px-3 py-2 bg-slate-50 rounded-lg border border-slate-100 text-slate-400 focus-within:border-blue-300 focus-within:ring-2 focus-within:ring-blue-100 transition-all group">
                <svg class="w-4 h-4 group-focus-within:text-blue-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" x-model="search" placeholder="Search..." @keydown.meta.k.window="$el.focus()"
                    class="w-full bg-transparent border-none focus:ring-0 text-sm p-0 text-slate-600 placeholder:text-slate-400 outline-none">
                <span
                    class="ml-auto text-[10px] bg-white px-1.5 py-0.5 rounded border border-slate-200 font-mono text-slate-400 group-focus-within:hidden">⌘K</span>
            </div>
        </div>

        <!-- Main Navigation -->
        <nav class="flex-1 px-3 py-2 overflow-y-auto">
            <!-- Main Section -->
            <div class="mb-6" x-show="isSectionVisible('Main')">
                <a href="{{ route('dashboard') }}" x-show="isVisible({label: 'Dashboard'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('dashboard') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span x-html="highlight('Dashboard')">Dashboard</span>
                </a>

                <a href="{{ route('career-compass.history') }}" x-show="isVisible({label: 'Career Compass'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('career-compass.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('career-compass.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                    <span x-html="highlight('Career Compass')">Career Compass</span>
                </a>

                @php $roadmapStatus = $featureService->checkAccess(Auth::user(), 'strategic_roadmap'); @endphp
                <a href="{{ $roadmapStatus['status'] === 'inactive' ? '#' : route('user.strategic-roadmap.index') }}"
                    x-show="isVisible({label: 'Strategic Roadmap'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('user.strategic-roadmap.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} {{ $roadmapStatus['status'] === 'inactive' ? 'opacity-60 cursor-not-allowed' : '' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('user.strategic-roadmap.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <div class="flex-1 flex items-center justify-between">
                        <span x-html="highlight('Strategic Roadmap')">Strategic Roadmap</span>
                        @if ($roadmapStatus['status'] === 'inactive')
                            <span
                                class="text-[10px] bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded font-medium">Soon</span>
                        @endif
                    </div>
                </a>

                <a href="{{ route('user.yt-summarize.index') }}" x-show="isVisible({label: 'YT Summarizer'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('user.yt-summarize.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('user.yt-summarize.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span x-html="highlight('YT Summarizer')">YT Summarizer</span>
                </a>

                <a href="{{ route('icp-builder.index') }}" x-show="isVisible({label: 'ICP Generator'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('icp-builder.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('icp-builder.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></circle>
                        <circle cx="12" cy="12" r="6" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></circle>
                        <circle cx="12" cy="12" r="2" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></circle>
                    </svg>
                    <span x-html="highlight('ICP Generator')">ICP Generator</span>
                </a>

                <p class="px-3 mb-2 text-xs font-medium text-slate-400 uppercase tracking-wider">Career</p>


                {{-- Resume Analyze --}}
                <a href="{{ route('resume-builder.index') }}" x-show="isVisible({label: 'Resume Analyzer'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('resume-builder.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('resume-builder.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span x-html="highlight('Resume Analyzer')">Resume Analyzer</span>
                </a>

                {{-- Job Analyze --}}
                <a href="{{ route('user.job-analyze.index') }}" x-show="isVisible({label: 'Job Analyze'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('user.job-analyze.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('user.job-analyze.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                        </path>
                    </svg>
                    <span x-html="highlight('Job Analyze')">Job Analyze</span>
                    <span id="job-analyze-badge"
                        class="ml-auto text-xs px-1.5 py-0.5 bg-purple-100 text-purple-600 rounded-full font-medium hidden">0</span>
                </a>



                @php $interviewStatus = $featureService->checkAccess(Auth::user(), 'interview_prep'); @endphp
                <a href="{{ $interviewStatus['status'] === 'inactive' ? '#' : route('user.interview-prep.index') }}"
                    x-show="isVisible({label: 'Interview Prep'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('user.interview-prep.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} {{ $interviewStatus['status'] === 'inactive' ? 'opacity-60 cursor-not-allowed' : '' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('user.interview-prep.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <div class="flex-1 flex items-center justify-between">
                        <span x-html="highlight('Interview Prep')">Interview Prep</span>
                        @if ($interviewStatus['status'] === 'inactive')
                            <span
                                class="text-[10px] bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded font-medium">Soon</span>
                        @endif
                    </div>
                </a>
            </div>


            <!-- Account Section -->
            <div class="mb-6" x-show="isSectionVisible('Account')">
                <p class="px-3 mb-2 text-xs font-medium text-slate-400 uppercase tracking-wider">Account</p>





                <a href="{{ route('notifications.index') }}" x-show="isVisible({label: 'Notifications'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('notifications.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('notifications.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <div class="flex-1 flex items-center justify-between">
                        <span x-html="highlight('Notifications')">Notifications</span>
                        <span id="sidebar-notification-badge"
                            class="hidden ml-auto text-xs px-1.5 py-0.5 bg-red-500 text-white rounded-full font-medium">0</span>
                    </div>
                </a>

                <a href="#" x-show="isVisible({label: 'Billing'})"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 cursor-not-allowed opacity-60">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    <span x-html="highlight('Billing')">Billing</span>
                    <span
                        class="ml-auto text-xs px-1.5 py-0.5 bg-slate-100 text-slate-400 rounded font-medium">Soon</span>
                </a>
            </div>
            <a href="{{ route('feedback.dashboard') }}" x-show="isVisible({label: 'Feedback'})"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all cursor-pointer {{ request()->routeIs('feedback.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('feedback.*') ? 'text-blue-600' : 'text-slate-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
                <span x-html="highlight('Feedback')">Feedback</span>
            </a>
            </div>
        </nav>

        {{-- Buy Me a Coffee Button (Styled like official BMC button) --}}
        @php $supportSection = \App\Models\SupportSection::firstActive(); @endphp
        @if ($supportSection && $supportSection->buymeacoffee_url)
            <div class="px-3 pb-3">
                <a href="{{ $supportSection->buymeacoffee_url }}" target="_blank" rel="noopener noreferrer"
                    class="bmc-button flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-150 cursor-pointer hover:opacity-90 active:scale-[0.98]"
                    style="background-color: #FFDD00; color: #000000; font-family: 'Comic Sans MS', 'Chalkboard SE', 'Comic Neue', sans-serif; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                    <img src="https://cdn.buymeacoffee.com/buttons/bmc-new-btn-logo.svg" alt="BMC"
                        class="w-5 h-5">
                    <span>Buy me a coffee</span>
                </a>
            </div>
        @endif


        <!-- User Profile Footer -->
        <div class="p-3 border-t border-slate-100">
            <div
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer group">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 overflow-hidden flex-shrink-0">
                    @if (Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white font-semibold text-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                        class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-md transition-colors cursor-pointer"
                        title="Sign out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Nav Toggle -->
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

            <div class="p-4 flex justify-between items-center border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                        P</div>
                    <span class="font-semibold text-slate-900">ProductOS</span>
                </div>
                <button @click="open = false" class="text-slate-400 hover:text-slate-900 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-900 bg-slate-100 font-medium">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('career-compass.history') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                        </path>
                    </svg>
                    Career Compass
                </a>
                <a href="{{ route('resume-builder.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Resume Analyzer
                </a>
                <a href="{{ route('icp-builder.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50">
                    <i data-lucide="target" class="w-5 h-5 text-slate-400"></i>
                    ICP Generator
                </a>
                <a href="{{ route('user.yt-summarize.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    YT Summarizer
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-slate-50">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                <a href="{{ route('user.interview-prep.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('user.interview-prep.*') ? 'bg-slate-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-slate-50' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('user.interview-prep.*') ? 'text-blue-600' : 'text-slate-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    Interview Prep
                </a>
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Mobile Header Bar -->
        <div
            class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-slate-100 z-30 flex items-center justify-between px-4">
            <button @click="open = true" class="text-slate-500 p-2 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <span class="font-semibold text-slate-900">ProductOS</span>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 overflow-hidden">
                @if (Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-white font-semibold text-xs">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        <!-- Header -->
        <header class="h-14 bg-white border-b border-slate-100 flex items-center justify-between px-6 md:px-8 z-20">
            <h1 class="text-lg font-semibold text-slate-900 hidden md:block">@yield('header', 'Dashboard')</h1>

            <div class="flex items-center gap-4 ml-auto">
                {{-- Credits Display --}}
                <div
                    class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-amber-50 rounded-lg border border-amber-100/50">
                    <i class="fa-solid fa-coins text-amber-500 text-sm"></i>
                    <span class="text-xs font-bold text-amber-700">{{ Auth::user()->credits }} Credits</span>
                </div>

                {{-- Notification Bell --}}
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen"
                        class="flex items-center justify-center w-9 h-9 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all border border-slate-200 hover:border-blue-200 cursor-pointer relative"
                        title="Notifications">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538.214 1.055.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span id="notification-badge"
                            class="hidden absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                            0
                        </span>
                    </button>

                    {{-- Notification Dropdown --}}
                    <div x-show="notifOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.away="notifOpen = false"
                        class="absolute right-0 mt-2 w-96 bg-white border border-slate-200 rounded-2xl shadow-2xl z-50 overflow-hidden"
                        style="display: none;">

                        {{-- Dropdown Header --}}
                        <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-900">Notifications</h3>
                            <div class="flex items-center space-x-2">
                                <span id="dropdown-unread-count" class="text-xs text-slate-500">0 unread</span>
                                <button onclick="markAllAsRead()"
                                    class="text-xs text-indigo-600 hover:text-indigo-700 font-medium cursor-pointer">Mark
                                    all as read</button>
                            </div>
                        </div>

                        {{-- Notifications List --}}
                        <div id="notification-dropdown-list" class="max-h-96 overflow-y-auto">
                            <div class="p-4 text-center text-sm text-slate-500">
                                Loading notifications...
                            </div>
                        </div>

                        {{-- Dropdown Footer --}}
                        <div class="px-4 py-3 border-t border-slate-200">
                            <a href="{{ route('notifications.index') }}"
                                class="block text-center text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('home') }}"
                    class="flex items-center justify-center w-9 h-9 text-slate-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all border border-slate-200 hover:border-blue-200 group cursor-pointer"
                    title="Go to Site">
                    <i
                        class="fa-solid fa-rocket text-sm text-orange-500 group-hover:text-amber-500 transition-colors"></i>
                </a>

                {{-- Profile Dropdown --}}
                <div x-data="{ profileOpen: false }" class="relative">
                    <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false"
                        class="flex items-center gap-2 p-1 pr-3 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer border border-transparent hover:border-slate-200">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 overflow-hidden flex-shrink-0 ring-2 ring-white shadow-sm">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span
                            class="text-sm font-medium text-slate-700 hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                            :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50"
                        style="display: none;">

                        {{-- User Info --}}
                        <div class="px-4 py-3 border-b border-slate-100">
                            <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        {{-- Menu Items --}}
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer {{ request()->routeIs('profile.*') ? 'bg-slate-50 text-blue-600' : '' }}">
                                <svg class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-slate-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-400 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                                <span
                                    class="ml-auto text-[10px] bg-slate-100 text-slate-400 px-1.5 py-0.5 rounded font-medium">Soon</span>
                            </a>
                        </div>

                        {{-- Logout --}}
                        <div class="border-t border-slate-100 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Notice Bar -->
        <div class="z-30">
            <livewire:notice-bar />
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto bg-slate-50 p-6 md:p-8 pt-6">
            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

            {{-- Support Section (appears at total bottom of scrollable area) --}}

        </div>
    </main>

    @livewireScripts

    {{-- Notification System JavaScript --}}
    <script>
        // Notification bell functionality
        let notificationPollingInterval;

        function updateUnreadCount() {
            fetch('{{ route('notifications.unread-count') }}')
                .then(response => response.json())
                .then(data => {
                    updateBadge(data.count, data.display);
                })
                .catch(err => console.log('Error fetching notifications:', err));
        }

        function updateBadge(count, display) {
            const badge = document.getElementById('notification-badge');
            if (badge) {
                if (count > 0) {
                    badge.textContent = display;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }

            const sidebarBadge = document.getElementById('sidebar-notification-badge');
            if (sidebarBadge) {
                if (count > 0) {
                    sidebarBadge.textContent = display;
                    sidebarBadge.classList.remove('hidden');
                } else {
                    sidebarBadge.classList.add('hidden');
                }
            }

            const dropdownCount = document.getElementById('dropdown-unread-count');
            if (dropdownCount) {
                dropdownCount.textContent = count + ' unread';
            }
        }

        function loadDropdownNotifications() {
            fetch('{{ route('notifications.dropdown') }}')
                .then(response => response.json())
                .then(data => {
                    renderDropdownNotifications(data.notifications);
                    updateBadge(data.unread_count, data.unread_count > 99 ? '99+' : data.unread_count);
                })
                .catch(err => console.log('Error loading notifications:', err));
        }

        function renderDropdownNotifications(notifications) {
            const container = document.getElementById('notification-dropdown-list');
            if (!container) return;

            if (notifications.length === 0) {
                container.innerHTML = `
                    <div class="p-8 text-center">
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-slate-500">No notifications yet</p>
                        <p class="text-xs text-slate-400 mt-1">You're all caught up!</p>
                    </div>
                `;
                return;
            }

            // Group notifications by date
            const grouped = groupNotificationsByDate(notifications);

            let html = '';
            for (const [date, items] of Object.entries(grouped)) {
                html += `
                    <div class="px-4 py-2 bg-slate-50">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">${date}</span>
                    </div>
                `;

                items.forEach(item => {
                    html += `
                        <div class="notification-item px-4 py-3 hover:bg-slate-50 cursor-pointer transition-colors ${!item.is_read ? 'bg-indigo-50/50' : ''}"
                             data-notification-id="${item.id}">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 flex-shrink-0" 
                                     style="background-color: ${item.notification.color_code}20">
                                    <i class="${item.notification.icon_class} text-sm" 
                                       style="color: ${item.notification.color_code}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <h4 class="text-sm font-medium ${!item.is_read ? 'text-slate-900' : 'text-slate-700'} truncate max-w-xs">
                                            ${item.notification.title}
                                        </h4>
                                        ${!item.is_read ? '<span class="w-2 h-2 bg-indigo-600 rounded-full ml-2 flex-shrink-0"></span>' : ''}
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1 truncate max-w-xs">
                                        ${item.notification.message}
                                    </p>
                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs text-slate-400">${item.time_since_created}</span>
                                        ${item.notification.action_text && item.notification.action_url ? `
                                                                                                                            <a href="${item.notification.action_url}" target="_blank"
                                                                                                                               onclick="event.stopPropagation(); recordActionClick(${item.id}, '${item.notification.action_url}')"
                                                                                                                               class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                                                                                                                                ${item.notification.action_text}
                                                                                                                            </a>
                                                                                                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            container.innerHTML = html;

            // Add click handlers
            container.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!e.target.closest('a')) {
                        const notificationId = this.dataset.notificationId;
                        markAsRead(notificationId, this);
                    }
                });
            });
        }

        function groupNotificationsByDate(notifications) {
            const grouped = {};

            notifications.forEach(item => {
                const date = new Date(item.created_at);
                let dateKey;

                if (isToday(date)) {
                    dateKey = 'Today';
                } else if (isYesterday(date)) {
                    dateKey = 'Yesterday';
                } else if (diffInDays(date) <= 7) {
                    dateKey = 'This Week';
                } else {
                    dateKey = date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                }

                if (!grouped[dateKey]) {
                    grouped[dateKey] = [];
                }
                grouped[dateKey].push(item);
            });

            return grouped;
        }

        function isToday(date) {
            const today = new Date();
            return date.getDate() === today.getDate() &&
                date.getMonth() === today.getMonth() &&
                date.getFullYear() === today.getFullYear();
        }

        function isYesterday(date) {
            const yesterday = new Date();
            yesterday.setDate(yesterday.getDate() - 1);
            return date.getDate() === yesterday.getDate() &&
                date.getMonth() === yesterday.getMonth() &&
                date.getFullYear() === yesterday.getFullYear();
        }

        function diffInDays(date) {
            const today = new Date();
            const diffTime = Math.abs(today - date);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        }

        function markAsRead(id, element) {
            fetch('{{ route('notifications.read', ':id') }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        element.classList.remove('bg-indigo-50/50');
                        const unreadDot = element.querySelector('.w-2.h-2.bg-indigo-600');
                        if (unreadDot) unreadDot.remove();
                        const title = element.querySelector('h4');
                        if (title) title.classList.remove('text-slate-900', 'text-slate-700');
                        updateBadge(data.unread_count, data.unread_count > 99 ? '99+' : data.unread_count);
                    }
                });
        }

        function recordActionClick(id, url) {
            fetch('{{ route('notifications.action-click', ':id') }}'.replace(':id', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.open(url, '_blank');
                    }
                });
        }

        function markAllAsRead() {
            fetch('{{ route('notifications.mark-all-read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadDropdownNotifications();
                    }
                });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateUnreadCount();
            loadDropdownNotifications();

            // Poll for new notifications every 30 seconds
            notificationPollingInterval = setInterval(() => {
                updateUnreadCount();
            }, 30000);
        });
    </script>

    <!-- Job Analyze JavaScript -->
    @if (request()->routeIs('user.job-analyze.*'))
        <script src="{{ asset('js/job-analyze.js') }}"></script>
    @endif
</body>

</html>
