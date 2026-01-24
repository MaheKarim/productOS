<div class="space-y-8" x-data="{
    toasts: [],
    addToast(type, message) {
        const id = Date.now();
        this.toasts.push({ id, type, message });
        setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 4000);
    }
}" @notify.window="addToast($event.detail.type, $event.detail.message)">

    <!-- Toast Notifications -->
    <div class="fixed top-24 right-6 z-50 space-y-3">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-8"
                :class="toast.type === 'success' ? 'bg-gradient-to-r from-teal-500 to-emerald-500' :
                    'bg-gradient-to-r from-amber-500 to-orange-500'"
                class="px-5 py-3 rounded-2xl shadow-2xl text-white font-semibold text-sm flex items-center gap-3 backdrop-blur-sm">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </template>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    <!-- Hero Section (Auth CTA for Guests) -->
    @guest
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-teal-500 to-emerald-500 p-8 md:p-12 text-white shadow-2xl">
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4=')] opacity-30">
            </div>
            <div class="relative z-10 text-center max-w-2xl mx-auto">
                <div
                    class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    Free Progress Tracking
                </div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Track Your PM Journey</h2>
                <p class="text-lg text-white/90 mb-8">Log in to save your progress, unlock personalized analytics, and track
                    your growth as a Product Manager.</p>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-teal-600 font-bold rounded-2xl hover:bg-teal-50 transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Log In to Track Progress
                </a>
            </div>
        </div>
    @else
        <livewire:roadmap.analytics />
    @endguest

    <!-- Categories & Topics -->
    @foreach ($categories as $index => $category)
        <div class="relative" x-data="{ open: true }">
            <!-- Category Header -->
            <button @click="open = !open"
                class="w-full flex items-center justify-between p-5 bg-white/80 backdrop-blur-xl border border-gray-200/60 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer group mb-4">
                <div class="flex items-center gap-4">
                    @php
                        $icons = [
                            'Foundational Skills' =>
                                'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                            'Product Development Lifecycle' =>
                                'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                            'Data & Analytics' =>
                                'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                            'Business & Strategy' =>
                                'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'Communication & Leadership' =>
                                'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'Technical Knowledge' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                            'Specialized Tracks' =>
                                'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                        ];
                        $iconPath = $icons[$category->name] ?? 'M4 6h16M4 10h16M4 14h16M4 18h16';
                        $categoryColors = [
                            'Foundational Skills' => 'from-blue-500 to-indigo-600',
                            'Product Development Lifecycle' => 'from-emerald-500 to-teal-600',
                            'Data & Analytics' => 'from-violet-500 to-purple-600',
                            'Business & Strategy' => 'from-amber-500 to-orange-600',
                            'Communication & Leadership' => 'from-pink-500 to-rose-600',
                            'Technical Knowledge' => 'from-cyan-500 to-blue-600',
                            'Specialized Tracks' => 'from-fuchsia-500 to-purple-600',
                        ];
                        $gradientClass = $categoryColors[$category->name] ?? 'from-gray-500 to-gray-600';
                    @endphp
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $gradientClass }} flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $iconPath }}"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h3 class="text-lg font-bold text-gray-900">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->topics->count() }} topics</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $completed = $category->topics
                                ->filter(fn($t) => $t->userProgress && $t->userProgress->status >= 2)
                                ->count();
                            $total = $category->topics->count();
                            $pct = $total > 0 ? round(($completed / $total) * 100) : 0;
                        @endphp
                        <div class="hidden sm:flex items-center gap-2">
                            <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r {{ $gradientClass }} transition-all duration-500"
                                    style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-500">{{ $pct }}%</span>
                        </div>
                    @endauth
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </button>

            <!-- Topics Grid -->
            <div x-show="open" x-collapse class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($category->topics as $topic)
                    @php
                        $progress = $topic->userProgress ?? null;
                        $initialStatus = $progress ? $progress->status : 0;
                    @endphp
                    <div x-data="{
                        showActions: false,
                        status: {{ $initialStatus }},
                        loading: false,
                        statusConfig: {
                            0: { bg: 'bg-white', border: 'border-gray-200', text: 'text-gray-600', badge: 'bg-gray-100 text-gray-500', label: 'Not Started' },
                            1: { bg: 'bg-amber-50', border: 'border-amber-300', text: 'text-amber-700', badge: 'bg-amber-100 text-amber-600', label: 'In Progress' },
                            2: { bg: 'bg-emerald-50', border: 'border-emerald-400', text: 'text-emerald-700', badge: 'bg-emerald-100 text-emerald-600', label: 'Completed' },
                            3: { bg: 'bg-blue-50', border: 'border-blue-400', text: 'text-blue-700', badge: 'bg-blue-100 text-blue-600', label: 'Mastered' }
                        },
                        get cfg() { return this.statusConfig[this.status]; },
                        async updateStatus(newStatus) {
                            @guest
$dispatch('notify', { type: 'warning', message: 'Please log in to track your progress.' });
                                return; @endguest
                    
                            if (this.loading) return;
                            this.loading = true;
                            const oldStatus = this.status;
                            this.status = newStatus; // Optimistic update
                    
                            try {
                                const response = await fetch('{{ route('roadmap.update-status') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ topic_id: {{ $topic->id }}, status: newStatus })
                                });
                    
                                const data = await response.json();
                    
                                if (data.success) {
                                    $dispatch('notify', { type: 'success', message: data.message });
                                    // Dispatch Livewire event to refresh Analytics component
                                    if (typeof Livewire !== 'undefined') {
                                        Livewire.dispatch('roadmap-updated');
                                    }
                                } else {
                                    this.status = oldStatus; // Revert on failure
                                    $dispatch('notify', { type: 'warning', message: 'Failed to update status.' });
                                }
                            } catch (error) {
                                this.status = oldStatus; // Revert on error
                                $dispatch('notify', { type: 'warning', message: 'Network error. Please try again.' });
                            } finally {
                                this.loading = false;
                            }
                        }
                    }" :class="cfg.bg + ' border-2 ' + cfg.border"
                        class="relative rounded-2xl p-5 hover:shadow-xl transition-all duration-200 cursor-pointer group"
                        @mouseenter="showActions = true" @mouseleave="showActions = false">

                        <!-- Topic Header -->
                        <div class="flex items-start justify-between mb-3">
                            <h4 :class="cfg.text" class="font-bold text-base leading-tight pr-2">
                                {{ $topic->name }}</h4>
                            <span :class="cfg.badge"
                                class="shrink-0 text-[10px] uppercase font-bold px-2 py-1 rounded-lg"
                                x-text="cfg.label"></span>
                        </div>

                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $topic->description }}</p>

                        <!-- Quick Action Buttons -->
                        <div class="flex flex-wrap gap-2" x-show="showActions"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <button @click="updateStatus(0)" :disabled="loading"
                                :class="{ 'ring-2 ring-gray-400': status == 0, 'opacity-50': loading }"
                                class="flex-1 min-w-[70px] px-3 py-2 text-xs font-semibold rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors duration-150 cursor-pointer">
                                Reset
                            </button>
                            <button @click="updateStatus(1)" :disabled="loading"
                                :class="{ 'ring-2 ring-amber-400': status == 1, 'opacity-50': loading }"
                                class="flex-1 min-w-[70px] px-3 py-2 text-xs font-semibold rounded-xl bg-amber-100 hover:bg-amber-200 text-amber-700 transition-colors duration-150 cursor-pointer">
                                Learning
                            </button>
                            <button @click="updateStatus(2)" :disabled="loading"
                                :class="{ 'ring-2 ring-emerald-400': status == 2, 'opacity-50': loading }"
                                class="flex-1 min-w-[70px] px-3 py-2 text-xs font-semibold rounded-xl bg-emerald-100 hover:bg-emerald-200 text-emerald-700 transition-colors duration-150 cursor-pointer">
                                Done
                            </button>
                            <button @click="updateStatus(3)" :disabled="loading"
                                :class="{ 'ring-2 ring-blue-400': status == 3, 'opacity-50': loading }"
                                class="flex-1 min-w-[70px] px-3 py-2 text-xs font-semibold rounded-xl bg-blue-100 hover:bg-blue-200 text-blue-700 transition-colors duration-150 cursor-pointer">
                                Mastered
                            </button>
                        </div>

                        <!-- Default state hint -->
                        <div x-show="!showActions" class="text-xs text-gray-400 text-center">
                            <span class="hidden sm:inline">Hover to update status</span>
                            <span class="sm:hidden" @click="showActions = !showActions">Tap to update</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
