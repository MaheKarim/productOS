<?php

namespace App\Livewire\Feedback;

use Livewire\Component;
use App\Models\Feedback;

class FeedbackDetail extends Component
{
    public $feedbackId;
    public $feedback;

    public function mount($feedbackId)
    {
        $this->feedbackId = $feedbackId;
        $this->loadFeedback();
    }

    public function loadFeedback()
    {
        $this->feedback = Feedback::where('feedback_id', $this->feedbackId)
            ->with([
                'user',
                'statusHistory' => function ($query) {
                    $query->where('is_visible_to_user', true)
                        ->with('adminUser')
                        ->latest();
                },
                'attachments',
            ])
            ->where('user_id', auth()->id())
            ->firstOrFail();
    }

    public function withdraw()
    {
        if (!$this->feedback->canBeWithdrawn()) {
            $this->addError('withdraw', 'This feedback cannot be withdrawn.');
            return;
        }

        $this->feedback->withdraw();
        $this->loadFeedback();

        $this->dispatch('feedback-withdrawn');
    }

    public function render()
    {
        return view('livewire.feedback.feedback-detail', [
            'feedback' => $this->feedback,
        ]);
    }
}
