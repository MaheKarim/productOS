@extends('admin.layout')

@section('page-title', 'Strategic Roadmap Sessions')

@section('content')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Product Info</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center mr-3">
                                        <span
                                            class="text-xs font-bold text-slate-500">{{ substr($session->user->name ?? 'Guest', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">
                                            {{ $session->user->name ?? 'Guest User' }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $session->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="inline-flex items-center w-fit px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        {{ ucfirst(str_replace('_', ' ', $session->product_type ?? 'N/A')) }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        Stage: {{ ucfirst($session->product_stage ?? '-') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $session->status === 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($session->status === 'generating'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-slate-100 text-slate-600') }}">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($session->progress)
                                    <div class="w-24">
                                        <div class="text-xs font-medium text-slate-700 mb-1">
                                            {{ $session->progress->completed_steps }}/{{ $session->progress->total_steps }}
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                                            <div class="bg-indigo-500 h-1.5 rounded-full"
                                                style="width: {{ $session->progress->total_steps > 0 ? ($session->progress->completed_steps / $session->progress->total_steps) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">No progress</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $session->created_at->format('M d, Y') }}
                                <div class="text-xs text-slate-400">{{ $session->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.strategic-roadmap.show', $session->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                        <i data-lucide="inbox" class="w-6 h-6 text-slate-400"></i>
                                    </div>
                                    <p class="text-sm font-medium">No roadmap sessions found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sessions->hasPages())
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
@endsection
