@extends('admin.layout')

@section('title', 'Roadmap Topics')
@section('page-title', 'Roadmap Topics')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-lg font-bold text-slate-900">Manage Topics</h3>
            <p class="text-sm text-slate-500">Add, edit, or remove topics from the PM Roadmap.</p>
        </div>
        <a href="{{ route('admin.roadmap.create') }}"
            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Topic
        </a>
    </div>

    {{-- Categories Overview --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
        @foreach ($categories as $cat)
            <div class="bg-white rounded-xl p-4 border border-slate-100 shadow-sm text-center">
                <span class="text-2xl font-bold text-slate-800">{{ $cat->topics_count }}</span>
                <p class="text-xs text-slate-500 mt-1 truncate">{{ $cat->name }}</p>
            </div>
        @endforeach
    </div>

    {{-- Topics Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">Topic</th>
                    <th class="px-6 py-4 text-left">Category</th>
                    <th class="px-6 py-4 text-center">Difficulty</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($topics as $topic)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $topic->name }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $topic->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-indigo-100 text-indigo-700">
                                {{ $topic->difficulty_level }}/5
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.roadmap.edit', $topic) }}"
                                    class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.roadmap.destroy', $topic) }}" method="POST"
                                    onsubmit="return confirm('Delete this topic?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">No topics found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $topics->links() }}
    </div>
@endsection
