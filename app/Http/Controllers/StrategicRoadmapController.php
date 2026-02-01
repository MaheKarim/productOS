<?php

namespace App\Http\Controllers;

use App\Models\RoadmapSession;
use App\Models\RoadmapOutput;
use App\Models\UserRoadmapProgress;
use App\Models\AdminRoadmapInsight;
use App\Services\StrategicRoadmapService;
use Illuminate\Http\Request;

class StrategicRoadmapController extends Controller
{
    protected StrategicRoadmapService $roadmapService;

    public function __construct(StrategicRoadmapService $roadmapService)
    {
        $this->roadmapService = $roadmapService;
    }

    /**
     * Public landing page with beautiful design (no auth required).
     * Users are redirected to login when they try to use the tool.
     */
    public function publicLanding()
    {
        AdminRoadmapInsight::recordUsage('page_view', 1, null, 'public_landing');

        return view('tools.strategic-roadmap.public-landing');
    }

    /**
     * Dashboard landing page with user level selection (auth required).
     */
    public function index()
    {
        // Record page view
        AdminRoadmapInsight::recordUsage('page_view', 1, null, 'landing');

        $access = app(\App\Services\FeatureAccessService::class)->checkAccess(auth()->user(), 'strategic_roadmap');
        if ($access['status'] !== 'allowed') {
            return redirect()->route('dashboard')->with('error', $access['message']);
        }

        return view('tools.strategic-roadmap.index');
    }

    /**
     * Junior PM quick start form.
     */
    public function quickStart(Request $request)
    {
        $sessionUuid = $request->query('session');
        $session = null;

        if ($sessionUuid) {
            $session = $this->roadmapService->getSessionByUuid($sessionUuid);
        }

        if (!$session) {
            $session = $this->roadmapService->startSession(auth()->user(), 'junior');
        }

        AdminRoadmapInsight::recordUsage('session_start', 1, 'junior');

        return view('tools.strategic-roadmap.quick-start', [
            'session' => $session,
        ]);
    }

    /**
     * Senior PM advanced input form.
     */
    public function advancedInput(Request $request)
    {
        $sessionUuid = $request->query('session');
        $session = null;
        $level = $request->query('level', 'senior');

        if ($sessionUuid) {
            $session = $this->roadmapService->getSessionByUuid($sessionUuid);
        }

        if (!$session) {
            $session = $this->roadmapService->startSession(auth()->user(), $level);
        }

        AdminRoadmapInsight::recordUsage('session_start', 1, $level);

        return view('tools.strategic-roadmap.advanced', [
            'session' => $session,
            'level' => $level,
        ]);
    }

    /**
     * Store quick input and generate roadmap.
     */
    public function storeQuickInput(Request $request)
    {
        $validated = $request->validate([
            'session_uuid' => 'required|uuid|exists:roadmap_sessions,session_uuid',
            'product_type' => 'required|string|in:saas,marketplace,ecommerce,mobile_app,other',
            'time_working' => 'required|string|in:less_3m,3_6m,6_12m,1_2y,2plus_y',
            'challenges' => 'required|array|min:1',
            'challenges.*' => 'string',
        ]);

        $session = $this->roadmapService->getSessionByUuid($validated['session_uuid']);

        if (!$session) {
            return back()->withErrors(['session' => 'Session not found.']);
        }

        $this->roadmapService->saveQuickInput($session, $validated);

        // Deduct credits
        $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits(auth()->user(), 'strategic_roadmap');
        if (!$deducted) {
            return back()->withErrors(['credits' => 'Insufficient credits to generate roadmap.']);
        }

        // Generate roadmap
        try {
            $output = $this->roadmapService->generateRoadmap($session);

            return redirect()->route('user.strategic-roadmap.results', ['id' => $output->id])
                ->with('success', 'Your roadmap has been generated!');
        } catch (\Exception $e) {
            return back()->withErrors(['generation' => 'Failed to generate roadmap: ' . $e->getMessage()]);
        }
    }

    /**
     * Store advanced input and generate roadmap.
     */
    public function storeAdvancedInput(Request $request)
    {
        $validated = $request->validate([
            'session_uuid' => 'required|uuid|exists:roadmap_sessions,session_uuid',
            'product_type' => 'required|string|in:saas,marketplace,ecommerce,mobile_app,fintech,other',
            'product_stage' => 'nullable|string|in:ideation,mvp,growth,scale,mature',
            'team_size' => 'nullable|string|in:solo,small,medium,large',
            'level' => 'nullable|string|in:mid,senior',
            'funding_stage' => 'nullable|string|in:bootstrapped,seed,series_a,series_b_plus,profitable',
            'mrr_range' => 'nullable|string|in:0,1-10k,10-50k,50-200k,200k-1m,1m+',
            'challenges' => 'nullable|array',
            'challenges.*' => 'string',
            'priorities' => 'nullable|array',
            'priorities.*' => 'string',
            'current_metrics' => 'nullable|array',
        ]);

        $session = $this->roadmapService->getSessionByUuid($validated['session_uuid']);

        if (!$session) {
            return back()->withErrors(['session' => 'Session not found.']);
        }

        $this->roadmapService->saveAdvancedInput($session, $validated);

        // Deduct credits
        $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits(auth()->user(), 'strategic_roadmap');
        if (!$deducted) {
            return back()->withErrors(['credits' => 'Insufficient credits to generate roadmap.']);
        }

        // Generate roadmap
        try {
            $output = $this->roadmapService->generateRoadmap($session);

            return redirect()->route('user.strategic-roadmap.results', ['id' => $output->id])
                ->with('success', 'Your strategic roadmap has been generated!');
        } catch (\Exception $e) {
            return back()->withErrors(['generation' => 'Failed to generate roadmap: ' . $e->getMessage()]);
        }
    }

    /**
     * Display generated roadmap results.
     */
    public function results(Request $request, ?int $id = null)
    {
        $output = null;
        $progress = null;

        if ($id) {
            $output = RoadmapOutput::with('session')->find($id);
        } else {
            // Try to get from session
            $sessionData = session('roadmap_result_id');
            if ($sessionData) {
                $output = RoadmapOutput::with('session')->find($sessionData);
            }
        }

        if (!$output) {
            return redirect()->route('user.strategic-roadmap.index')
                ->with('error', 'No roadmap found. Please create one first.');
        }

        // Get user's progress if authenticated
        if (auth()->check()) {
            $progress = UserRoadmapProgress::getOrCreate(auth()->id(), $output->id);
        }

        $level = $output->session->user_level ?? 'junior';
        $roadmapData = $output->getVersionForLevel($level);

        return view('tools.strategic-roadmap.results', [
            'output' => $output,
            'session' => $output->session,
            'roadmapData' => $roadmapData,
            'metricFramework' => $output->metric_framework,
            'benchmarks' => $output->benchmarks,
            'progress' => $progress,
            'level' => $level,
        ]);
    }

    /**
     * View roadmap history (requires auth).
     */
    public function history()
    {
        $user = auth()->user();
        $sessions = $this->roadmapService->getUserHistory($user, 20);

        return view('tools.strategic-roadmap.history', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * Update progress on roadmap items (AJAX).
     */
    public function updateProgress(Request $request)
    {
        $validated = $request->validate([
            'output_id' => 'required|exists:roadmap_outputs,id',
            'checkpoint_id' => 'required|string',
            'completed' => 'required|boolean',
        ]);

        $progress = UserRoadmapProgress::getOrCreate(auth()->id(), $validated['output_id']);

        if ($validated['completed']) {
            $progress->markCheckpointComplete($validated['checkpoint_id']);
        } else {
            $progress->markCheckpointIncomplete($validated['checkpoint_id']);
        }

        return response()->json([
            'success' => true,
            'completion_percentage' => $progress->completion_percentage,
            'completed_count' => $progress->completed_count,
        ]);
    }

    /**
     * Update metric value (AJAX).
     */
    public function updateMetric(Request $request)
    {
        $validated = $request->validate([
            'output_id' => 'required|exists:roadmap_outputs,id',
            'metric_id' => 'required|string',
            'value' => 'required',
        ]);

        $progress = UserRoadmapProgress::getOrCreate(auth()->id(), $validated['output_id']);
        $progress->updateMetric($validated['metric_id'], $validated['value']);

        return response()->json([
            'success' => true,
            'message' => 'Metric updated successfully.',
        ]);
    }
}
