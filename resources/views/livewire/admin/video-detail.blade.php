@section('page-title', 'Video Analysis: ' . $video->title)

<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-start">
        <div>
            <a href="{{ route('admin.videos.index') }}"
                class="text-sm text-gray-500 hover:text-gray-700 mb-2 inline-block">← Back to Library</a>

            <div class="mt-2 flex items-center text-gray-600">
                <span class="mr-4">{{ $video->channel_name }}</span>
                <span class="mr-4">• {{ $video->duration }}</span>
                <span>• Uploaded {{ $video->upload_date->format('M d, Y') }}</span>
            </div>
            <div class="mt-2 flex gap-2">
                @foreach ($video->topics as $topic)
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs border">{{ $topic->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ $video->youtube_url }}" target="_blank"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Watch on YouTube
            </a>
            <button wire:click="reprocess"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 border border-gray-300">
                Reprocess AI
            </button>
        </div>
    </div>

    @if ($video->processing_status === 'processing')
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400 animate-spin" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        AI processing in progress. Results will appear here once complete.
                    </p>
                </div>
            </div>
        </div>
    @elseif($video->processing_status === 'failed')
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        Processing failed. Check logs or try reprocessing.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Manual Transcript Upload (shown when transcript fetch failed) -->
    @if ($video->processing_status === 'completed' && empty($video->transcript) && $video->transcript_fetch_error)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-bold text-yellow-900 mb-2">Transcript Not Available</h3>
                    <p class="text-sm text-yellow-800 mb-4">
                        This video's transcript could not be fetched automatically. The captions may be region-locked,
                        corrupted, or not available.
                    </p>
                    <div class="text-sm text-yellow-700 mb-4">
                        <p class="font-semibold mb-1">Error Details:</p>
                        <p class="font-mono text-xs bg-yellow-100 p-2 rounded">{{ $video->transcript_fetch_error }}</p>
                    </div>
                </div>
            </div>

            <!-- Manual Upload Form -->
            <div class="mt-4 pt-4 border-t border-yellow-200">
                <h4 class="text-md font-semibold text-yellow-900 mb-3">Manual Transcript Upload</h4>
                <p class="text-sm text-yellow-700 mb-3">
                    If you have access to the transcript, you can upload it manually to enable AI analysis.
                </p>
                <form wire:submit.prevent="uploadTranscript" class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-yellow-900 mb-1">Transcript Text</label>
                        <textarea wire:model="manual_transcript" rows="10"
                            class="w-full px-3 py-2 border border-yellow-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-sm"
                            placeholder="Paste the transcript text here..."></textarea>
                        @error('manual_transcript')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-yellow-600">
                            Minimum 10 characters required. AI analysis will start automatically after upload.
                        </p>
                        <button type="submit"
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 text-sm font-medium">
                            Upload & Start AI Analysis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Transcript Section - Always show when transcript exists --}}
    @if ($video->transcript)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-gray-800">Full Transcript</h2>
                        <span class="text-sm text-gray-500">({{ number_format(strlen($video->transcript)) }}
                            characters)</span>
                        @if ($video->transcript_fetched_at)
                            <span class="text-xs text-gray-400">Fetched:
                                {{ $video->transcript_fetched_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition class="mt-4">
                    <div
                        class="p-4 bg-gray-50 rounded-lg max-h-96 overflow-y-auto text-sm font-mono whitespace-pre-wrap text-gray-700 leading-relaxed">
                        {{ $video->transcript }}
                    </div>
                </div>
            </div>
        </div>
    @elseif(!$video->transcript && $video->processing_status !== 'processing')
        <div class="bg-gray-50 rounded-lg shadow p-6 mb-6 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">No Transcript Available</h3>
            <p class="text-sm text-gray-500">Click "Reprocess AI" to fetch the transcript, or upload one manually.</p>
        </div>
    @endif

    @if ($video->aiOutput)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Summary -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Executive Summary</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $video->aiOutput->summary_english }}
                    </div>
                </div>

                <!-- Bangla -->
                @if ($video->aiOutput->summary_bangla)
                    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-teal-500">
                        <h2 class="text-xl font-bold mb-4">Bangla Translation</h2>
                        <div class="prose max-w-none text-gray-700 font-bengali">
                            {{ $video->aiOutput->summary_bangla }}
                        </div>
                    </div>
                @endif

                <!-- Insights -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Key Insights</h2>
                    <ul class="space-y-4">
                        @foreach ($video->aiOutput->key_insights ?? [] as $insight)
                            <li class="flex items-start">
                                <span
                                    class="flex-shrink-0 h-6 w-6 rounded-full bg-yellow-100 text-yellow-800 flex items-center justify-center text-xs mr-3 mt-0.5">💡</span>
                                <div>
                                    <p class="text-gray-800">{{ $insight['insight'] ?? $insight }}</p>
                                    @if (isset($insight['timestamp']))
                                        <span
                                            class="text-xs text-gray-500 font-mono bg-gray-100 px-1 rounded">{{ $insight['timestamp'] }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Read Reason -->
                <div class="bg-indigo-50 rounded-lg p-6 border border-indigo-100">
                    <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wide mb-2">Why Watch This?</h3>
                    <p class="text-indigo-800">{{ $video->aiOutput->read_reason }}</p>
                </div>

                <!-- Actionable Skills -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold mb-4">Actionable Skills</h3>
                    <div class="space-y-3">
                        @foreach ($video->aiOutput->actionable_skills ?? [] as $skill)
                            <div class="p-3 bg-gray-50 rounded border border-gray-200">
                                <div class="font-semibold text-gray-800">{{ $skill['skill'] ?? 'Skill' }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $skill['context'] ?? '' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- FAQ -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold mb-4">FAQ</h3>
                    <div class="space-y-4">
                        @foreach ($video->aiOutput->faqs ?? [] as $faq)
                            <div>
                                <div class="font-medium text-gray-900 text-sm">Q: {{ $faq['question'] ?? '' }}</div>
                                <div class="text-gray-600 text-sm mt-1">A: {{ $faq['answer'] ?? '' }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
