@extends('admin.layout')

@section('title', 'Feedback Management')

@section('content')
    <div class="px-6 py-6 font-dm-sans min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700">
                    Feedback</h1>
                <p class="text-sm text-slate-500 mt-1">Manage user feedback, bug reports, and feature requests</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.feedback.analytics') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-lg transition-colors shadow-sm gap-2">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Analytics</span>
                </a>
                <a href="{{ route('admin.feedback.export', request()->query()) }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-lg transition-colors shadow-sm gap-2">
                    <i class="fa-solid fa-download"></i>
                    <span>Export CSV</span>
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Feedback</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-comments"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Submitted</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['submitted'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                    <i class="fa-solid fa-hourglass-start"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Bugs</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['bugs'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600">
                    <i class="fa-solid fa-bug"></i>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Resolved</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $stats['resolved'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Filters -->
            <div
                class="p-4 border-b border-slate-100 flex flex-col md:flex-row gap-4 justify-between items-center bg-slate-50/50">
                <form action="{{ route('admin.feedback.index') }}" method="GET"
                    class="flex flex-wrap items-center gap-3 w-full">
                    <div class="relative group w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i
                                class="fa-solid fa-search text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="pl-10 pr-4 py-2 w-full text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white"
                            placeholder="Search feedback...">
                    </div>

                    <select name="type"
                        class="text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white"
                        onchange="this.form.submit()">
                        <option value="all">All Types</option>
                        <option value="bug" {{ request('type') == 'bug' ? 'selected' : '' }}>Bug</option>
                        <option value="feature" {{ request('type') == 'feature' ? 'selected' : '' }}>Feature</option>
                        <option value="satisfaction" {{ request('type') == 'satisfaction' ? 'selected' : '' }}>Satisfaction
                        </option>
                    </select>

                    <select name="status"
                        class="text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white"
                        onchange="this.form.submit()">
                        <option value="all">All Statuses</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted
                        </option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under
                            Review</option>
                        <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>

                    <select name="severity"
                        class="text-sm border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white"
                        onchange="this.form.submit()">
                        <option value="all">Any Severity</option>
                        <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical
                        </option>
                        <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Title</th>
                            <th class="px-6 py-4 font-semibold">Type</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">User</th>
                            <th class="px-6 py-4 font-semibold">Submitted</th>
                            <th class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($feedbackList as $feedback)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $feedback->title }}</div>
                                    <div class="text-xs text-slate-500 truncate max-w-xs">
                                        {{ Str::limit($feedback->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4">
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
                                        <i
                                            class="fa-solid {{ $typeIcon[$feedback->type] ?? 'fa-circle' }} mr-1.5 text-[10px]"></i>
                                        {{ ucfirst($feedback->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase overflow-hidden ring-2 ring-white shadow-sm">
                                            @if ($feedback->user->avatar)
                                                <img src="{{ $feedback->user->avatar }}" alt="{{ $feedback->user->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                {{ substr($feedback->user->name, 0, 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900">{{ $feedback->user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $feedback->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $feedback->created_at->format('M d, Y') }}
                                    <div class="text-xs text-slate-400">
                                        {{ $feedback->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 text-slate-500">
                                        <a href="{{ route('admin.feedback.show', $feedback->feedback_id) }}"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                            title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                        <i class="fa-solid fa-inbox text-2xl"></i>
                                    </div>
                                    <p class="font-medium text-slate-900">No feedback found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or filters</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                {{ $feedbackList->links() }}
            </div>
        </div>
    </div>
@endsection
