<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class YTSummarizeController extends Controller
{
    /**
     * Display a listing of free video summaries.
     */
    public function index(Request $request)
    {
        $query = Video::where('processing_status', 'completed')
            ->where('access_level', 'free')
            ->with('aiOutput');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('channel_name', 'like', "%{$search}%");
            });
        }

        $videos = $query->latest()->paginate(12);

        return view('frontend.yt-summarize.index', compact('videos'));
    }

    /**
     * Display a single video summary.
     */
    public function show(Video $video)
    {
        // Redirect to login for premium content if guest
        if ($video->access_level === 'premium' && !auth()->check()) {
            return redirect()->route('yt-summarize.index')
                ->with('premium_required', 'Please sign in to access premium summaries.');
        }

        $video->load('aiOutput');

        return view('frontend.yt-summarize.show', compact('video'));
    }
}
