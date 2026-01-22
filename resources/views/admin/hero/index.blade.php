@extends('admin.layout')

@section('title', 'Hero Management')

@section('page-title', 'Hero Sections')

@section('content')
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Main Visual Units</h3>
                <p class="text-sm text-slate-500">Configure the primary headlines and value propositions for your site.</p>
            </div>
            <a href="{{ route('admin.hero.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Add Hero Section
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden">
            @if ($heroes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Order</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Main
                                    Headline</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Visual
                                    Badge</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($heroes as $hero)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-6 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs">
                                            {{ $hero->order }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <div
                                                class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors truncate max-w-xs">
                                                {{ $hero->title }}</div>
                                            <div
                                                class="text-[10px] text-slate-400 font-medium truncate max-w-xs mt-1 leading-relaxed">
                                                {{ $hero->subtitle }}</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if ($hero->badge_text)
                                            <span
                                                class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-lg uppercase tracking-widest border border-indigo-100">
                                                {{ $hero->badge_text }}
                                            </span>
                                        @else
                                            <span class="text-[10px] text-slate-300 italic">No Badge</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if ($hero->is_active)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                                    Live
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-slate-50 text-slate-400 border border-slate-100 uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-2"></span>
                                                    Draft
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div
                                            class="flex items-center justify-end space-x-1">
                                            <form action="{{ route('admin.hero.toggle', $hero) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-soft"
                                                    title="{{ $hero->is_active ? 'Take Offline' : 'Publish Live' }}">
                                                    <i data-lucide="{{ $hero->is_active ? 'power' : 'zap' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.hero.edit', $hero) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-soft"
                                                title="Modify Hero">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.hero.destroy', $hero) }}" method="POST"
                                                onsubmit="return confirm('Archive this hero configuration?');"
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

                {{-- Pagination Links --}}
                @if ($heroes->hasPages())
                    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $heroes->firstItem() }}-{{ $heroes->lastItem() }} of {{ $heroes->total() }}
                            configurations
                        </div>
                        <div class="pagination-custom">
                            {{ $heroes->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i data-lucide="star" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">No Visual Heroes Found</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 leading-relaxed italic">"The hero section is your first
                        impression. Create a compelling visual message today."</p>
                    <a href="{{ route('admin.hero.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                        <i data-lucide="plus" class="w-5 h-5 mr-3"></i>
                        Design New Hero
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
