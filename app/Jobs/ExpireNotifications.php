<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExpireNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all active notifications that should be expired now
        $notifications = Notification::where('status', Notification::STATUS_ACTIVE)
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($notifications as $notification) {
            $notification->markAsExpired();
            Log::info('Notification expired', [
                'notification_id' => $notification->id,
                'title' => $notification->title,
            ]);
        }
    }
}
