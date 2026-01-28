<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\AiProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:102400', // 100MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        try {
            $file = $request->file('pdf_file');
            $path = $file->store('books', 'public');

            $coverPath = null;
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('books/covers', 'public');
            }

            // Initial parsing (Basic)
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $metadata = $pdf->getDetails();
            $totalPages = count($pdf->getPages());

            $book = Book::create([
                'title' => $request->title,
                'author' => $request->author ?? ($metadata['Author'] ?? null),
                'tags' => $request->tags,
                'file_path' => $path,
                'cover_image' => $coverPath,
                'total_pages' => $totalPages,
                'status' => 'pending',
                'is_active' => true,
            ]);

            return redirect()->route('admin.books.show', $book)
                ->with('success', 'Book uploaded successfully. You can now process it.');

        } catch (\Exception $e) {
            Log::error('Book Upload Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload book: ' . $e->getMessage());
        }
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        try {
            $data = [
                'title' => $request->title,
                'author' => $request->author,
                'tags' => $request->tags,
            ];

            // Handle cover image update
            if ($request->hasFile('cover_image')) {
                // Delete old cover image if exists
                if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                    Storage::disk('public')->delete($book->cover_image);
                }
                $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
            }

            $book->update($data);

            return redirect()->route('admin.books.show', $book)
                ->with('success', 'Book updated successfully.');

        } catch (\Exception $e) {
            Log::error('Book Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }

    public function show(Book $book)
    {
        $book->load(['chapters', 'summaries.provider']);
        $providers = AiProvider::where('is_active', true)->get();
        return view('admin.books.show', compact('book', 'providers'));
    }

    public function destroy(Book $book)
    {
        if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
            Storage::disk('public')->delete($book->file_path);
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }

    public function process(Request $request, Book $book)
    {
        $request->validate([
            'provider_id' => 'required|exists:ai_providers,id',
            'process_type' => 'required|in:full,chapter,both',
            'translate' => 'nullable|boolean',
        ]);

        // Set status to extracting/processing
        $book->update(['status' => 'extracting']);

        // Dispatch Job (Will implement next)
        dispatch(new \App\Jobs\ProcessBookJob(
            $book,
            $request->provider_id,
            $request->process_type,
            $request->boolean('translate')
        ));

        return back()->with('success', 'Book processing started in background.');
    }

    public function toggleStatus(Book $book)
    {
        $book->update(['is_active' => !$book->is_active]);
        return back()->with('success', 'Book status updated successfully.');
    }
}
