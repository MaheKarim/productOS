<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class YTSummarizeController extends Controller
{
    /**
     * Display the YT Summarize index with hero search.
     */
    public function index(Request $request)
    {
        $query = Video::where('processing_status', 'completed')
            ->with('aiOutput');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('channel_name', 'like', "%{$search}%");
            });
        }

        // Filter by access level
        $filter = $request->get('filter', 'all');
        if ($filter === 'free') {
            $query->where('access_level', 'free');
        } elseif ($filter === 'premium') {
            $query->where('access_level', 'premium');
        }

        $videos = $query->latest()->paginate(12);

        // Stats
        $stats = [
            'total' => Video::where('processing_status', 'completed')->count(),
            'free' => Video::where('processing_status', 'completed')->where('access_level', 'free')->count(),
            'premium' => Video::where('processing_status', 'completed')->where('access_level', 'premium')->count(),
        ];

        return view('user.yt-summarize.index', compact('videos', 'stats', 'filter'));
    }

    /**
     * Display a single video summary.
     */
    public function show(Video $video)
    {
        $video->load('aiOutput');

        // Get suggested content
        $suggestedVideos = Video::where('processing_status', 'completed')
            ->where('id', '!=', $video->id)
            ->with('aiOutput')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('user.yt-summarize.show', compact('video', 'suggestedVideos'));
    }
}
