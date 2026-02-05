<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    public function index()
    {
        $categories = JobCategory::withCount('jobs')->latest()->paginate(20);
        return view('admin.job-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.job-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:job_categories,slug|max:255',
            'icon' => 'nullable|string|max:255', // SVG path or class
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        JobCategory::create($validated);

        return redirect()->route('admin.job-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(JobCategory $jobCategory)
    {
        return view('admin.job-categories.edit', compact('jobCategory'));
    }

    public function update(Request $request, JobCategory $jobCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:job_categories,slug,' . $jobCategory->id,
            'icon' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $jobCategory->update($validated);

        return redirect()->route('admin.job-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(JobCategory $jobCategory)
    {
        if ($jobCategory->jobs()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated jobs.');
        }

        $jobCategory->delete();
        return redirect()->route('admin.job-categories.index')->with('success', 'Category deleted successfully.');
    }
}
