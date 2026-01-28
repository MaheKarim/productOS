@extends('admin.layout')

@section('title', 'Upload Book')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.books.index') }}"
                class="flex items-center gap-2 text-slate-500 hover:text-slate-900 transition-colors mb-4">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to Library
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Upload New Book</h1>
            <p class="text-slate-500 mt-1">Upload a PDF to extract text and generate AI summaries.</p>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl p-8">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Book Title</label>
                    <input type="text" name="title" id="title" required
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. Atomic Habits">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-bold text-slate-700 mb-2">Author (Optional)</label>
                    <input type="text" name="author" id="author"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. James Clear">
                    @error('author')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tags" class="block text-sm font-bold text-slate-700 mb-2">Tags (Optional)</label>
                    <input type="text" name="tags" id="tags"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                        placeholder="e.g. productivity, psychology, business (comma separated)">
                    @error('tags')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-bold text-slate-700 mb-2">Book Cover
                        (Optional)</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('cover_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pdf_file" class="block text-sm font-bold text-slate-700 mb-2">PDF File</label>
                    <div class="relative group">
                        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required
                            class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-3 file:px-4
                                file:rounded-xl file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                cursor-pointer border border-slate-200 rounded-xl bg-slate-50
                            " />
                    </div>
                    <p class="text-xs text-slate-400 mt-2">Max file size: 50MB. Text-based PDFs work best.</p>
                    @error('pdf_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                        <i data-lucide="upload" class="w-5 h-5"></i>
                        Upload & Analyze
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
