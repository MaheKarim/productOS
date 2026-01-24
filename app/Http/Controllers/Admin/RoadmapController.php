<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapCategory;
use App\Models\RoadmapTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoadmapController extends Controller
{
    public function index()
    {
        $categories = RoadmapCategory::withCount('topics')->orderBy('order')->get();
        $topics = RoadmapTopic::with('category')->latest()->paginate(20);
        return view('admin.roadmap.index', compact('categories', 'topics'));
    }

    public function create()
    {
        $categories = RoadmapCategory::orderBy('order')->get();
        return view('admin.roadmap.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:roadmap_categories,id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|integer|min:1|max:5',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['resources'] = [];

        RoadmapTopic::create($validated);

        return redirect()->route('admin.roadmap.index')->with('success', 'Topic created successfully.');
    }

    public function edit(RoadmapTopic $topic)
    {
        $categories = RoadmapCategory::orderBy('order')->get();
        return view('admin.roadmap.edit', compact('topic', 'categories'));
    }

    public function update(Request $request, RoadmapTopic $topic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:roadmap_categories,id',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|integer|min:1|max:5',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $topic->update($validated);

        return redirect()->route('admin.roadmap.index')->with('success', 'Topic updated successfully.');
    }

    public function destroy(RoadmapTopic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.roadmap.index')->with('success', 'Topic deleted successfully.');
    }
}
