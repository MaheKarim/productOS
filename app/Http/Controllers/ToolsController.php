<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\ToolCategory;
use App\Models\CaseStudy;

class ToolsController extends Controller
{
    /**
     * Display the tools page with all PM calculators
     */
    public function index()
    {
        $categories = \App\Models\ToolCategory::with([
            'tools' => function ($query) {
                $query->where('is_active', true);
            }
        ])->whereHas('tools', function ($query) {
            $query->where('is_active', true);
        })->get();

        return view('tools.index', compact('categories'));
    }

    public function category($category)
    {
        $category = \App\Models\ToolCategory::where('slug', $category)->with([
            'tools' => function ($query) {
                $query->where('is_active', true);
            }
        ])->firstOrFail();

        return view('tools.category', compact('category'));
    }

    public function show($category, $tool)
    {
        $tool = \App\Models\Tool::where('slug', $tool)
            ->where('is_active', true)
            ->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            })->firstOrFail();

        // Load similar tools from same category
        $similarTools = \App\Models\Tool::where('category_id', $tool->category_id)
            ->where('id', '!=', $tool->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        // Find a case study that uses this tool (by name)
        $relatedCaseStudy = \App\Models\CaseStudy::whereJsonContains('tools_used', $tool->name)->first();
        // Fallback for demo
        if (!$relatedCaseStudy) {
            $relatedCaseStudy = \App\Models\CaseStudy::first();
        }

        return view('tools.show', compact('tool', 'similarTools', 'relatedCaseStudy'));
    }
}
