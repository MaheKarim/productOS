<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-comments text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Feedback</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $this->feedbackCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $this->activeFeedbackCount }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Resolved</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $this->resolvedFeedbackCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select wire:model="filterType"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">All Types</option>
                    <option value="bug">Bug Reports</option>
                    <option value="feature">Feature Requests</option>
                    <option value="satisfaction">General Feedback</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model="filterStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="all">All Status</option>
                    <option value="submitted">Submitted</option>
                    <option value="under_review">Under Review</option>
                    <option value="planned">Planned</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                <select wire:model="sortBy"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="updated">Last Updated</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Feedback List -->
    @if ($feedbackList->count() > 0)
        <div class="space-y-4">
            @foreach ($feedbackList as $feedback)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="{{ $feedback->type_icon }} text-xl"
                                    style="color: {{ $feedback->type_color }}"></i>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $feedback->title }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-medium"
                                    style="background-color: {{ $feedback->status_color }}20; color: {{ $feedback->status_color }}">
                                    <i class="{{ $feedback->status_icon }} mr-1"></i>
                                    {{ $feedback->status_label }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $feedback->description }}</p>
                            <div class="flex items-center gap-4 text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $feedback->created_at->format('M d, Y') }}
                                </span>
                                @if ($feedback->updated_at > $feedback->created_at)
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        Updated {{ $feedback->updated_at->diffForHumans() }}
                                    </span>
                                @endif
                                @if ($feedback->attachments->count() > 0)
                                    <span>
                                        <i class="fas fa-paperclip mr-1"></i>
                                        {{ $feedback->attachments->count() }} attachment(s)
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('feedback.show', $feedback->feedback_id) }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $feedbackList->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-inbox text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No feedback yet</h3>
            <p class="text-gray-600 mb-6">You haven't submitted any feedback yet. Share your thoughts to help us
                improve!</p>
            <a href="{{ route('feedback.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Submit Feedback
            </a>
        </div>
    @endif
</div>
