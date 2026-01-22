@extends('admin.layout')

@section('title', 'Impact Projects')

@section('page-title', 'Portfolio Projects')

@section('content')
    <div class="space-y-6">
        {{-- Header Card --}}
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 tracking-tight">Success Stories</h3>
                <p class="text-sm text-slate-500">Curate and manage your high-impact case studies and project metrics.</p>
            </div>
            <a href="{{ route('admin.projects.create') }}"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Create New Project
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200/60 overflow-hidden">
            @if ($projects->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Order</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Project
                                    Details</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    Category</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-8 py-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($projects as $project)
                                <tr class="hover:bg-slate-50/30 transition-colors group">
                                    <td class="px-8 py-6 text-center">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold text-xs">
                                            {{ $project->order }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                                @if ($project->image)
                                                    <img src="{{ $project->image_url }}" alt=""
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i data-lucide="image" class="w-5 h-5 text-slate-300"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div
                                                    class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                                    {{ $project->title }}</div>
                                                @if ($project->metric_value)
                                                    <div
                                                        class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider mt-0.5">
                                                        {{ $project->metric_value }} {{ $project->metric_label }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span
                                            class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-lg uppercase tracking-widest border border-slate-200">
                                            {{ $project->category ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex justify-center">
                                            @if ($project->is_active)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-widest">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>
                                                    Published
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
                                            class="flex items-center justify-end space-x-1 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity">
                                            <form action="{{ route('admin.projects.toggle', $project) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-soft"
                                                    title="{{ $project->is_active ? 'Unpublish' : 'Publish' }}">
                                                    <i data-lucide="{{ $project->is_active ? 'archive' : 'send' }}"
                                                        class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.projects.edit', $project) }}"
                                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-soft"
                                                title="Edit Content">
                                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                                                onsubmit="return confirm('Permanently remove this case study?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-soft"
                                                    title="Delete Project">
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
                @if ($projects->hasPages())
                    <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $projects->firstItem() }}-{{ $projects->lastItem() }} of {{ $projects->total() }}
                            entries
                        </div>
                        <div class="pagination-custom">
                            {{ $projects->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="py-24 text-center">
                    <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i data-lucide="briefcase" class="w-10 h-10 text-indigo-400"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-2">No Projects Logged</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-10 leading-relaxed italic">"It's time to show off your
                        impact. Add your first success story to build credibility."</p>
                    <a href="{{ route('admin.projects.create') }}"
                        class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-soft font-bold text-sm">
                        <i data-lucide="plus" class="w-5 h-5 mr-3"></i>
                        Add Project
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
