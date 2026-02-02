<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendScheduledNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all scheduled notifications that should be sent now
        $notifications = Notification::where('status', Notification::STATUS_SCHEDULED)
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($notifications as $notification) {
            $this->deliverNotification($notification);
        }
    }

    /**
     * Deliver notification to target users.
     */
    protected function deliverNotification(Notification $notification): void
    {
        DB::beginTransaction();
        try {
            // Get target users based on target type
            $targetUsers = $notification->getTargetUsers();

            foreach ($targetUsers as $user) {
                // Check user's notification preferences
                $preferences = $user->getNotificationPreferences();

                if (!$preferences->shouldReceiveType($notification->type)) {
                    continue;
                }

                // Check if user already has this notification
                $existing = UserNotification::where('notification_id', $notification->id)
                    ->where('user_id', $user->id)
                    ->first();

                if ($existing) {
                    continue;
                }

                // Create user notification
                UserNotification::create([
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'is_read' => false,
                    'is_dismissed' => false,
                ]);
            }

            // Mark notification as sent
            $notification->update([
                'status' => Notification::STATUS_ACTIVE,
                'sent_at' => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to send scheduled notification: ' . $e->getMessage(), [
                'notification_id' => $notification->id,
            ]);
        }
    }
}
