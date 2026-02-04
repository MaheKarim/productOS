@extends('admin.layout')

@section('page-title', 'Notice Bars')

@section('content')
    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-slate-500 text-sm">Manage site-wide announcements and alerts.</p>
            </div>
            <a href="{{ route('admin.notice-bars.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/40">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Create New Notice
            </a>
        </div>

        {{-- Stats Grid (Optional) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                            <i data-lucide="activity" class="w-5 h-5"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Active</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">{{ \App\Models\NoticeBar::active()->count() }}</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                            <i data-lucide="megaphone" class="w-5 h-5"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">{{ $notices->count() }}</div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Reach</span>
                    </div>
                    <div class="text-3xl font-bold text-slate-900">All Users</div>
                </div>
            </div>
        </div>


        {{-- Table Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-200/60 shadow-glass overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/50 border-b border-slate-200/60 text-xs uppercase tracking-widest text-slate-500 font-bold">
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 w-1/3">Content</th>
                            <th class="px-8 py-6">Audience</th>
                            <th class="px-8 py-6">Schedule</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($notices as $notice)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-8 py-5">
                                    @if ($notice->is_active)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-500/5">
                                            <span class="relative flex h-2 w-2">
                                                <span
                                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span
                                                    class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col gap-1">
                                        <span class="font-bold text-slate-800 text-base font-display">
                                            {{ Str::limit($notice->title, 40) }}
                                        </span>
                                        <span class="text-sm text-slate-500 line-clamp-1">
                                            {{ Str::limit($notice->message, 80) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border
                                        {{ $notice->audience === 'all' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : '' }}
                                        {{ $notice->audience === 'pro' ? 'bg-purple-50 text-purple-600 border-purple-100' : '' }}
                                        {{ $notice->audience === 'free' ? 'bg-slate-100 text-slate-600 border-slate-200' : '' }}
                                    ">
                                        {{ ucfirst($notice->audience) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        @if ($notice->expires_at)
                                            <span class="text-sm font-semibold text-slate-700">
                                                {{ $notice->expires_at->format('M d, Y') }}
                                            </span>
                                            <span class="text-xs text-slate-500">
                                                {{ $notice->expires_at->isPast() ? 'Expired' : 'Expires ' . $notice->expires_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1.5 text-sm text-slate-400 font-medium">
                                                <i data-lucide="infinity" class="w-4 h-4"></i>
                                                <span>Forever</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.notice-bars.edit', $notice) }}"
                                            class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all border border-transparent hover:border-indigo-100/50"
                                            title="Edit">
                                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                                        </a>
                                        <form action="{{ route('admin.notice-bars.destroy', $notice) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all border border-transparent hover:border-red-100/50"
                                                title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm transform transition-transform hover:scale-110 duration-300">
                                        <i data-lucide="megaphone-off" class="w-8 h-8 text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 mb-1">No announcements yet</h3>
                                    <p class="text-slate-500 max-w-sm mx-auto mb-6">Create your first notice to broadcast
                                        important updates to your users.</p>
                                    <a href="{{ route('admin.notice-bars.create') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-semibold rounded-xl transition-colors">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                        Create Notice
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($notices->hasPages())
                <div class="px-8 py-6 border-t border-slate-100">
                    {{ $notices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
