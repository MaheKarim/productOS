<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseStudy;

class CaseStudyController extends Controller
{
    public function index()
    {
        $caseStudies = CaseStudy::where('is_featured', true)->get();
        // If we want all, remove is_featured check or separate query
        $allCaseStudies = CaseStudy::all();

        return view('portfolio.index', compact('caseStudies', 'allCaseStudies'));
    }

    public function show($slug)
    {
        $caseStudy = CaseStudy::where('slug', $slug)->firstOrFail();
        return view('portfolio.show', compact('caseStudy'));
    }
}
