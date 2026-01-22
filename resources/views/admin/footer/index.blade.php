@extends('admin.layout')

@section('title', 'Footer Settings')

@section('page-title', 'Footer Management')

@section('content')
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Footer Settings</h3>
                <p class="text-sm text-slate-500">Manage footer content, links, and social media.</p>
            </div>
            <a href="{{ route('admin.footer.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create Footer
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden">
            @if ($footers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Order
                                </th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Footer
                                    Details</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Links
                                </th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($footers as $footer)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-6">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs">
                                            {{ $footer->order }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            @if ($footer->logo_image)
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                    <img src="{{ $footer->logo_image_url }}" alt="Logo"
                                                        class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                                    <i data-lucide="layout" class="text-indigo-600 text-lg"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">
                                                    {{ $footer->logo_text ?: 'No Logo Text' }}</div>
                                                <div class="text-[10px] text-slate-400 font-medium">
                                                    {{ $footer->email ?: 'No Email' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-sm text-slate-500 leading-relaxed">
                                        <div class="space-y-1">
                                            <div class="text-[10px] text-slate-400 font-medium">Column 1:
                                                {{ count($footer->column1_links ?? []) }} links</div>
                                            <div class="text-[10px] text-slate-400 font-medium">Column 2:
                                                {{ count($footer->column2_links ?? []) }} links</div>
                                            <div class="text-[10px] text-slate-400 font-medium">Column 3:
                                                {{ count($footer->column3_links ?? []) }} links</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if ($footer->is_active)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-100 uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2"></span>
                                                    Hidden
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div
                                            class="flex items-center justify-end space-x-1">
                                            <form action="{{ route('admin.footer.toggle', $footer) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-soft"
                                                    title="{{ $footer->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i data-lucide="{{ $footer->is_active ? 'eye-off' : 'eye' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.footer.edit', $footer) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-soft"
                                                title="Edit Content">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.footer.destroy', $footer) }}" method="POST"
                                                onsubmit="return confirm('Delete this footer configuration?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-soft"
                                                    title="Delete Footer">
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
                @if ($footers->hasPages())
                    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $footers->firstItem() }}-{{ $footers->lastItem() }} of {{ $footers->total() }}
                            results
                        </div>
                        <div class="pagination-custom">
                            {{ $footers->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i data-lucide="layout" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">No Footer Configurations</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 leading-relaxed italic">"Create your first footer to
                        customize the bottom section of your portfolio."</p>
                    <a href="{{ route('admin.footer.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                        <i data-lucide="plus" class="w-5 h-5 mr-3"></i>
                        Get Started Now
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
