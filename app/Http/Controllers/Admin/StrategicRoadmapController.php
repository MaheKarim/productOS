<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapSession;
use Illuminate\Http\Request;

class StrategicRoadmapController extends Controller
{
    /**
     * Display a listing of the roadmap sessions.
     */
    public function index()
    {
        $sessions = RoadmapSession::with(['user', 'latestOutput', 'progress'])
            ->latest()
            ->paginate(15);

        return view('admin.strategic-roadmap.index', compact('sessions'));
    }

    /**
     * Display the specified roadmap session.
     */
    public function show($id)
    {
        $session = RoadmapSession::with(['user', 'latestOutput', 'progress'])
            ->findOrFail($id);

        return view('admin.strategic-roadmap.show', compact('session'));
    }

    /**
     * Remove the specified roadmap session from storage.
     */
    public function destroy($id)
    {
        $session = RoadmapSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.strategic-roadmap.index')
            ->with('success', 'Roadmap session deleted successfully.');
    }
}
