@extends('admin.layout')

@section('title', 'Book Management')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Book Library</h1>
            <p class="text-slate-500 mt-1">Manage and process your PDF books with AI</p>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.books.index') }}" method="GET" class="relative group">
                <i data-lucide="search"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..."
                    class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 shadow-sm">
            </form>
            <a href="{{ route('admin.books.create') }}"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                Upload Book
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Title</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Author</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Pages</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($books as $book)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    @if ($book->cover_image)
                                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}"
                                            class="w-12 h-16 object-cover rounded-lg shadow-sm border border-slate-200">
                                    @else
                                        <div
                                            class="w-12 h-16 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                            <i data-lucide="book" class="w-6 h-6 text-slate-300"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $book->title }}</div>
                                        <div class="text-xs text-slate-400 mt-1">Uploaded
                                            {{ $book->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 text-slate-600 font-medium">{{ $book->author ?? 'Unknown' }}</td>
                            <td class="p-5 text-slate-600">{{ $book->total_pages }}</td>
                            <td class="p-5">
                                <div class="flex flex-col gap-2">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-slate-100 text-slate-600',
                                            'extracting' => 'bg-blue-100 text-blue-700',
                                            'processing' => 'bg-amber-100 text-amber-700',
                                            'completed' => 'bg-emerald-100 text-emerald-700',
                                            'failed' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusClass = $statusClasses[$book->status] ?? 'bg-slate-100 text-slate-600';
                                    @endphp
                                    <span
                                        class="w-fit px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusClass }}">
                                        {{ $book->status }}
                                    </span>

                                    <form action="{{ route('admin.books.toggle', $book) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-1.5 text-xs font-bold {{ $book->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $book->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                            </div>
                                            {{ $book->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="p-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.books.show', $book) }}"
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                        title="View & Process">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <i data-lucide="edit" class="w-5 h-5"></i>
                                    </a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                        onsubmit="return confirm('Delete this book?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="book" class="w-8 h-8 text-slate-300"></i>
                                </div>
                                <h3 class="text-slate-900 font-bold mb-1">No books found</h3>
                                <p class="text-slate-500 mb-6">Upload a PDF book to get started.</p>
                                <a href="{{ route('admin.books.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                                    Upload Book
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5 border-t border-slate-100">
            {{ $books->links() }}
        </div>
    </div>
@endsection
