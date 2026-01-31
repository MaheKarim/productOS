<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions.
     */
    public function index(Request $request)
    {
        $query = Question::with('categories');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('question_categories.id', $request->category);
            });
        }

        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->filled('search')) {
            $query->where('question', 'like', '%' . $request->search . '%');
        }

        $questions = $query->latest()->paginate(20);
        $categories = QuestionCategory::active()->orderBy('name')->get();

        return view('admin.questions.index', compact('questions', 'categories'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $categories = QuestionCategory::active()->orderBy('name')->get();

        return view('admin.questions.create', compact('categories'));
    }

    /**
     * Store a newly created question.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|min:10',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:500',
            'correct_answer' => 'nullable|array',
            'correct_answer.*' => 'nullable|string|max:500',
            'explanation' => 'nullable|string|max:2000',
            'difficulty' => 'required|in:easy,medium,hard',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:question_categories,id',
            'is_active' => 'boolean',
        ]);

        $question = Question::create([
            'question' => $validated['question'],
            'answers' => array_filter($validated['answers'] ?? []),
            'correct_answer' => $validated['correct_answer'] ?? null,
            'explanation' => $validated['explanation'] ?? null,
            'difficulty' => $validated['difficulty'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $question->categories()->sync($validated['categories']);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question created successfully!');
    }

    /**
     * Display the specified question.
     */
    public function show(Question $question)
    {
        $question->load('categories');

        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $question->load('categories');
        $categories = QuestionCategory::active()->orderBy('name')->get();

        return view('admin.questions.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified question.
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string|min:10',
            'answers' => 'nullable|array',
            'answers.*' => 'nullable|string|max:500',
            'correct_answer' => 'nullable|array',
            'correct_answer.*' => 'nullable|string|max:500',
            'explanation' => 'nullable|string|max:2000',
            'difficulty' => 'required|in:easy,medium,hard',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:question_categories,id',
            'is_active' => 'boolean',
        ]);

        $question->update([
            'question' => $validated['question'],
            'answers' => array_filter($validated['answers'] ?? []),
            'correct_answer' => $validated['correct_answer'] ?? null,
            'explanation' => $validated['explanation'] ?? null,
            'difficulty' => $validated['difficulty'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        $question->categories()->sync($validated['categories']);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified question.
     */
    public function destroy(Question $question)
    {
        $question->categories()->detach();
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Question deleted successfully!');
    }

    /**
     * Toggle question active status.
     */
    public function toggleActive(Question $question)
    {
        $question->update(['is_active' => !$question->is_active]);

        return back()->with('success', 'Question status updated!');
    }
}
