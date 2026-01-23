@extends('admin.layout')

@section('title', 'Dashboard')

@section('page-title', 'Overview')

@section('content')
    {{-- Top Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @php
            $displayStats = [
                [
                    'label' => 'Total Services',
                    'count' => $stats['services'],
                    'icon' => 'zap',
                    'color' => 'amber',
                    'route' => 'admin.services.index',
                ],
                [
                    'label' => 'Directory Items',
                    'count' => $stats['directory_items'],
                    'icon' => 'folder-open',
                    'color' => 'blue',
                    'route' => 'admin.directory.index',
                ],
                [
                    'label' => 'Pending Reviews',
                    'count' => $stats['directory_pending'],
                    'icon' => 'clock',
                    'color' => 'orange', // Orange was not in map, using amber or adding to config? Tailwind supports orange.
                    // Let's stick to safe colors defined in layout or common
        'bg_class' => 'bg-orange-500/10',
        'text_class' => 'text-orange-600',
        'route' => 'admin.directory.index',
    ],
    [
        'label' => 'Directory Clicks',
        'count' => $stats['directory_clicks'],
        'icon' => 'mouse-pointer', // lucide name
        'color' => 'emerald',
        'route' => 'admin.directory.analytics',
                ],
            ];
        @endphp

        @foreach ($displayStats as $stat)
            <div
                class="group bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-glass transition-soft hover:-translate-y-1 hover:shadow-premium relative overflow-hidden">
                {{-- Decorative Blob --}}
                <div
                    class="absolute top-0 right-0 w-24 h-24 {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/5' : 'bg-slate-100' }} rounded-bl-full translate-x-4 -translate-y-4 transition-soft group-hover:scale-110">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div
                        class="w-12 h-12 rounded-2xl {{ isset($stat['color']) ? 'bg-' . $stat['color'] . '-500/10' : 'bg-slate-100' }} flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}"
                            class="{{ isset($stat['color']) ? 'text-' . $stat['color'] . '-600' : 'text-slate-500' }} w-6 h-6"></i>
                    </div>
                    <a href="{{ route($stat['route']) }}"
                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors">
                        <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                    </a>
                </div>

                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tight">{{ $stat['count'] }}</h3>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Middle Section: Secondary Stats & Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Secondary Metrics --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Featured Directory Items --}}
                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-soft">
                    <div class="flex items-center space-x-6">
                        <div
                            class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                            <i data-lucide="star" class="text-amber-500 w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Featured Items</h4>
                            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['directory_featured'] }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('admin.directory.index', ['featured' => 1]) }}"
                        class="text-indigo-600 font-bold text-sm hover:underline">View</a>
                </div>

                {{-- Impact Projects --}}
                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-soft">
                    <div class="flex items-center space-x-6">
                        <div
                            class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                            <i data-lucide="briefcase" class="text-emerald-600 w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Projects</h4>
                            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['projects'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="text-indigo-600 font-bold text-sm hover:underline">Manage</a>
                </div>

                {{-- Testimonials --}}
                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-soft">
                    <div class="flex items-center space-x-6">
                        <div
                            class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                            <i data-lucide="message-square" class="text-slate-400 group-hover:text-indigo-600 w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Testimonials</h4>
                            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['testimonials'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="text-indigo-600 font-bold text-sm hover:underline">View All</a>
                </div>

                {{-- Footer Config --}}
                <div
                    class="bg-white rounded-[2rem] p-8 border border-slate-200/60 shadow-sm flex items-center justify-between group hover:border-indigo-200 transition-soft">
                    <div class="flex items-center space-x-6">
                        <div
                            class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                            <i data-lucide="settings-2" class="text-slate-400 group-hover:text-indigo-600 w-8 h-8"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-1">Configurations</h4>
                            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $stats['footer'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.footer.index') }}"
                        class="text-indigo-600 font-bold text-sm hover:underline">Manage</a>
                </div>
            </div>

            {{-- Recent Activity / Empty State Placeholder --}}
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-200/60 shadow-sm overflow-hidden relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">Recent Activity</h3>
                    <button
                        class="text-xs font-bold text-indigo-600 uppercase tracking-widest px-4 py-2 bg-indigo-50 rounded-full">Coming
                        Soon</button>
                </div>

                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <i data-lucide="activity" class="w-10 h-10 text-slate-300"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2">Activity Tracking Paused</h4>
                    <p class="text-slate-500 max-w-sm mb-8 leading-relaxed italic">"We're preparing the event log system for
                        the SaaS transition. Stay tuned for real-time updates."</p>
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse delay-75"></div>
                        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse delay-150"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions - Premium Sidebar Style --}}
        <div
            class="bg-indigo-900 rounded-[2.5rem] p-10 text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden group">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative z-10">
                <h3 class="text-2xl font-bold mb-8 tracking-tight">Quick Actions</h3>
                <div class="space-y-4">
                    @php
                        $actions = [
                            ['label' => 'New Hero Unit', 'route' => 'admin.hero.create', 'icon' => 'plus-circle'],
                            ['label' => 'Add New Service', 'route' => 'admin.services.create', 'icon' => 'plus-circle'],
                            ['label' => 'Log Case Study', 'route' => 'admin.projects.create', 'icon' => 'plus-circle'],
                        ];
                    @endphp

                    @foreach ($actions as $action)
                        <a href="{{ route($action['route']) }}"
                            class="flex items-center justify-between px-6 py-4 bg-white/10 border border-white/10 rounded-2xl hover:bg-white/20 hover:scale-[1.02] transition-soft">
                            <div class="flex items-center">
                                <i data-lucide="{{ $action['icon'] }}" class="w-5 h-5 mr-3"></i>
                                <span class="font-bold text-sm">{{ $action['label'] }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-4 h-4 opacity-50"></i>
                        </a>
                    @endforeach

                    <div class="pt-8 mt-8 border-t border-white/10">
                        <a href="{{ url('/') }}" target="_blank"
                            class="flex items-center justify-center w-full px-6 py-4 bg-white text-indigo-900 rounded-2xl font-bold hover:shadow-lg hover:shadow-white/20 transition-soft">
                            <i data-lucide="external-link" class="w-5 h-5 mr-3"></i>
                            View Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
