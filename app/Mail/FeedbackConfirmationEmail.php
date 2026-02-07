<?php

namespace App\Mail;

use App\Models\Feedback;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FeedbackConfirmationEmail extends Mailable implements ShouldQueue
{
    use Queueable;

    public $feedback;

    public function __construct(Feedback $feedback)
    {
        $this->feedback = $feedback;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for your feedback! (' . $this->feedback->feedback_id . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.feedback.confirmation',
            with: [
                'feedback' => $this->feedback,
                'user' => $this->feedback->user,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
