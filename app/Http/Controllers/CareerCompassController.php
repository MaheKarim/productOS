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
        return view('tools.career-compass.results', ['assessmentId' => $id]);
    }

    /**
     * View history (requires authentication)
     */
    public function history()
    {
        $assessments = auth()->user()
            ->careerAssessments()
            ->orderBy('assessment_date', 'desc')
            ->get();

        return view('tools.career-compass.history', ['assessments' => $assessments]);
    }
}
