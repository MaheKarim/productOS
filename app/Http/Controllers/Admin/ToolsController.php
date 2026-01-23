<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\ToolCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    /**
     * Display a listing of all tools
     */
    public function index()
    {
        $tools = Tool::with('category')->orderBy('sort_order')->orderBy('name')->get();
        $categories = ToolCategory::withCount('tools')->get();

        return view('admin.tools.index', compact('tools', 'categories'));
    }

    /**
     * Show the form for creating a new tool
     */
    public function create()
    {
        $categories = ToolCategory::all();
        return view('admin.tools.create', compact('categories'));
    }

    /**
     * Store a newly created tool
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:tool_categories,id',
            'description' => 'nullable|string',
            'difficulty' => 'required|in:Easy,Medium,Advanced',
            'time_estimate' => 'required|string|max:50',
            'content' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['faqs'] = $request->input('faqs', []);

        Tool::create($validated);

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool created successfully!');
    }

    /**
     * Show the form for editing a tool
     */
    public function edit(Tool $tool)
    {
        $categories = ToolCategory::all();
        return view('admin.tools.edit', compact('tool', 'categories'));
    }

    /**
     * Update the specified tool
     */
    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:tool_categories,id',
            'description' => 'nullable|string',
            'difficulty' => 'required|in:Easy,Medium,Advanced',
            'time_estimate' => 'required|string|max:50',
            'content' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string',
            'faqs.*.answer' => 'required_with:faqs|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['faqs'] = $request->input('faqs', []);

        $tool->update($validated);

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool updated successfully!');
    }

    /**
     * Toggle tool active status
     */
    public function toggleStatus(Tool $tool)
    {
        $tool->update(['is_active' => !$tool->is_active]);

        return redirect()->back()
            ->with('success', $tool->is_active ? 'Tool activated!' : 'Tool deactivated!');
    }

    /**
     * Remove the specified tool
     */
    public function destroy(Tool $tool)
    {
        $tool->delete();

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool deleted successfully!');
    }
}
