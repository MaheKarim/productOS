@extends('admin.layout')

@section('title', 'About Sections')

@section('page-title', 'About Sections')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-teal-900">About Sections</h3>
            <a href="{{ route('admin.about.create') }}"
                class="px-4 py-2 gradient-primary text-white rounded-lg hover:shadow-md transition-all text-sm font-medium">
                <i class="fa-solid fa-plus mr-2"></i>
                Add New About
            </a>
        </div>

        @if ($abouts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Order</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Heading</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($abouts as $about)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $about->order }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-teal-900 truncate max-w-xs">{{ $about->heading }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 truncate max-w-md">{{ $about->description }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($about->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fa-solid fa-circle-check mr-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            <i class="fa-solid fa-circle-xmark mr-1"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('admin.about.toggle', $about) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-slate-600 hover:text-primary transition-colors"
                                                title="{{ $about->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i
                                                    class="fa-solid {{ $about->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('admin.about.edit', $about) }}"
                                            class="p-2 text-slate-600 hover:text-primary transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.about.destroy', $about) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this about section?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-slate-600 hover:text-red-500 transition-colors"
                                                title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-slate-600">
                    Showing {{ $abouts->firstItem() }} to {{ $abouts->lastItem() }} of {{ $abouts->total() }} entries
                </div>
                {{ $abouts->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-teal-50 flex items-center justify-center">
                        <i class="fa-solid fa-user text-2xl text-teal-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">No About Sections Found</h3>
                    <p class="text-slate-600 mb-4">Get started by creating your first about section.</p>
                    <a href="{{ route('admin.about.create') }}"
                        class="px-6 py-3 gradient-primary text-white rounded-lg hover:shadow-md transition-all inline-flex items-center">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Create About Section
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
