<div>
    @if ($notice)
        <div x-data="{
            dismissed: false,
            noticeId: '{{ $notice->id }}',
            init() {
                if (localStorage.getItem('dismissed_notice_' + this.noticeId)) {
                    this.dismissed = true;
                }
            },
            dismiss() {
                this.dismissed = true;
                localStorage.setItem('dismissed_notice_' + this.noticeId, 'true');
            }
        }" x-show="!dismissed" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-full"
            class="relative bg-gradient-to-r from-indigo-600 to-violet-600 text-white px-4 py-3 shadow-lg z-50">

            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white/10">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.664A2 1.002 2 1.002 0 0112 10.07V4.228a2 2 0 01-.108-.545A2 2 0 0113.89 1.666a2 2 0 00-1 4.227V19a2 2 0 01-2 2h-.182a2 2 0 01-2-2v-6.336z" />
                            {{-- Using a megaphone icon roughly --}}
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    </span>
                    <div class="text-sm font-medium truncate">
                        <span class="font-bold opacity-90 mr-1">{{ $notice->title }}:</span>
                        <span class="opacity-90">{!! nl2br(e($notice->message)) !!}</span>
                    </div>
                </div>

                @if ($notice->dismissible)
                    <button @click="dismiss"
                        class="p-1.5 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition-colors flex-shrink-0"
                        title="Dismiss">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
