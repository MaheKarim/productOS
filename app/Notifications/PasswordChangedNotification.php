<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $settings = app(\App\Services\SettingsService::class);
        $subject = $settings->get('password_reset_success_subject', 'Password Changed Successfully - ProductOS');
        $bodyTemplate = $settings->get('password_reset_success_body', "Hello {{name}}!\n\nYour password has been successfully changed.\n\nIf you did not make this change, please contact our support team immediately.");

        $body = str_replace(
            ['{{name}}', '{{time}}'],
            [$notifiable->name, now()->format('F j, Y \a\t g:i A')],
            $bodyTemplate
        );

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($body)
            ->action('Go to Dashboard', url(route('dashboard')))
            ->salutation('Best regards, The ProductOS Team');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
