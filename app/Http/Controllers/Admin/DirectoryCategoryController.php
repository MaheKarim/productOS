<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DirectoryCategory;
// use Illuminate\Http\Request; // Already imported
use Illuminate\Support\Str;

class DirectoryCategoryController extends Controller
{
    public function index()
    {
        $categories = DirectoryCategory::orderBy('type')->orderBy('display_order')->get();
        return view('admin.directory.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.directory.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:tools,learning,companies,communities,templates',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'color_class' => 'nullable|string',
            'display_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        DirectoryCategory::create($validated);

        return redirect()->route('admin.directory.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(DirectoryCategory $category)
    {
        return view('admin.directory.categories.create', compact('category'));
    }

    public function update(Request $request, DirectoryCategory $category)
    {
        $validated = $request->validate([
            'type' => 'required|in:tools,learning,companies,communities,templates',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'color_class' => 'nullable|string',
            'display_order' => 'integer',
        ]);

        // Update slug only if name changed
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.directory.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(DirectoryCategory $category)
    {
        // Check if has items or handle generically
        $category->delete();
        return redirect()->route('admin.directory.categories.index')->with('success', 'Category deleted successfully.');
    }
}
