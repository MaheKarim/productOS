@extends('admin.layout')

@section('title', 'Testimonial Management')

@section('page-title', 'Client Voices')

@section('content')
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Proof of Value</h3>
                <p class="text-sm text-slate-500">Manage client endorsements and project-linked testimonials.</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add Testimonial
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden">
            @if ($testimonials->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Client
                                </th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Linked
                                    Project</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Rating</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($testimonials as $testimonial)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-slate-100 mr-4 overflow-hidden flex-shrink-0">
                                                @if ($testimonial->avatar_image)
                                                    <img src="{{ asset('storage/' . $testimonial->avatar_image) }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center text-slate-400">
                                                        <i data-lucide="user" class="w-5 h-5"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <div class="text-sm font-bold text-slate-900">{{ $testimonial->name }}</div>
                                                <div
                                                    class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">
                                                    {{ $testimonial->designation }}
                                                    {{ $testimonial->company ? '@ ' . $testimonial->company : '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if ($testimonial->project)
                                            <span
                                                class="text-sm font-medium text-slate-600">{{ $testimonial->project->title }}</span>
                                        @else
                                            <span class="text-xs text-slate-300 italic">General Feedback</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex items-center justify-center space-x-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i data-lucide="star"
                                                    class="w-3 h-3 {{ $i <= $testimonial->rating ? 'fill-amber-400 text-amber-400' : 'text-slate-200' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if ($testimonial->is_active)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                                    Live
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-100 uppercase tracking-widest">
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div
                                            class="flex items-center justify-end space-x-1">
                                            <form action="{{ route('admin.testimonials.toggle', $testimonial) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-soft"
                                                    title="{{ $testimonial->is_active ? 'Take Offline' : 'Publish Live' }}">
                                                    <i data-lucide="{{ $testimonial->is_active ? 'eye-off' : 'eye' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-soft"
                                                title="Modify Voice">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                                method="POST"
                                                onsubmit="return confirm('Remove this testimonial from public view?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-soft"
                                                    title="Permanently Remove">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($testimonials->hasPages())
                    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $testimonials->firstItem() }}-{{ $testimonials->lastItem() }} of
                            {{ $testimonials->total() }} voices
                        </div>
                        <div class="pagination-custom">
                            {{ $testimonials->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i data-lucide="message-square" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">No Voices Recorded</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 leading-relaxed italic">"Social proof is the heartbeat
                        of a portfolio. Add your first client testimonial."</p>
                    <a href="{{ route('admin.testimonials.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                        <i data-lucide="plus" class="w-5 h-5 mr-3"></i>
                        Record First Voice
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
