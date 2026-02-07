<div>
    @if ($feedback)
        <!-- Status Badge -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-2 rounded-full text-sm font-medium"
                        style="background-color: {{ $feedback->status_color }}20; color: {{ $feedback->status_color }}">
                        <i class="{{ $feedback->status_icon }} mr-2"></i>
                        {{ $feedback->status_label }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $feedback->updated_at->diffForHumans() }}
                    </span>
                </div>
                <div class="text-sm text-gray-500">
                    <span class="font-mono font-semibold">{{ $feedback->feedback_id }}</span>
                </div>
            </div>
            <p class="mt-3 text-gray-700">{{ $feedback->status_message }}</p>
        </div>

        <!-- Feedback Details -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="{{ $feedback->type_icon }} text-2xl" style="color: {{ $feedback->type_color }}"></i>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $feedback->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $feedback->type_label }}</p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Your Feedback</h3>
                <p class="text-gray-900 whitespace-pre-wrap">{{ $feedback->description }}</p>
            </div>

            <!-- Bug Report Details -->
            @if ($feedback->type === 'bug')
                @if ($feedback->severity)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Severity</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            style="background-color: {{ $feedback->severity_color }}20; color: {{ $feedback->severity_color }}">
                            {{ $feedback->severity_label }}
                        </span>
                    </div>
                @endif

                @if ($feedback->steps_to_reproduce)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Steps to Reproduce</h3>
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $feedback->steps_to_reproduce }}</p>
                    </div>
                @endif

                @if ($feedback->expected_behavior || $feedback->actual_behavior)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($feedback->expected_behavior)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Expected Behavior</h3>
                                    <p class="text-gray-900">{{ $feedback->expected_behavior }}</p>
                                </div>
                            @endif
                            @if ($feedback->actual_behavior)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Actual Behavior</h3>
                                    <p class="text-gray-900">{{ $feedback->actual_behavior }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            <!-- Feature Request Details -->
            @if ($feedback->type === 'feature')
                @if ($feedback->priority)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Priority</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            style="background-color: {{ $feedback->priority_color }}20; color: {{ $feedback->priority_color }}">
                            {{ $feedback->priority_label }}
                        </span>
                    </div>
                @endif

                @if ($feedback->use_case)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Use Case / Problem it Solves</h3>
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $feedback->use_case }}</p>
                    </div>
                @endif
            @endif

            <!-- Satisfaction Feedback Details -->
            @if ($feedback->type === 'satisfaction')
                @if ($feedback->satisfaction_rating)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Satisfaction Rating</h3>
                        <div class="flex items-center gap-1">
                            @for ($i = 1; $i <= 10; $i++)
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium {{ $i <= $feedback->satisfaction_rating ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif

                @if ($feedback->satisfaction_category)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Category</h3>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $feedback->satisfaction_category_label }}
                        </span>
                    </div>
                @endif

                @if ($feedback->whats_working)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">What's Working Well</h3>
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $feedback->whats_working }}</p>
                    </div>
                @endif

                @if ($feedback->needs_improvement)
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">What Needs Improvement</h3>
                        <p class="text-gray-900 whitespace-pre-wrap">{{ $feedback->needs_improvement }}</p>
                    </div>
                @endif
            @endif

            <!-- Technical Info -->
            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Technical Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Submitted:</span>
                        <span
                            class="text-gray-900 ml-2">{{ $feedback->created_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                    @if ($feedback->page_url)
                        <div>
                            <span class="text-gray-500">Page URL:</span>
                            <a href="{{ $feedback->page_url }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 ml-2 truncate block">
                                {{ $feedback->page_url }}
                            </a>
                        </div>
                    @endif
                    @if ($feedback->device_info)
                        <div>
                            <span class="text-gray-500">Device:</span>
                            <span class="text-gray-900 ml-2">{{ $feedback->device_info }}</span>
                        </div>
                    @endif
                    @if ($feedback->browser_info)
                        <div>
                            <span class="text-gray-500">Browser:</span>
                            <span class="text-gray-900 ml-2 truncate">{{ $feedback->browser_info }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Attachments -->
            @if ($feedback->attachments->count() > 0)
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Attachments</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($feedback->attachments as $attachment)
                            <div class="border border-gray-200 rounded-lg p-4">
                                @if ($attachment->isImage())
                                    <a href="{{ $attachment->file_url }}" target="_blank" class="block">
                                        <img src="{{ $attachment->file_url }}" alt="{{ $attachment->file_name }}"
                                            class="w-full h-32 object-cover rounded">
                                    </a>
                                @elseif($attachment->isVideo())
                                    <a href="{{ $attachment->file_url }}" target="_blank" class="block">
                                        <div class="w-full h-32 bg-gray-100 rounded flex items-center justify-center">
                                            <i class="fas fa-video text-4xl text-gray-400"></i>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ $attachment->file_url }}" target="_blank"
                                        class="flex items-center justify-center h-32 bg-gray-100 rounded">
                                        <div class="text-center">
                                            <i class="fas fa-file text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-600 truncate">{{ $attachment->file_name }}</p>
                                        </div>
                                    </a>
                                @endif
                                <p class="text-xs text-gray-500 mt-2">{{ $attachment->human_file_size }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Status History -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status History</h3>
            <div class="space-y-4">
                @foreach ($feedback->statusHistory as $history)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center"
                                style="background-color: {{ $feedback->status_color }}20">
                                <i class="fas fa-check text-sm" style="color: {{ $feedback->status_color }}"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-900">{{ $history->new_status_label }}</span>
                                <span
                                    class="text-sm text-gray-500">{{ $history->created_at->format('M d, Y \a\t g:i A') }}</span>
                            </div>
                            @if ($history->admin_comment)
                                <p class="text-gray-600 mt-1 bg-gray-50 rounded p-3">{{ $history->admin_comment }}</p>
                            @endif
                            @if ($history->adminUser)
                                <p class="text-sm text-gray-500 mt-1">
                                    by {{ $history->adminUser->name }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        @if ($feedback->canBeWithdrawn())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <button wire:click="withdraw"
                    wire:confirm="Are you sure you want to withdraw this feedback? This action cannot be undone."
                    class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Withdraw Feedback
                </button>
            </div>
        @endif

        @error('withdraw')
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4 text-red-800">
                {{ $message }}
            </div>
        @enderror
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-triangle text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Feedback not found</h3>
            <p class="text-gray-600 mb-6">The feedback you're looking for doesn't exist or you don't have permission to
                view it.</p>
            <a href="{{ route('feedback.dashboard') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-list mr-2"></i>
                Back to My Feedback
            </a>
        </div>
    @endif
</div>
