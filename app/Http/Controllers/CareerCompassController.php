<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareerCompassController extends Controller
{
    /**
     * Landing page for Career Compass
     */
    public function index()
    {
        return view('tools.career-compass.index');
    }

    /**
     * Start or continue assessment
     */
    public function assess()
    {
        return view('tools.career-compass.assess');
    }

    /**
     * View results (optional ID for specific assessment)
     */
    public function results(?int $id = null)
    {
        $assessment = null;

        if ($id) {
            $assessment = \App\Models\CareerAssessment::find($id);
        } elseif (auth()->check()) {
            $assessment = auth()->user()->careerAssessments()->latest('assessment_date')->first();
        } else {
            $assessmentData = session('career_compass_results');
            if ($assessmentData) {
                $assessment = is_array($assessmentData) ? new \App\Models\CareerAssessment($assessmentData) : $assessmentData;
            }
        }

        if (!$assessment) {
            return redirect()->route('career-compass.assess')->with('error', 'No assessment results found.');
        }

        // Generate recommendations
        $recommendationEngine = new \App\Services\RecommendationEngine();
        $recommendations = $recommendationEngine->generate($assessment);
        $strengths = $recommendationEngine->getStrengths($assessment);

        return view('tools.career-compass.results', [
            'assessment' => $assessment,
            'recommendations' => $recommendations,
            'strengths' => $strengths
        ]);
    }

    /**
     * View history (requires authentication)
     */
    public function history()
    {
        $user = auth()->user();

        // Get latest assessment for the summary card (always wants the most recent)
        $latestAssessment = $user->careerAssessments()
            ->orderBy('assessment_date', 'desc')
            ->first();

        // Get all assessments for the chart (to show full trend)
        $chartAssessments = $user->careerAssessments()
            ->orderBy('assessment_date', 'desc')
            ->get();

        // Get paginated assessments for the history table
        $assessments = $user->careerAssessments()
            ->orderBy('assessment_date', 'desc')
            ->paginate(10);

        return view('tools.career-compass.history', [
            'assessments' => $assessments,
            'latestAssessment' => $latestAssessment,
            'chartAssessments' => $chartAssessments
        ]);
    }

    /**
     * Download results as PDF
     */
    public function downloadPdf(\App\Services\RecommendationEngine $recommendationEngine, ?int $id = null)
    {
        $assessmentData = null;

        if ($id) {
            $assessmentData = \App\Models\CareerAssessment::find($id);
            // Ensure user owns this assessment if logged in
            if (auth()->check() && $assessmentData && $assessmentData->user_id !== auth()->id()) {
                abort(403);
            }
        } elseif (auth()->check()) {
            // Check if there is a recent assessment in session that matches the user
            // Or get the latest assessment from DB if session is empty but user has history
            if (session()->has('career_compass_results')) {
                $assessmentData = session('career_compass_results');
            } else {
                $assessmentData = auth()->user()->careerAssessments()->latest('assessment_date')->first();
            }
        } else {
            // Guest user - get from session
            $assessmentData = session('career_compass_results');
        }

        if (!$assessmentData) {
            return redirect()->route('career-compass.assess')->with('error', 'No assessment results found.');
        }

        // Calculate recommendations if not already present or if we need to regenerate
        // The session data might be an array or object depending on how it was saved.
        // If it comes from DB, it's a model. If from session, it might be an array or attributes.

        // Let's normalize to a CareerAssessment model instance for the view
        $assessment = $assessmentData;
        if (is_array($assessmentData)) {
            $assessment = new \App\Models\CareerAssessment($assessmentData);
            // Manually set calculated attributes if they aren't filled
            $assessment->environment_scores = $assessmentData['environment_scores'] ?? [];
            $assessment->skills_scores = $assessmentData['skills_scores'] ?? [];
            $assessment->impact_score = $assessmentData['impact_score'] ?? 0;
        }

        $recommendations = $recommendationEngine->generate($assessment);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('tools.career-compass.pdf-report', [
            'assessment' => $assessment,
            'recommendations' => $recommendations,
            'date' => now()->format('F j, Y')
        ]);

        return $pdf->download('PM_Career_Compass_Results.pdf');
    }
}
