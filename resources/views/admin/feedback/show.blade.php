@extends('admin.layout')

@section('title', 'Feedback Details')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="mb-6">
            <a href="{{ route('admin.feedback.index') }}"
                class="inline-flex items-center text-sm text-slate-500 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back to Feedback List
            </a>
        </div>

        <div class="flex justify-between items-start mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-slate-900">{{ $feedback->title }}</h1>
                    @php
                        $typeColors = [
                            'bug' => 'bg-red-100 text-red-700 border-red-200',
                            'feature' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'satisfaction' => 'bg-blue-100 text-blue-700 border-blue-200',
                        ];
                        $typeIcon = [
                            'bug' => 'fa-bug',
                            'feature' => 'fa-lightbulb',
                            'satisfaction' => 'fa-smile',
                        ];
                    @endphp
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $typeColors[$feedback->type] ?? 'bg-slate-100 text-slate-700 border-slate-200' }}">
                        <i class="fa-solid {{ $typeIcon[$feedback->type] ?? 'fa-circle' }} mr-1.5 text-[10px]"></i>
                        {{ ucfirst($feedback->type) }}
                    </span>
                    <span class="text-sm text-slate-500">#{{ $feedback->feedback_id }}</span>
                </div>
                <div class="flex items-center gap-4 text-sm text-slate-500">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-clock"></i>
                        Submitted {{ $feedback->created_at->format('M d, Y H:i') }}
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-user"></i>
                        {{ $feedback->user->name }} ({{ $feedback->user->email }})
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Current Status: {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Description</h3>
                    <div class="prose prose-slate max-w-none text-slate-600">
                        {!! nl2br(e($feedback->description)) !!}
                    </div>

                    @if ($feedback->attachments && $feedback->attachments->count() > 0)
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <h4 class="text-sm font-bold text-slate-900 mb-3">Attachments</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($feedback->attachments as $attachment)
                                    <a href="{{ Storage::url($attachment->path) }}" target="_blank"
                                        class="block group relative rounded-lg overflow-hidden border border-slate-200 aspect-square bg-slate-50 flex items-center justify-center">
                                        @if (Str::startsWith($attachment->mime_type, 'image/'))
                                            <img src="{{ Storage::url($attachment->path) }}" alt="Attachment"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i
                                                class="fa-solid fa-file text-3xl text-slate-400 group-hover:text-blue-500 transition-colors"></i>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <i class="fa-solid fa-external-link text-white"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Activity/History -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-6">Activity History</h3>
                    <div class="relative pl-4 border-l-2 border-slate-100 space-y-8">
                        @foreach ($feedback->statusHistory as $history)
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-white {{ $history->is_visible_to_user ? 'bg-blue-500' : 'bg-amber-500' }}">
                                </div>
                                <div class="mb-1 flex items-center justify-between">
                                    <p class="text-sm font-bold text-slate-900">
                                        @if ($history->old_status !== $history->new_status)
                                            Status changed to <span
                                                class="text-blue-600">{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</span>
                                        @else
                                            Internal Note Added
                                        @endif
                                    </p>
                                    <span class="text-xs text-slate-400">{{ $history->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mb-2">
                                    by {{ $history->adminUser ? $history->adminUser->name : 'System' }}
                                    @if (!$history->is_visible_to_user)
                                        <span
                                            class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                            <i class="fa-solid fa-lock mr-1"></i> Internal
                                        </span>
                                    @endif
                                </p>
                                @if ($history->admin_comment)
                                    <div class="bg-slate-50 rounded-lg p-3 text-sm text-slate-700">
                                        {{ $history->admin_comment }}
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Initial Submission -->
                        <div class="relative">
                            <div
                                class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-white bg-slate-300">
                            </div>
                            <div class="mb-1">
                                <p class="text-sm font-bold text-slate-900">Feedback Submitted</p>
                                <span
                                    class="text-xs text-slate-400">{{ $feedback->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <p class="text-xs text-slate-500">by {{ $feedback->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Update Status -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Update Status</h3>
                    <form action="{{ route('admin.feedback.update-status', $feedback->feedback_id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">New Status</label>
                                <select name="status"
                                    class="w-full text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    @foreach (['submitted', 'under_review', 'planned', 'in_progress', 'resolved', 'closed'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $feedback->status == $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1">Comment (Optional)</label>
                                <textarea name="admin_comment" rows="3"
                                    class="w-full text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white"
                                    placeholder="Add a comment..."></textarea>
                            </div>

                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="is_visible_to_user" id="is_visible_to_user" value="1"
                                    checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_visible_to_user"
                                    class="text-xs text-slate-600 select-none cursor-pointer">Notify user & show
                                    comment</label>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Internal Note -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Internal Note</h3>
                    <form action="{{ route('admin.feedback.add-internal-note', $feedback->feedback_id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <textarea name="note" rows="3" required
                                    class="w-full text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 bg-amber-50/50 placeholder-amber-400"
                                    placeholder="Add a private note only visible to admins..."></textarea>
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-800 text-sm font-medium rounded-lg transition-colors shadow-sm border border-amber-200">
                                Add Note
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Meta Info -->
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Feedback ID</span>
                        <span class="font-mono text-slate-700">{{ $feedback->feedback_id }}</span>
                    </div>
                    @if ($feedback->type == 'bug')
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Severity</span>
                            <span
                                class="font-medium {{ $feedback->severity == 'critical' ? 'text-red-600' : ($feedback->severity == 'high' ? 'text-orange-600' : 'text-slate-700') }}">
                                {{ ucfirst($feedback->severity) }}
                            </span>
                        </div>
                    @endif
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Created</span>
                        <span class="text-slate-700">{{ $feedback->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">User IP</span>
                        <span class="font-mono text-slate-700">{{ $feedback->ip_address ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
