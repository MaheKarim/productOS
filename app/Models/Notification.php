<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'message',
        'type',
        'priority',
        'icon_class',
        'color_code',
        'action_text',
        'action_url',
        'target_type',
        'target_users',
        'target_role',
        'status',
        'scheduled_at',
        'expires_at',
        'is_dismissible',
        'is_persistent',
        'show_as_popup',
        'created_by',
        'sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'target_users' => 'array',
        'scheduled_at' => 'datetime',
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'is_dismissible' => 'boolean',
        'is_persistent' => 'boolean',
        'show_as_popup' => 'boolean',
    ];

    /**
     * Notification types.
     */
    public const TYPE_SYSTEM = 'system';
    public const TYPE_FEATURE = 'feature';
    public const TYPE_PROMOTIONAL = 'promotional';
    public const TYPE_ALERT = 'alert';
    public const TYPE_PERSONAL = 'personal';
    public const TYPE_CREDIT = 'credit';

    /**
     * Priority levels.
     */
    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    /**
     * Target types.
     */
    public const TARGET_ALL = 'all';
    public const TARGET_SPECIFIC = 'specific';
    public const TARGET_ROLE = 'role';
    public const TARGET_CUSTOM = 'custom';

    /**
     * Status types.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_EXPIRED = 'expired';

    /**
     * Get the user who created the notification.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user notifications for this notification.
     */
    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Get the total recipients count.
     */
    public function getTotalRecipientsAttribute(): int
    {
        return $this->userNotifications()->count();
    }

    /**
     * Get the read count.
     */
    public function getReadCountAttribute(): int
    {
        return $this->userNotifications()->where('is_read', true)->count();
    }

    /**
     * Get the unread count.
     */
    public function getUnreadCountAttribute(): int
    {
        return $this->userNotifications()->where('is_read', false)->count();
    }

    /**
     * Get the read rate percentage.
     */
    public function getReadRateAttribute(): float
    {
        $total = $this->total_recipients;
        if ($total === 0) {
            return 0.0;
        }
        return round(($this->read_count / $total) * 100, 2);
    }

    /**
     * Get the action click rate percentage.
     */
    public function getActionClickRateAttribute(): float
    {
        $total = $this->total_recipients;
        if ($total === 0) {
            return 0.0;
        }
        return round(($this->userNotifications()->where('action_clicked', true)->count() / $total) * 100, 2);
    }

    /**
     * Get the dismiss rate percentage.
     */
    public function getDismissRateAttribute(): float
    {
        $total = $this->total_recipients;
        if ($total === 0) {
            return 0.0;
        }
        return round(($this->userNotifications()->where('is_dismissed', true)->count() / $total) * 100, 2);
    }

    /**
     * Scope a query to only include active notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include scheduled notifications.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED);
    }

    /**
     * Scope a query to only include draft notifications.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    /**
     * Scope a query to only include expired notifications.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    /**
     * Scope a query to only include urgent notifications.
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', self::PRIORITY_URGENT);
    }

    /**
     * Scope a query to only include high priority notifications.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', self::PRIORITY_HIGH);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by target type.
     */
    public function scopeOfTargetType($query, string $targetType)
    {
        return $query->where('target_type', $targetType);
    }

    /**
     * Get the default icon class for each type.
     */
    public static function getIconForType(string $type): string
    {
        return match ($type) {
            self::TYPE_SYSTEM => 'fas fa-info-circle',
            self::TYPE_FEATURE => 'fas fa-star',
            self::TYPE_PROMOTIONAL => 'fas fa-megaphone',
            self::TYPE_ALERT => 'fas fa-exclamation-triangle',
            self::TYPE_PERSONAL => 'fas fa-user',
            self::TYPE_CREDIT => 'fas fa-coins',
            default => 'fas fa-bell',
        };
    }

    /**
     * Get the default color code for each type.
     */
    public static function getColorForType(string $type): string
    {
        return match ($type) {
            self::TYPE_SYSTEM => '#3B82F6', // Blue
            self::TYPE_FEATURE => '#10B981', // Green
            self::TYPE_PROMOTIONAL => '#8B5CF6', // Purple
            self::TYPE_ALERT => '#EF4444', // Red
            self::TYPE_PERSONAL => '#14B8A6', // Teal
            self::TYPE_CREDIT => '#F59E0B', // Yellow
            default => '#6B7280', // Gray
        };
    }

    /**
     * Get the default icon class for each priority.
     */
    public static function getIconForPriority(string $priority): string
    {
        return match ($priority) {
            self::PRIORITY_LOW => 'fas fa-arrow-down',
            self::PRIORITY_MEDIUM => 'fas fa-minus',
            self::PRIORITY_HIGH => 'fas fa-arrow-up',
            self::PRIORITY_URGENT => 'fas fa-exclamation-circle',
            default => 'fas fa-bell',
        };
    }

    /**
     * Check if the notification is currently active and not expired.
     */
    public function isActiveAndNotExpired(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        return true;
    }

    /**
     * Mark notification as expired.
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    /**
     * Mark notification as sent.
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'sent_at' => now(),
        ]);
    }

    /**
     * Get target users based on target type.
     */
    public function getTargetUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return match ($this->target_type) {
            self::TARGET_ALL => User::all(),
            self::TARGET_SPECIFIC => User::whereIn('id', $this->target_users ?? [])->get(),
            self::TARGET_ROLE => $this->target_role ? User::where('role', $this->target_role)->get() : collect(),
            self::TARGET_CUSTOM => $this->getCustomTargetUsers(),
            default => collect(),
        };
    }

    /**
     * Get custom target users based on criteria.
     */
    protected function getCustomTargetUsers(): \Illuminate\Database\Eloquent\Collection
    {
        // Implement custom targeting logic here
        // For example: users with zero credits, active users only, etc.
        return User::all();
    }
}
