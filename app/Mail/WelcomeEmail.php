<?php

namespace App\Mail;

use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        $settings = app(SettingsService::class);
        return new Envelope(
            subject: $settings->get('registration_email_subject', 'Welcome to ' . config('app.name')),
        );
    }

    public function content(): Content
    {
        $settings = app(SettingsService::class);
        $bodyTemplate = $settings->get('registration_email_body', "Hi {{name}},\n\nWelcome to " . config('app.name') . "!");

        // Simple variable replacement
        $body = str_replace(
            ['{{name}}', '{{email}}'],
            [$this->user->name, $this->user->email],
            $bodyTemplate
        );

        return new Content(
            view: 'emails.welcome',
            with: [
                'body' => $body,
                'subject' => $this->envelope()->subject,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
