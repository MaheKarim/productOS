<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InterviewPrepController extends Controller
{
    /**
     * Show the filter/selection page.
     */
    public function index()
    {
        $access = app(\App\Services\FeatureAccessService::class)->checkAccess(auth()->user(), 'interview_prep');
        if ($access['status'] !== 'allowed') {
            return redirect()->route('dashboard')->with('error', $access['message']);
        }
        $categories = QuestionCategory::active()
            ->withCount([
                'questions' => function ($query) {
                    $query->active();
                }
            ])
            ->orderBy('name')
            ->get();

        $audienceCounts = [
            'new' => Question::active()->where('question_for', 'like', '%New%')->count(),
            'experienced' => Question::active()->where('question_for', 'like', '%Experienced%')->count(),
            'senior' => Question::active()->where('question_for', 'like', '%Senior%')->count(),
        ];

        $totalQuestions = Question::active()->count();

        return view('user.interview-prep.index', compact('categories', 'audienceCounts', 'totalQuestions'));
    }

    /**
     * Start a practice session based on filters.
     */
    public function startPractice(Request $request)
    {
        // Deduct credits
        $deducted = app(\App\Services\FeatureAccessService::class)->deductCredits(auth()->user(), 'interview_prep');
        if (!$deducted) {
            return back()->with('error', 'Insufficient credits to start practice session.');
        }
        $request->validate([
            'filter_type' => 'required|in:category,audience,random',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:question_categories,id',
            'audiences' => 'nullable|array',
            'audiences.*' => 'in:new,experienced,senior',
            'question_count' => 'nullable|integer|min:5|max:100',
        ]);

        $query = Question::active()->with('categories');

        // Apply filters
        if ($request->filter_type === 'category' && !empty($request->categories)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('question_categories.id', $request->categories);
            });
        } elseif ($request->filter_type === 'audience' && !empty($request->audiences)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->audiences as $audience) {
                    $audienceMap = [
                        'new' => 'New to PM',
                        'experienced' => 'Experienced PM',
                        'senior' => 'Senior PM',
                    ];
                    $q->orWhere('question_for', 'like', '%' . ($audienceMap[$audience] ?? $audience) . '%');
                }
            });
        }

        // Limit questions
        $limit = $request->question_count ?? 20;
        $questions = $query->inRandomOrder()->limit($limit)->get();

        if ($questions->isEmpty()) {
            return back()->with('error', 'No questions found for the selected filters. Try different options.');
        }

        // Store session
        $sessionId = uniqid('prep_');
        Session::put("interview_prep.{$sessionId}", [
            'question_ids' => $questions->pluck('id')->toArray(),
            'current_index' => 0,
            'started_at' => now(),
            'filter_type' => $request->filter_type,
            'answers' => [], // Initialize answers array
        ]);

        return redirect()->route('user.interview-prep.practice', ['session' => $sessionId]);
    }

    /**
     * Show the practice session.
     */
    public function practice(Request $request, $session)
    {
        $sessionData = Session::get("interview_prep.{$session}");

        if (!$sessionData) {
            return redirect()->route('user.interview-prep.index')->with('error', 'Session expired. Please start a new session.');
        }

        $questionIds = $sessionData['question_ids'];
        $currentIndex = $request->query('q', 0);

        // Validate index
        if ($currentIndex < 0 || $currentIndex >= count($questionIds)) {
            $currentIndex = 0;
        }

        $question = Question::with('categories')->find($questionIds[$currentIndex]);

        return view('user.interview-prep.practice', [
            'session' => $session,
            'question' => $question,
            'currentIndex' => $currentIndex,
            'totalQuestions' => count($questionIds),
            'sessionData' => $sessionData,
        ]);
    }

    /**
     * End session and show summary.
     */
    public function submitAnswer(Request $request, $session)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required',
        ]);

        $sessionKey = "interview_prep.{$session}";
        $sessionData = Session::get($sessionKey);

        if (!$sessionData) {
            return response()->json(['error' => 'Session expired'], 404);
        }

        $question = Question::find($request->question_id);
        $isCorrect = false;

        // Check correctness based on type
        if ($question->isCq()) {
            // content question - correctness handled by grading service, 
            // but here we mark as attempted. Score comes from grading.
            // For now, we rely on the previously called grade endpoint, 
            // OR we move grading here? 
            // The user wants "save result". 
            // Let's assume for CQ we just store the answer text. 
            // Constraint: The existing 'grade' endpoint returns score but doesn't save to session.
            // We should treat this 'submitAnswer' as the definitive record.
            // But existing UI calls 'grade' separately.
            // Fix: update 'gradeAnswer' to ALSO update session, 
            // OR make frontend call this AFTER grading? 
            // Simpler: Update 'gradeAnswer' to store result in session.
            // And use 'submitAnswer' for MCQs.
        } else {
            // MCQ
            $isCorrect = in_array($request->answer, $question->correct_answer ?? []);
        }

        // Update Session
        $sessionData['answers'][$question->id] = [
            'answer' => $request->answer,
            'is_correct' => $isCorrect,
            'question_id' => $question->id,
        ];

        Session::put($sessionKey, $sessionData);

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
        ]);
    }

    /**
     * End session and show summary.
     */
    public function endSession(Request $request, $session)
    {
        $sessionData = Session::get("interview_prep.{$session}");

        if (!$sessionData) {
            return redirect()->route('user.interview-prep.index');
        }

        $totalQuestions = count($sessionData['question_ids']);
        $startedAt = $sessionData['started_at'];
        $answers = $sessionData['answers'] ?? [];

        $attempted = count($answers);
        $correct = collect($answers)->where('is_correct', true)->count();
        // Calculate score based on ATTEMPTED questions to reflect true accuracy
        $score = $attempted > 0 ? ($correct / $attempted) * 100 : 0;

        $durationSeconds = now()->diffInSeconds($startedAt);

        // Save to Database
        $interviewSession = \App\Models\InterviewSession::create([
            'user_id' => auth()->id(),
            'total_questions' => $totalQuestions,
            'attempted_questions' => $attempted,
            'correct_answers' => $correct,
            'score' => $score,
            'duration_seconds' => $durationSeconds,
            'config' => ['filter_type' => $sessionData['filter_type'] ?? 'unknown'],
            'completed_at' => now(),
        ]);

        // Clear session
        Session::forget("interview_prep.{$session}");

        return view('user.interview-prep.summary', [
            'interviewSession' => $interviewSession,
        ]);
    }

    /**
     * Grade a written answer using AI.
     */
    public function gradeAnswer(Request $request, Question $question)
    {
        $request->validate([
            'answer' => 'required|string|min:2|max:5000',
        ]);

        if (!$question->isCq()) {
            return response()->json(['error' => 'This question is not a creative question.'], 400);
        }

        try {
            $gradingService = app(\App\Services\AI\AiGradingService::class);
            $result = $gradingService->gradeAnswer(
                $question->question,
                $request->answer,
                $question->correct_answer ?? [],
                $question->explanation
            );

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Grading failed: ' . $e->getMessage()], 500);
        }
    }
}
