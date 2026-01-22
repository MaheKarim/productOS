<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\CaseStudy;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $tools = Tool::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('is_active', true)
            ->get();

        $caseStudies = CaseStudy::where('title', 'like', "%{$query}%")
            ->orWhere('industry', 'like', "%{$query}%")
            ->get();

        return view('search.results', compact('tools', 'caseStudies', 'query'));
    }
}
