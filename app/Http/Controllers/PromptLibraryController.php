<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use App\Models\PromptCategory;
use Illuminate\Http\Request;

class PromptLibraryController extends Controller
{
    /**
     * Display the prompt library homepage.
     */
    public function index()
    {
        return view('prompts.index');
    }

    /**
     * Display a single prompt.
     */
    public function show($slug)
    {
        $prompt = Prompt::with('category')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $prompt->incrementViewCount();

        // Get related prompts
        $relatedPrompts = Prompt::with('category')
            ->published()
            ->where('id', '!=', $prompt->id)
            ->where('category_id', $prompt->category_id)
            ->orderBy('copy_count', 'desc')
            ->take(3)
            ->get();

        return view('prompts.show', compact('prompt', 'relatedPrompts'));
    }

    /**
     * Track prompt copy (AJAX endpoint).
     */
    public function trackCopy(Request $request, $id)
    {
        $prompt = Prompt::findOrFail($id);
        $prompt->incrementCopyCount();

        return response()->json([
            'success' => true,
            'copy_count' => $prompt->copy_count,
        ]);
    }
}
