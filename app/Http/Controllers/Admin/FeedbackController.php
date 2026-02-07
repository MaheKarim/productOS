<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\FeedbackStatusHistory;
use App\Mail\FeedbackStatusUpdateEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\AiProvider;
use App\Services\AiProviderService;
use Illuminate\Support\Str;
class FeedbackController extends Controller
{
    /**
     * Display the admin feedback management dashboard.
     */
    public function index(Request $request)
    {
        $query = Feedback::with(['user', 'latestStatusUpdate', 'attachments'])
            ->orderBy('created_at', 'desc');

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->ofType($request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->ofStatus($request->status);
        }

        // Filter by severity (for bugs)
        if ($request->has('severity') && $request->severity !== 'all') {
            $query->where('severity', $request->severity);
        }

        // Search by feedback ID or title
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('feedback_id', 'like', "%{$searchTerm}%")
                    ->orWhere('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $feedbackList = $query->paginate(20);

        // Get stats
        $stats = [
            'total' => Feedback::count(),
            'submitted' => Feedback::where('status', Feedback::STATUS_SUBMITTED)->count(),
            'under_review' => Feedback::where('status', Feedback::STATUS_UNDER_REVIEW)->count(),
            'planned' => Feedback::where('status', Feedback::STATUS_PLANNED)->count(),
            'in_progress' => Feedback::where('status', Feedback::STATUS_IN_PROGRESS)->count(),
            'resolved' => Feedback::where('status', Feedback::STATUS_RESOLVED)->count(),
            'closed' => Feedback::where('status', Feedback::STATUS_CLOSED)->count(),
            'bugs' => Feedback::where('type', Feedback::TYPE_BUG)->count(),
            'features' => Feedback::where('type', Feedback::TYPE_FEATURE)->count(),
            'satisfaction' => Feedback::where('type', Feedback::TYPE_SATISFACTION)->count(),
        ];

        return view('admin.feedback.index', compact('feedbackList', 'stats'));
    }

    /**
     * Display the feedback detail view for admins.
     */
    public function show($feedbackId)
    {
        $feedback = Feedback::where('feedback_id', $feedbackId)
            ->with([
                'user',
                'statusHistory' => function ($query) {
                    $query->with('adminUser')->latest();
                },
                'attachments',
            ])
            ->firstOrFail();

        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Update the feedback status.
     */
    public function updateStatus(Request $request, $feedbackId)
    {
        $validator = Validator::make($request->all(), [
            'status' => [
                'required',
                Rule::in([
                    Feedback::STATUS_SUBMITTED,
                    Feedback::STATUS_UNDER_REVIEW,
                    Feedback::STATUS_PLANNED,
                    Feedback::STATUS_IN_PROGRESS,
                    Feedback::STATUS_RESOLVED,
                    Feedback::STATUS_CLOSED,
                ])
            ],
            'admin_comment' => 'nullable|string|max:1000',
            'is_visible_to_user' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $feedback = Feedback::where('feedback_id', $feedbackId)->firstOrFail();
        $data = $validator->validated();

        $isVisibleToUser = $data['is_visible_to_user'] ?? true;
        $adminComment = $data['admin_comment'] ?? null;

        // Update status and record history
        $feedback->updateStatus(
            $data['status'],
            Auth::id(),
            $adminComment,
            $isVisibleToUser
        );

        // Send email notification to user
        if (
            $isVisibleToUser && in_array($data['status'], [
                Feedback::STATUS_UNDER_REVIEW,
                Feedback::STATUS_PLANNED,
                Feedback::STATUS_IN_PROGRESS,
                Feedback::STATUS_RESOLVED,
                Feedback::STATUS_CLOSED,
            ])
        ) {
            try {
                Mail::to($feedback->user->email)->send(new FeedbackStatusUpdateEmail($feedback));
            } catch (\Exception $e) {
                // Log error but don't fail the update
                \Log::error('Failed to send feedback status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Feedback status updated successfully.');
    }

    /**
     * Add an internal note to feedback.
     */
    public function addInternalNote(Request $request, $feedbackId)
    {
        $validator = Validator::make($request->all(), [
            'note' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $feedback = Feedback::where('feedback_id', $feedbackId)->firstOrFail();
        $data = $validator->validated();

        // Create status history entry for internal note
        FeedbackStatusHistory::create([
            'feedback_id' => $feedback->id,
            'old_status' => $feedback->status,
            'new_status' => $feedback->status,
            'admin_user_id' => Auth::id(),
            'admin_comment' => $data['note'],
            'is_visible_to_user' => false,
        ]);

        return back()->with('success', 'Internal note added successfully.');
    }

    /**
     * Get feedback analytics.
     */
    public function analytics()
    {
        $stats = [
            'total' => Feedback::count(),
            'this_month' => Feedback::where('created_at', '>=', now()->startOfMonth())->count(),
            'this_week' => Feedback::where('created_at', '>=', now()->startOfWeek())->count(),
            'today' => Feedback::where('created_at', '>=', now()->startOfDay())->count(),
        ];

        // Type breakdown
        $typeBreakdown = [
            'bugs' => Feedback::where('type', Feedback::TYPE_BUG)->count(),
            'features' => Feedback::where('type', Feedback::TYPE_FEATURE)->count(),
            'satisfaction' => Feedback::where('type', Feedback::TYPE_SATISFACTION)->count(),
        ];

        // Status breakdown
        $statusBreakdown = [
            'submitted' => Feedback::where('status', Feedback::STATUS_SUBMITTED)->count(),
            'under_review' => Feedback::where('status', Feedback::STATUS_UNDER_REVIEW)->count(),
            'planned' => Feedback::where('status', Feedback::STATUS_PLANNED)->count(),
            'in_progress' => Feedback::where('status', Feedback::STATUS_IN_PROGRESS)->count(),
            'resolved' => Feedback::where('status', Feedback::STATUS_RESOLVED)->count(),
            'closed' => Feedback::where('status', Feedback::STATUS_CLOSED)->count(),
        ];

        // Severity breakdown (for bugs)
        $severityBreakdown = [
            'critical' => Feedback::where('type', Feedback::TYPE_BUG)->where('severity', Feedback::SEVERITY_CRITICAL)->count(),
            'high' => Feedback::where('type', Feedback::TYPE_BUG)->where('severity', Feedback::SEVERITY_HIGH)->count(),
            'medium' => Feedback::where('type', Feedback::TYPE_BUG)->where('severity', Feedback::SEVERITY_MEDIUM)->count(),
            'low' => Feedback::where('type', Feedback::TYPE_BUG)->where('severity', Feedback::SEVERITY_LOW)->count(),
        ];

        // Average resolution time (for resolved feedback)
        $avgResolutionTime = Feedback::where('status', Feedback::STATUS_RESOLVED)
            ->get()
            ->map(function ($feedback) {
                $firstHistory = $feedback->statusHistory->first();
                $lastHistory = $feedback->statusHistory->where('new_status', Feedback::STATUS_RESOLVED)->first();
                if ($firstHistory && $lastHistory) {
                    return $firstHistory->created_at->diffInHours($lastHistory->created_at);
                }
                return null;
            })
            ->filter()
            ->avg();

        // Recent activity
        $recentFeedback = Feedback::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Active AI Providers
        $aiProviders = AiProvider::where('is_active', true)->get();

        return view('admin.feedback.analytics', compact(
            'stats',
            'typeBreakdown',
            'statusBreakdown',
            'severityBreakdown',
            'avgResolutionTime',
            'recentFeedback',
            'aiProviders'
        ));
    }

    /**
     * Analyze feedback using AI.
     */
    public function analyze(Request $request, AiProviderService $aiService)
    {
        $request->validate([
            'ai_provider_id' => 'required|exists:ai_providers,id',
            'model' => 'nullable|string',
        ]);

        $provider = AiProvider::findOrFail($request->ai_provider_id);
        $model = $request->model ?? $provider->default_model;

        // Fetch recent unaddressed feedback for analysis
        $recentFeedback = Feedback::whereNotIn('status', [Feedback::STATUS_RESOLVED, Feedback::STATUS_CLOSED])
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();

        if ($recentFeedback->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No open feedback available for analysis.',
            ]);
        }

        // Prepare data for prompt
        $feedbackData = $recentFeedback->map(function ($f) {
            return "- [{$f->type}] {$f->title}: " . Str::limit($f->description, 100);
        })->implode("\n");

        $prompt = "You are a product management assistant. Analyze the following recent user feedback items:\n\n" .
            $feedbackData .
            "\n\nPlease provide a concise summary with the following sections:\n" .
            "1. **Top Issues**: The most critical problems reported.\n" .
            "2. **Requested Features**: Common feature requests.\n" .
            "3. **Sentiment**: General user sentiment.\n" .
            "4. **Action Items**: Recommended next steps for the team.";

        try {
            $response = $aiService->makeCompletionRequest(
                $provider,
                $model,
                [['role' => 'user', 'content' => $prompt]],
                ['max_tokens' => 1000]
            );

            if ($response['success']) {
                $content = $response['data']['choices'][0]['message']['content'] ?? 'No analysis generated.';
                return response()->json([
                    'success' => true,
                    'analysis' => $content,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'AI Provider error: ' . ($response['error'] ?? 'Unknown error'),
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export feedback to CSV.
     */
    public function export(Request $request)
    {
        $query = Feedback::with('user');

        // Apply filters
        if ($request->has('type') && $request->type !== 'all') {
            $query->ofType($request->type);
        }
        if ($request->has('status') && $request->status !== 'all') {
            $query->ofStatus($request->status);
        }

        $feedback = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback_export_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($feedback) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Feedback ID',
                'Type',
                'Title',
                'Description',
                'Status',
                'User Name',
                'User Email',
                'Created At',
                'Updated At',
            ]);

            foreach ($feedback as $item) {
                fputcsv($file, [
                    $item->feedback_id,
                    $item->type_label,
                    $item->title,
                    $item->description,
                    $item->status_label,
                    $item->user->name,
                    $item->user->email,
                    $item->created_at->format('Y-m-d H:i:s'),
                    $item->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update feedback status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feedback_ids' => 'required|array',
            'feedback_ids.*' => 'exists:feedback,feedback_id',
            'status' => [
                'required',
                Rule::in([
                    Feedback::STATUS_SUBMITTED,
                    Feedback::STATUS_UNDER_REVIEW,
                    Feedback::STATUS_PLANNED,
                    Feedback::STATUS_IN_PROGRESS,
                    Feedback::STATUS_RESOLVED,
                    Feedback::STATUS_CLOSED,
                ])
            ],
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $count = 0;

        foreach ($data['feedback_ids'] as $feedbackId) {
            $feedback = Feedback::where('feedback_id', $feedbackId)->first();
            if ($feedback) {
                $feedback->updateStatus(
                    $data['status'],
                    Auth::id(),
                    $data['admin_comment'] ?? null,
                    true
                );
                $count++;
            }
        }

        return back()->with('success', "Updated status for {$count} feedback items.");
    }
}
