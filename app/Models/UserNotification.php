<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'notification_id',
        'user_id',
        'is_read',
        'read_at',
        'is_dismissed',
        'dismissed_at',
        'action_clicked',
        'clicked_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_dismissed' => 'boolean',
        'dismissed_at' => 'datetime',
        'action_clicked' => 'boolean',
        'clicked_at' => 'datetime',
    ];

    /**
     * Get the notification that belongs to this user notification.
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * Get the user that owns this notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): void
    {
        if ($this->is_read) {
            $this->update([
                'is_read' => false,
                'read_at' => null,
            ]);
        }
    }

    /**
     * Dismiss the notification.
     */
    public function dismiss(): void
    {
        if (!$this->is_dismissed) {
            $this->update([
                'is_dismissed' => true,
                'dismissed_at' => now(),
            ]);
        }
    }

    /**
     * Restore the dismissed notification.
     */
    public function restore(): void
    {
        if ($this->is_dismissed) {
            $this->update([
                'is_dismissed' => false,
                'dismissed_at' => null,
            ]);
        }
    }

    /**
     * Record action click.
     */
    public function recordActionClick(): void
    {
        if (!$this->action_clicked) {
            $this->update([
                'action_clicked' => true,
                'clicked_at' => now(),
            ]);
        }
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read notifications.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to only include dismissed notifications.
     */
    public function scopeDismissed($query)
    {
        return $query->where('is_dismissed', true);
    }

    /**
     * Scope a query to only include active (not dismissed) notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_dismissed', false);
    }

    /**
     * Scope a query to filter by notification type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->whereHas('notification', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    /**
     * Scope a query to filter by notification priority.
     */
    public function scopeOfPriority($query, string $priority)
    {
        return $query->whereHas('notification', function ($q) use ($priority) {
            $q->where('priority', $priority);
        });
    }

    /**
     * Scope a query to filter by notification status.
     */
    public function scopeOfNotificationStatus($query, string $status)
    {
        return $query->whereHas('notification', function ($q) use ($status) {
            $q->where('status', $status);
        });
    }

    /**
     * Scope a query to only include notifications that are not expired.
     */
    public function scopeNotExpired($query)
    {
        return $query->whereHas('notification', function ($q) {
            $q->where(function ($subQuery) {
                $subQuery->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
        });
    }

    /**
     * Scope a query to only include notifications that should show as popup.
     */
    public function scopeShowAsPopup($query)
    {
        return $query->whereHas('notification', function ($q) {
            $q->where('show_as_popup', true)
                ->where('priority', Notification::PRIORITY_URGENT);
        });
    }

    /**
     * Check if the notification can be dismissed by the user.
     */
    public function canBeDismissed(): bool
    {
        return $this->notification->is_dismissible && !$this->notification->is_persistent;
    }

    /**
     * Check if the notification should be visible to the user.
     */
    public function isVisible(): bool
    {
        if ($this->is_dismissed) {
            return false;
        }

        $notification = $this->notification;

        if ($notification->status !== Notification::STATUS_ACTIVE) {
            return false;
        }

        if ($notification->expires_at && $notification->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Get the time since the notification was created.
     */
    public function getTimeSinceCreatedAttribute(): string
    {
        return $this->notification->created_at->diffForHumans();
    }

    /**
     * Get the time since the notification was sent.
     */
    public function getTimeSinceSentAttribute(): ?string
    {
        return $this->notification->sent_at?->diffForHumans();
    }

    /**
     * Get the time since the notification was read.
     */
    public function getTimeSinceReadAttribute(): ?string
    {
        return $this->read_at?->diffForHumans();
    }
}
