<?php

namespace App\Http\Controllers;

use App\Models\RoadmapProgress;
use App\Models\RoadmapTopic;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function index()
    {
        return view('roadmap.index');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:roadmap_topics,id',
            'status' => 'required|integer|in:0,1,2,3',
        ]);

        $statusLabels = [0 => 'Not Started', 1 => 'In Progress', 2 => 'Completed', 3 => 'Mastered'];

        RoadmapProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'topic_id' => $request->topic_id,
            ],
            [
                'status' => $request->status,
                'completed_at' => $request->status >= 2 ? now() : null,
            ]
        );

        $topic = RoadmapTopic::find($request->topic_id);

        return response()->json([
            'success' => true,
            'status' => $request->status,
            'message' => "'{$topic->name}' marked as {$statusLabels[$request->status]}!",
        ]);
    }
}
