<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\PromptCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromptController extends Controller
{
    /**
     * Display a listing of prompts.
     */
    public function index(Request $request)
    {
        $query = Prompt::with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('prompt_text', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by AI tool
        if ($request->filled('ai_tool')) {
            $query->where('ai_tool', $request->ai_tool);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $prompts = $query->paginate(20)->withQueryString();
        $categories = PromptCategory::active()->ordered()->get();

        return view('admin.prompts.index', compact('prompts', 'categories'));
    }

    /**
     * Show the form for creating a new prompt.
     */
    public function create()
    {
        $categories = PromptCategory::active()->ordered()->get();
        return view('admin.prompts.create', compact('categories'));
    }

    /**
     * Store a newly created prompt.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'category_id' => 'required|exists:prompt_categories,id',
            'ai_tool' => 'required|in:chatgpt,claude,gemini,universal',
            'use_case_tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'description' => 'nullable|string|max:500',
            'example_output' => 'nullable|string',
            'author' => 'nullable|string|max:100',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'output_length' => 'required|in:short,medium,long',
            'tips' => 'nullable|string',
            'is_featured' => 'boolean',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
        ]);

        // Process tags
        $validated['use_case_tags'] = $this->processTags($request->use_case_tags);
        $validated['tips'] = $this->processTips($request->tips);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['created_by'] = auth()->id();
        $validated['uuid'] = Str::uuid();
        $validated['slug'] = Str::slug($validated['title']);

        Prompt::create($validated);

        return redirect()->route('admin.prompts.index')
            ->with('success', 'Prompt created successfully!');
    }

    /**
     * Show the form for editing the specified prompt.
     */
    public function edit(Prompt $prompt)
    {
        $categories = PromptCategory::active()->ordered()->get();
        return view('admin.prompts.edit', compact('prompt', 'categories'));
    }

    /**
     * Update the specified prompt.
     */
    public function update(Request $request, Prompt $prompt)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'category_id' => 'required|exists:prompt_categories,id',
            'ai_tool' => 'required|in:chatgpt,claude,gemini,universal',
            'use_case_tags' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'description' => 'nullable|string|max:500',
            'example_output' => 'nullable|string',
            'author' => 'nullable|string|max:100',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'output_length' => 'required|in:short,medium,long',
            'tips' => 'nullable|string',
            'is_featured' => 'boolean',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
        ]);

        $validated['use_case_tags'] = $this->processTags($request->use_case_tags);
        $validated['tips'] = $this->processTips($request->tips);
        $validated['is_featured'] = $request->boolean('is_featured');

        // Update slug only if title changed
        if ($prompt->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $prompt->update($validated);

        return redirect()->route('admin.prompts.index')
            ->with('success', 'Prompt updated successfully!');
    }

    /**
     * Remove the specified prompt.
     */
    public function destroy(Prompt $prompt)
    {
        $prompt->delete();

        return redirect()->route('admin.prompts.index')
            ->with('success', 'Prompt deleted successfully!');
    }

    /**
     * Toggle prompt status.
     */
    public function toggleStatus(Prompt $prompt)
    {
        $newStatus = $prompt->status === 'published' ? 'draft' : 'published';
        $prompt->update(['status' => $newStatus]);

        return back()->with('success', "Prompt status changed to {$newStatus}.");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Prompt $prompt)
    {
        $prompt->update(['is_featured' => !$prompt->is_featured]);

        $status = $prompt->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Prompt has been {$status}.");
    }

    /**
     * Duplicate a prompt.
     */
    public function duplicate(Prompt $prompt)
    {
        $newPrompt = $prompt->replicate();
        $newPrompt->title = $prompt->title . ' (Copy)';
        $newPrompt->slug = Str::slug($newPrompt->title);
        $newPrompt->uuid = Str::uuid();
        $newPrompt->status = 'draft';
        $newPrompt->copy_count = 0;
        $newPrompt->view_count = 0;
        $newPrompt->is_featured = false;
        $newPrompt->created_by = auth()->id();
        $newPrompt->save();

        return redirect()->route('admin.prompts.edit', $newPrompt)
            ->with('success', 'Prompt duplicated successfully!');
    }

    /**
     * Process comma-separated tags into array.
     */
    private function processTags(?string $tags): array
    {
        if (empty($tags)) {
            return [];
        }

        return array_map('trim', explode(',', $tags));
    }

    /**
     * Process newline-separated tips into array.
     */
    private function processTips(?string $tips): array
    {
        if (empty($tips)) {
            return [];
        }

        return array_filter(array_map('trim', explode("\n", $tips)));
    }
}
