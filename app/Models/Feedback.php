<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'feedback_id',
        'type',
        'title',
        'description',
        'status',
        'severity',
        'priority',
        'satisfaction_rating',
        'satisfaction_category',
        'whats_working',
        'needs_improvement',
        'steps_to_reproduce',
        'expected_behavior',
        'actual_behavior',
        'use_case',
        'page_url',
        'browser_info',
        'device_info',
        'ip_address',
        'is_withdrawn',
        'withdrawn_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_withdrawn' => 'boolean',
        'withdrawn_at' => 'datetime',
        'satisfaction_rating' => 'integer',
    ];

    /**
     * Feedback types.
     */
    public const TYPE_BUG = 'bug';
    public const TYPE_FEATURE = 'feature';
    public const TYPE_SATISFACTION = 'satisfaction';

    /**
     * Status types.
     */
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_PLANNED = 'planned';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CLOSED = 'closed';

    /**
     * Severity levels.
     */
    public const SEVERITY_CRITICAL = 'critical';
    public const SEVERITY_HIGH = 'high';
    public const SEVERITY_MEDIUM = 'medium';
    public const SEVERITY_LOW = 'low';

    /**
     * Priority levels.
     */
    public const PRIORITY_MUST_HAVE = 'must_have';
    public const PRIORITY_NICE_TO_HAVE = 'nice_to_have';

    /**
     * Satisfaction categories.
     */
    public const SATISFACTION_DESIGN = 'design';
    public const SATISFACTION_PERFORMANCE = 'performance';
    public const SATISFACTION_CONTENT = 'content';
    public const SATISFACTION_NAVIGATION = 'navigation';
    public const SATISFACTION_OTHER = 'other';

    /**
     * Get the user who submitted the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status history for this feedback.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(FeedbackStatusHistory::class);
    }

    /**
     * Get the attachments for this feedback.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(FeedbackAttachment::class);
    }

    /**
     * Get the latest status update.
     */
    public function latestStatusUpdate()
    {
        return $this->hasOne(FeedbackStatusHistory::class)->latestOfMany();
    }

    /**
     * Scope a query to only include active feedback (not withdrawn).
     */
    public function scopeActive($query)
    {
        return $query->where('is_withdrawn', false);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeOfStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to get active statuses (not closed).
     */
    public function scopeActiveStatus($query)
    {
        return $query->whereIn('status', [
            self::STATUS_SUBMITTED,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_PLANNED,
            self::STATUS_IN_PROGRESS,
        ]);
    }

    /**
     * Scope a query to get resolved statuses.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', self::STATUS_RESOLVED);
    }

    /**
     * Scope a query to get closed statuses.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', self::STATUS_CLOSED);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_UNDER_REVIEW => 'Under Review',
            self::STATUS_PLANNED => 'Planned',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_RESOLVED => 'Resolved',
            self::STATUS_CLOSED => 'Closed',
            default => 'Unknown',
        };
    }

    /**
     * Get the status color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_SUBMITTED => '#9CA3AF', // Gray
            self::STATUS_UNDER_REVIEW => '#3B82F6', // Blue
            self::STATUS_PLANNED => '#8B5CF6', // Purple
            self::STATUS_IN_PROGRESS => '#F59E0B', // Orange
            self::STATUS_RESOLVED => '#10B981', // Green
            self::STATUS_CLOSED => '#6B7280', // Dark Gray
            default => '#6B7280',
        };
    }

    /**
     * Get the status icon class.
     */
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_SUBMITTED => 'fas fa-inbox',
            self::STATUS_UNDER_REVIEW => 'fas fa-eye',
            self::STATUS_PLANNED => 'fas fa-calendar',
            self::STATUS_IN_PROGRESS => 'fas fa-cog fa-spin',
            self::STATUS_RESOLVED => 'fas fa-check-circle',
            self::STATUS_CLOSED => 'fas fa-times-circle',
            default => 'fas fa-question-circle',
        };
    }

    /**
     * Get the type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_BUG => 'Bug Report',
            self::TYPE_FEATURE => 'Feature Request',
            self::TYPE_SATISFACTION => 'General Feedback',
            default => 'Unknown',
        };
    }

    /**
     * Get the type icon class.
     */
    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_BUG => 'fas fa-bug',
            self::TYPE_FEATURE => 'fas fa-lightbulb',
            self::TYPE_SATISFACTION => 'fas fa-smile',
            default => 'fas fa-comment',
        };
    }

    /**
     * Get the type color.
     */
    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_BUG => '#EF4444', // Red
            self::TYPE_FEATURE => '#10B981', // Green
            self::TYPE_SATISFACTION => '#F59E0B', // Yellow
            default => '#6B7280',
        };
    }

    /**
     * Get the severity label.
     */
    public function getSeverityLabelAttribute(): ?string
    {
        if (!$this->severity) {
            return null;
        }

        return match ($this->severity) {
            self::SEVERITY_CRITICAL => 'Critical',
            self::SEVERITY_HIGH => 'High',
            self::SEVERITY_MEDIUM => 'Medium',
            self::SEVERITY_LOW => 'Low',
            default => null,
        };
    }

    /**
     * Get the severity color.
     */
    public function getSeverityColorAttribute(): ?string
    {
        if (!$this->severity) {
            return null;
        }

        return match ($this->severity) {
            self::SEVERITY_CRITICAL => '#DC2626', // Dark Red
            self::SEVERITY_HIGH => '#EF4444', // Red
            self::SEVERITY_MEDIUM => '#F59E0B', // Orange
            self::SEVERITY_LOW => '#10B981', // Green
            default => null,
        };
    }

    /**
     * Get the priority label.
     */
    public function getPriorityLabelAttribute(): ?string
    {
        if (!$this->priority) {
            return null;
        }

        return match ($this->priority) {
            self::PRIORITY_MUST_HAVE => 'Must-have',
            self::PRIORITY_NICE_TO_HAVE => 'Nice-to-have',
            default => null,
        };
    }

    /**
     * Get the priority color.
     */
    public function getPriorityColorAttribute(): ?string
    {
        if (!$this->priority) {
            return null;
        }

        return match ($this->priority) {
            self::PRIORITY_MUST_HAVE => '#DC2626', // Dark Red
            self::PRIORITY_NICE_TO_HAVE => '#10B981', // Green
            default => null,
        };
    }

    /**
     * Get the satisfaction category label.
     */
    public function getSatisfactionCategoryLabelAttribute(): ?string
    {
        if (!$this->satisfaction_category) {
            return null;
        }

        return match ($this->satisfaction_category) {
            self::SATISFACTION_DESIGN => 'Design',
            self::SATISFACTION_PERFORMANCE => 'Performance',
            self::SATISFACTION_CONTENT => 'Content',
            self::SATISFACTION_NAVIGATION => 'Navigation',
            self::SATISFACTION_OTHER => 'Other',
            default => null,
        };
    }

    /**
     * Check if the feedback can be withdrawn.
     */
    public function canBeWithdrawn(): bool
    {
        return $this->status === self::STATUS_SUBMITTED && !$this->is_withdrawn;
    }

    /**
     * Withdraw the feedback.
     */
    public function withdraw(): void
    {
        $this->update([
            'is_withdrawn' => true,
            'withdrawn_at' => now(),
        ]);
    }

    /**
     * Update the status and record the history.
     */
    public function updateStatus(string $newStatus, ?int $adminUserId = null, ?string $adminComment = null, bool $isVisibleToUser = true): void
    {
        $oldStatus = $this->status;

        if ($oldStatus !== $newStatus) {
            FeedbackStatusHistory::create([
                'feedback_id' => $this->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'admin_user_id' => $adminUserId,
                'admin_comment' => $adminComment,
                'is_visible_to_user' => $isVisibleToUser,
            ]);

            $this->update(['status' => $newStatus]);
        }
    }

    /**
     * Generate a unique feedback ID.
     */
    public static function generateFeedbackId(): string
    {
        $prefix = 'FB';
        $timestamp = now()->format('ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$prefix}{$timestamp}{$random}";
    }

    /**
     * Get the user-facing message for the current status.
     */
    public function getStatusMessageAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_SUBMITTED => "We've received your feedback and will review it shortly.",
            self::STATUS_UNDER_REVIEW => "Our team is reviewing your feedback.",
            self::STATUS_PLANNED => "Great news! We're working on this.",
            self::STATUS_IN_PROGRESS => "We're actively working on this.",
            self::STATUS_RESOLVED => "This has been completed!",
            self::STATUS_CLOSED => "We've reviewed this feedback.",
            default => '',
        };
    }
}
