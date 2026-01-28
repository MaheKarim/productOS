@extends('admin.layout')

@section('title', 'Edit Book')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.books.show', $book) }}"
                class="flex items-center gap-2 text-slate-500 hover:text-slate-900 transition-colors mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Book
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Book</h1>
            <p class="text-slate-500 mt-1">Update book details including title, author, and cover image.</p>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl p-8">
            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Book Title</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $book->title) }}"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. Atomic Habits">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-bold text-slate-700 mb-2">Author</label>
                    <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. James Clear">
                    @error('author')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tags" class="block text-sm font-bold text-slate-700 mb-2">Tags</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $book->tags) }}"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. productivity, psychology, business">
                    @error('tags')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-bold text-slate-700 mb-2">URL Slug</label>
                    <input type="text" id="slug" value="{{ $book->slug ?? 'Will be auto-generated from title' }}"
                        class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 transition-all outline-none font-medium text-slate-600"
                        readonly>
                    <p class="text-xs text-slate-400 mt-2">Slug is automatically generated from the book title.</p>
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-bold text-slate-700 mb-2">Book Cover</label>
                    @if ($book->cover_image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="h-32 w-24 object-cover rounded-lg shadow-md">
                        </div>
                    @endif
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-slate-400 mt-2">Leave empty to keep current cover image.</p>
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
