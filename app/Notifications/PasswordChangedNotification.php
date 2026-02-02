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
        return (new MailMessage)
            ->subject('Password Changed Successfully - ProductOS')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your password has been successfully changed.')
            ->line('**Date:** ' . now()->format('F j, Y \a\t g:i A'))
            ->line('If you did not make this change, please contact our support team immediately and secure your account.')
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
