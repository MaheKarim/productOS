<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('is_active', true)->where('status', 'completed');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter by Genre (if implemented later) or Sorting
        // Default sort by latest
        $books = $query->latest()->paginate(12);

        return view('books.index', compact('books'));
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        if (!$book->is_active || $book->status !== 'completed') {
            abort(404);
        }

        $book->load(['chapters.summary', 'fullSummary', 'summaries']);

        // Recommendations: Books by same author or random active books
        $recommendations = Book::where('is_active', true)
            ->where('status', 'completed')
            ->where('id', '!=', $book->id)
            ->where(function ($q) use ($book) {
                $q->where('author', $book->author);
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // If not enough recommendations by author, fill with randoms
        if ($recommendations->count() < 4) {
            $moreRecs = Book::where('is_active', true)
                ->where('status', 'completed')
                ->where('id', '!=', $book->id)
                ->whereNotIn('id', $recommendations->pluck('id'))
                ->inRandomOrder()
                ->limit(4 - $recommendations->count())
                ->get();
            $recommendations = $recommendations->merge($moreRecs);
        }

        return view('books.show', compact('book', 'recommendations'));
    }
}
