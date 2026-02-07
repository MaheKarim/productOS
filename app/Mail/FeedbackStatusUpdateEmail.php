<?php

namespace App\Mail;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FeedbackStatusUpdateEmail extends Mailable implements ShouldQueue
{
    use Queueable;

    public $feedback;
    public $statusHistory;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
        $this->statusHistory = $feedback->statusHistory()->latest()->first();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update on your feedback: ' . $this->feedback->title . ' (' . $this->feedback->feedback_id . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback.status-update',
            with: [
                'feedback' => $this->feedback,
                'user' => $this->feedback->user,
                'statusHistory' => $this->statusHistory,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
