<div>
    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Type Selection -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">What type of feedback would you like to submit?</h2>
            @if (empty($type))
                <p class="text-sm text-gray-500 mb-4">Please select one of the options below to continue.</p>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="cursor-pointer">
                    <input type="radio" wire:model.live="type" value="bug" class="sr-only peer">
                    <div
                        class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all hover:border-gray-300">
                        <i class="fas fa-bug text-3xl text-red-500 mb-2"></i>
                        <h3 class="font-semibold text-gray-900">Bug Report</h3>
                        <p class="text-sm text-gray-600 mt-1">Report an issue or problem</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" wire:model.live="type" value="feature" class="sr-only peer">
                    <div
                        class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-green-500 peer-checked:bg-green-50 transition-all hover:border-gray-300">
                        <i class="fas fa-lightbulb text-3xl text-green-500 mb-2"></i>
                        <h3 class="font-semibold text-gray-900">Feature Request</h3>
                        <p class="text-sm text-gray-600 mt-1">Suggest a new feature</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" wire:model.live="type" value="satisfaction" class="sr-only peer">
                    <div
                        class="border-2 border-gray-200 rounded-lg p-4 text-center peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition-all hover:border-gray-300">
                        <i class="fas fa-smile text-3xl text-yellow-500 mb-2"></i>
                        <h3 class="font-semibold text-gray-900">General Feedback</h3>
                        <p class="text-sm text-gray-600 mt-1">Share your thoughts</p>
                    </div>
                </label>
            </div>
            @if (!empty($type))
                <div class="mt-4 text-center">
                    <button type="button" wire:click="clearTypeSelection"
                        class="text-sm text-gray-500 hover:text-gray-700 underline">
                        ← Change selection
                    </button>
                </div>
            @endif
            @error('type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Common Fields -->
        <div class="bg-white rounded-lg shadow p-6 space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model="title" id="title" maxlength="100"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Brief summary of your feedback">
                <div class="flex justify-between mt-1">
                    @error('title')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <span class="text-sm text-gray-500">{{ strlen($title) }}/100</span>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span
                        class="text-red-500">*</span></label>
                <textarea wire:model="description" id="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Please provide detailed information..."></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Bug Report Fields -->
        @if ($type === 'bug')
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Bug Report Details</h2>

                <div>
                    <label for="severity" class="block text-sm font-medium text-gray-700 mb-1">Severity Level</label>
                    <select wire:model="severity" id="severity"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="low">Low - Minor issue, workaround available</option>
                        <option value="medium">Medium - Issue affects usability</option>
                        <option value="high">High - Major issue, no workaround</option>
                        <option value="critical">Critical - System breaking issue</option>
                    </select>
                    @error('severity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="steps_to_reproduce" class="block text-sm font-medium text-gray-700 mb-1">Steps to
                        Reproduce</label>
                    <textarea wire:model="steps_to_reproduce" id="steps_to_reproduce" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="1. Go to...&#10;2. Click on...&#10;3. Scroll down to..."></textarea>
                    @error('steps_to_reproduce')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="expected_behavior" class="block text-sm font-medium text-gray-700 mb-1">Expected
                            Behavior</label>
                        <textarea wire:model="expected_behavior" id="expected_behavior" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="What should have happened?"></textarea>
                        @error('expected_behavior')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="actual_behavior" class="block text-sm font-medium text-gray-700 mb-1">Actual
                            Behavior</label>
                        <textarea wire:model="actual_behavior" id="actual_behavior" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="What actually happened?"></textarea>
                        @error('actual_behavior')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        <!-- Feature Request Fields -->
        @if ($type === 'feature')
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Feature Request Details</h2>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select wire:model="priority" id="priority"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="nice_to_have">Nice-to-have</option>
                        <option value="must_have">Must-have</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="use_case" class="block text-sm font-medium text-gray-700 mb-1">Use Case / Problem it
                        Solves</label>
                    <textarea wire:model="use_case" id="use_case" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Describe the problem this feature would solve..."></textarea>
                    @error('use_case')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endif

        <!-- Satisfaction Feedback Fields -->
        @if ($type === 'satisfaction')
            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Satisfaction Feedback</h2>

                <div>
                    <label for="satisfaction_rating" class="block text-sm font-medium text-gray-700 mb-1">Overall
                        Satisfaction Rating</label>
                    <div class="flex items-center space-x-2">
                        @for ($i = 1; $i <= 10; $i++)
                            <button type="button" wire:click="$set('satisfaction_rating', {{ $i }})"
                                class="w-10 h-10 rounded-full border-2 {{ $satisfaction_rating >= $i ? 'bg-yellow-400 border-yellow-500 text-white' : 'border-gray-300 text-gray-600' }} hover:border-yellow-500 transition-colors">
                                {{ $i }}
                            </button>
                        @endfor
                    </div>
                    @error('satisfaction_rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="satisfaction_category"
                        class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select wire:model="satisfaction_category" id="satisfaction_category"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="design">Design</option>
                        <option value="performance">Performance</option>
                        <option value="content">Content</option>
                        <option value="navigation">Navigation</option>
                        <option value="other">Other</option>
                    </select>
                    @error('satisfaction_category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="whats_working" class="block text-sm font-medium text-gray-700 mb-1">What's Working
                        Well? (Optional)</label>
                    <textarea wire:model="whats_working" id="whats_working" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Tell us what you like..."></textarea>
                    @error('whats_working')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="needs_improvement" class="block text-sm font-medium text-gray-700 mb-1">What Needs
                        Improvement? (Optional)</label>
                    <textarea wire:model="needs_improvement" id="needs_improvement" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Tell us what could be better..."></textarea>
                    @error('needs_improvement')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endif

        <!-- Attachments -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Attachments (Optional)</h2>
            <p class="text-sm text-gray-600 mb-4">Upload screenshots or videos to help us understand your feedback
                better. Max 3 files, 10MB each.</p>

            <div
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                <input type="file" wire:model="attachments" multiple
                    accept=".jpg,.jpeg,.png,.gif,.pdf,.mp4,.webm,.mov" class="hidden" id="file-upload">
                <label for="file-upload" class="cursor-pointer">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Click to upload or drag and drop</p>
                    <p class="text-sm text-gray-500 mt-1">JPG, PNG, GIF, PDF, MP4, WebM, MOV (max 10MB)</p>
                </label>
            </div>

            @if (count($attachments) > 0)
                <div class="mt-4 space-y-2">
                    @foreach ($attachments as $index => $attachment)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center">
                                <i class="fas fa-file text-gray-400 mr-3"></i>
                                <span class="text-sm text-gray-900">{{ $attachment->getClientOriginalName() }}</span>
                            </div>
                            <button type="button" wire:click="removeAttachment({{ $index }})"
                                class="text-red-500 hover:text-red-700 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            @error('attachments')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Page URL -->
        <div class="bg-white rounded-lg shadow p-6">
            <label for="page_url" class="block text-sm font-medium text-gray-700 mb-1">Page URL (Optional)</label>
            <input type="url" wire:model="page_url" id="page_url"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="https://example.com/page">
            @error('page_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Submit Feedback</span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Submitting...
                </span>
            </button>
        </div>

        @error('submit')
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-red-800">
                {{ $message }}
            </div>
        @enderror
    </form>
</div>
