<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     */
    public string $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
        $subject = $settings->get('forgot_password_subject', 'Reset Your Password - ProductOS');
        $bodyTemplate = $settings->get('forgot_password_body', "Hello,\n\nYou are receiving this email because we received a password reset request for your account.\n\nThis password reset link will expire in 60 minutes.\n\nIf you did not request a password reset, no further action is required.");

        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $body = str_replace(
            ['{{action_url}}', '{{user_name}}'],
            [$url, $notifiable->name],
            $bodyTemplate
        );

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello!')
            ->line($body)
            ->action('Reset Password', $url)
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
