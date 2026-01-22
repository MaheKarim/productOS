@extends('admin.layout')

@section('title', 'Services')

@section('page-title', 'Service Management')

@section('content')
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Active Services</h3>
                <p class="text-sm text-slate-500">Manage the expertise sections shown on your public portfolio.</p>
            </div>
            <a href="{{ route('admin.services.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create New Service
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden">
            @if ($services->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Order
                                </th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Service
                                    Details</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Description</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($services as $service)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-6">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs">
                                            {{ $service->order }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                                <i class="{{ $service->full_icon }} text-indigo-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900">{{ $service->title }}</div>
                                                <div class="text-[10px] text-slate-400 font-medium italic">
                                                    {{ $service->icon }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-sm text-slate-500 leading-relaxed max-w-xs truncate">
                                        {{ $service->description }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if ($service->is_active)
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
                                            <form action="{{ route('admin.services.toggle', $service) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-soft"
                                                    title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i data-lucide="{{ $service->is_active ? 'eye-off' : 'eye' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.services.edit', $service) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-soft"
                                                title="Edit Content">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                                onsubmit="return confirm('Archive this service record?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-soft"
                                                    title="Remove Service">
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
                @if ($services->hasPages())
                    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $services->firstItem() }}-{{ $services->lastItem() }} of {{ $services->total() }}
                            results
                        </div>
                        <div class="pagination-custom">
                            {{ $services->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i data-lucide="layers" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">No Service Offerings</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 leading-relaxed italic">"Define how you help clients
                        transform their products and start landing more impact."</p>
                    <a href="{{ route('admin.services.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                        <i data-lucide="plus" class="w-5 h-5 mr-3"></i>
                        Get Started Now
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
