<?php

namespace App\Livewire\Feedback;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Feedback;
use App\Models\FeedbackAttachment;
use App\Mail\FeedbackConfirmationEmail;

class FeedbackSubmissionForm extends Component
{
    use WithFileUploads;

    public $type = '';
    public $title = '';
    public $description = '';

    // Bug report fields
    public $severity = 'medium';
    public $steps_to_reproduce = '';
    public $expected_behavior = '';
    public $actual_behavior = '';

    // Feature request fields
    public $priority = 'nice_to_have';
    public $use_case = '';

    // Satisfaction feedback fields
    public $satisfaction_rating = 5;
    public $satisfaction_category = 'other';
    public $whats_working = '';
    public $needs_improvement = '';

    // Common fields
    public $attachments = [];
    public $page_url = '';

    protected $rules = [
        'type' => 'required|in:bug,feature,satisfaction',
        'title' => 'required|string|max:100',
        'description' => 'required|string|min:10',
        'severity' => 'nullable|in:critical,high,medium,low',
        'steps_to_reproduce' => 'nullable|string',
        'expected_behavior' => 'nullable|string',
        'actual_behavior' => 'nullable|string',
        'priority' => 'nullable|in:must_have,nice_to_have',
        'use_case' => 'nullable|string',
        'satisfaction_rating' => 'nullable|integer|min:1|max:10',
        'satisfaction_category' => 'nullable|in:design,performance,content,navigation,other',
        'whats_working' => 'nullable|string',
        'needs_improvement' => 'nullable|string',
        'attachments' => 'nullable|array|max:3',
        'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,pdf,mp4,webm,mov',
        'page_url' => 'nullable|url|max:500',
    ];

    protected $messages = [
        'type.required' => 'Please select a feedback type.',
        'type.in' => 'Please select a valid feedback type.',
        'title.required' => 'Please provide a title for your feedback.',
        'title.max' => 'The title must not exceed 100 characters.',
        'description.required' => 'Please provide a description.',
        'description.min' => 'The description must be at least 10 characters.',
        'attachments.max' => 'You can upload a maximum of 3 files.',
        'attachments.*.max' => 'Each file must not exceed 10MB.',
    ];

    public function mount()
    {
        $this->page_url = url()->previous();
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        // Check for duplicate submissions (same user, same content within 5 minutes)
        $recentDuplicate = Feedback::where('user_id', $user->id)
            ->where('type', $this->type)
            ->where('title', $this->title)
            ->where('description', $this->description)
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();

        if ($recentDuplicate) {
            $this->addError('submit', 'You have already submitted this feedback recently. Please wait a few minutes before submitting again.');
            return;
        }

        // Capture browser and device info
        $browserInfo = request()->userAgent();
        $deviceInfo = $this->getDeviceInfo();

        // Create feedback
        $feedback = Feedback::create([
            'user_id' => $user->id,
            'feedback_id' => Feedback::generateFeedbackId(),
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'status' => Feedback::STATUS_SUBMITTED,
            'severity' => $this->type === 'bug' ? $this->severity : null,
            'steps_to_reproduce' => $this->type === 'bug' ? $this->steps_to_reproduce : null,
            'expected_behavior' => $this->type === 'bug' ? $this->expected_behavior : null,
            'actual_behavior' => $this->type === 'bug' ? $this->actual_behavior : null,
            'priority' => $this->type === 'feature' ? $this->priority : null,
            'use_case' => $this->type === 'feature' ? $this->use_case : null,
            'satisfaction_rating' => $this->type === 'satisfaction' ? $this->satisfaction_rating : null,
            'satisfaction_category' => $this->type === 'satisfaction' ? $this->satisfaction_category : null,
            'whats_working' => $this->type === 'satisfaction' ? $this->whats_working : null,
            'needs_improvement' => $this->type === 'satisfaction' ? $this->needs_improvement : null,
            'page_url' => $this->page_url,
            'browser_info' => $browserInfo,
            'device_info' => $deviceInfo,
            'ip_address' => request()->ip(),
        ]);

        // Handle attachments
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
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
            \Illuminate\Support\Facades\Log::error('Failed to send feedback confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('feedback.thank-you', ['feedback' => $feedback->feedback_id]);
    }

    private function getDeviceInfo(): string
    {
        $userAgent = request()->userAgent();
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

    public function updatedType()
    {
        // Reset type-specific fields when type changes
        $this->reset([
            'severity',
            'steps_to_reproduce',
            'expected_behavior',
            'actual_behavior',
            'priority',
            'use_case',
            'satisfaction_rating',
            'satisfaction_category',
            'whats_working',
            'needs_improvement'
        ]);
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function clearTypeSelection()
    {
        $this->type = '';
        $this->reset([
            'severity',
            'steps_to_reproduce',
            'expected_behavior',
            'actual_behavior',
            'priority',
            'use_case',
            'satisfaction_rating',
            'satisfaction_category',
            'whats_working',
            'needs_improvement'
        ]);
    }

    public function render()
    {
        return view('livewire.feedback.feedback-submission-form');
    }
}
