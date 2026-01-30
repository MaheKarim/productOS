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

        // Fetch options for configuration
        $providers = \App\Models\AiProvider::all();
        $prompts = \App\Models\SystemPrompt::where('type', 'strategic_roadmap')->get();

        // Fetch current settings
        $settings = \App\Models\Setting::where('group', 'strategic_roadmap')->get()->pluck('value', 'key');

        return view('admin.strategic-roadmap.index', compact('sessions', 'providers', 'prompts', 'settings'));
    }

    /**
     * Update configuration settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'nullable|exists:ai_providers,id',
            'prompt_id_junior' => 'nullable|exists:system_prompts,id',
            'prompt_id_mid' => 'nullable|exists:system_prompts,id',
            'prompt_id_senior' => 'nullable|exists:system_prompts,id',
        ]);

        foreach ($validated as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['group' => 'strategic_roadmap', 'key' => $key],
                ['value' => $value, 'type' => 'string']
            );
        }

        return redirect()->route('admin.strategic-roadmap.index')
            ->with('success', 'Configuration updated successfully.');
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
