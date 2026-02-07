<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackAttachment;
use App\Mail\FeedbackConfirmationEmail;
use App\Mail\FeedbackStatusUpdateEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    /**
     * Display the feedback submission form.
     */
    public function create()
    {
        return view('feedback.submit');
    }

    /**
     * Store a new feedback submission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::in(['bug', 'feature', 'satisfaction'])],
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:10',
            // Bug report specific fields
            'severity' => 'nullable|in:critical,high,medium,low',
            'steps_to_reproduce' => 'nullable|string',
            'expected_behavior' => 'nullable|string',
            'actual_behavior' => 'nullable|string',
            // Feature request specific fields
            'priority' => 'nullable|in:must_have,nice_to_have',
            'use_case' => 'nullable|string',
            // Satisfaction feedback specific fields
            'satisfaction_rating' => 'nullable|integer|min:1|max:10',
            'satisfaction_category' => 'nullable|in:design,performance,content,navigation,other',
            'whats_working' => 'nullable|string',
            'needs_improvement' => 'nullable|string',
            // Common fields
            'page_url' => 'nullable|url|max:500',
            'attachments' => 'nullable|array|max:3',
            'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,mp4,webm,mov',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $user = Auth::user();

        // Check for duplicate submissions (same user, same content within 5 minutes)
        $recentDuplicate = Feedback::where('user_id', $user->id)
            ->where('type', $data['type'])
            ->where('title', $data['title'])
            ->where('description', $data['description'])
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($recentDuplicate) {
            return back()
                ->with('error', 'You have already submitted this feedback recently. Please wait a few minutes before submitting again.')
                ->withInput();
        }

        // Capture browser and device info
        $browserInfo = $request->userAgent();
        $deviceInfo = $this->getDeviceInfo($request);

        // Create feedback
        $feedback = Feedback::create([
            'user_id' => $user->id,
            'feedback_id' => Feedback::generateFeedbackId(),
            'type' => $data['type'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => Feedback::STATUS_SUBMITTED,
            'severity' => $data['severity'] ?? null,
            'priority' => $data['priority'] ?? null,
            'satisfaction_rating' => $data['satisfaction_rating'] ?? null,
            'satisfaction_category' => $data['satisfaction_category'] ?? null,
            'whats_working' => $data['whats_working'] ?? null,
            'needs_improvement' => $data['needs_improvement'] ?? null,
            'steps_to_reproduce' => $data['steps_to_reproduce'] ?? null,
            'expected_behavior' => $data['expected_behavior'] ?? null,
            'actual_behavior' => $data['actual_behavior'] ?? null,
            'use_case' => $data['use_case'] ?? null,
            'page_url' => $data['page_url'] ?? url()->previous(),
            'browser_info' => $browserInfo,
            'device_info' => $deviceInfo,
            'ip_address' => $request->ip(),
        ]);

        // Handle attachments
        if (isset($data['attachments']) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('feedback/attachments', 'public');
                    $url = Storage::url($path);

                    FeedbackAttachment::create([
                        'feedback_id' => $feedback->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_url' => $url,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }
        }

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new FeedbackConfirmationEmail($feedback));
        } catch (\Exception $e) {
            // Log error but don't fail the submission
            \Log::error('Failed to send feedback confirmation email: ' . $e->getMessage());
        }

        return redirect()
            ->route('feedback.thank-you', ['feedback' => $feedback->feedback_id])
            ->with('success', 'Thank you for your feedback! We have received your submission.');
    }

    /**
     * Display the thank you page after submission.
     */
    public function thankYou($feedbackId)
    {
        $feedback = Feedback::where('feedback_id', $feedbackId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('feedback.thank-you', compact('feedback'));
    }

    /**
     * Display the user's feedback dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $query = $user->activeFeedback()->with([
            'statusHistory' => function ($query) {
                $query->where('is_visible_to_user', true)->latest();
            },
            'attachments'
        ]);

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->ofType($request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->ofStatus($request->status);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        if ($sort === 'newest') {
            $query->latest();
        } elseif ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'updated') {
            $query->orderBy('updated_at', 'desc');
        }

        $feedbackList = $query->paginate(10);

        return view('feedback.dashboard', compact('feedbackList'));
    }

    /**
     * Display the feedback detail view.
     */
    public function show($feedbackId)
    {
        $feedback = Feedback::where('feedback_id', $feedbackId)
            ->with([
                'user',
                'statusHistory' => function ($query) {
                    $query->where('is_visible_to_user', true)->latest();
                },
                'attachments',
                'statusHistory.adminUser'
            ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('feedback.detail', compact('feedback'));
    }

    /**
     * Withdraw a feedback submission.
     */
    public function withdraw($feedbackId)
    {
        $feedback = Feedback::where('feedback_id', $feedbackId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$feedback->canBeWithdrawn()) {
            return back()->with('error', 'This feedback cannot be withdrawn.');
        }

        $feedback->withdraw();

        return back()->with('success', 'Your feedback has been withdrawn.');
    }

    /**
     * Get device information from request.
     */
    private function getDeviceInfo(Request $request): string
    {
        $userAgent = $request->userAgent();
        $deviceInfo = [];

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            $deviceInfo[] = 'Mobile';
        } else {
            $deviceInfo[] = 'Desktop';
        }

        // Detect browser
        if (preg_match('/Chrome/i', $userAgent)) {
            $deviceInfo[] = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $deviceInfo[] = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $deviceInfo[] = 'Safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $deviceInfo[] = 'Edge';
        } else {
            $deviceInfo[] = 'Unknown Browser';
        }

        // Detect OS
        if (preg_match('/Windows/i', $userAgent)) {
            $deviceInfo[] = 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            $deviceInfo[] = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $deviceInfo[] = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $deviceInfo[] = 'Android';
        } elseif (preg_match('/iOS|iPhone|iPad/i', $userAgent)) {
            $deviceInfo[] = 'iOS';
        }

        return implode(' - ', $deviceInfo);
    }
}
