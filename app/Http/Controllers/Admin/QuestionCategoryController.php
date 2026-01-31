<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = QuestionCategory::withCount('questions')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.question-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.question-categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:question_categories,slug',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        QuestionCategory::create($validated);

        return redirect()->route('admin.question-categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(QuestionCategory $question_category)
    {
        return view('admin.question-categories.edit', [
            'category' => $question_category,
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, QuestionCategory $question_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:question_categories,slug,' . $question_category->id,
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $question_category->update($validated);

        return redirect()->route('admin.question-categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(QuestionCategory $question_category)
    {
        $question_category->delete();

        return redirect()->route('admin.question-categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
