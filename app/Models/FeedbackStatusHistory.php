<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackStatusHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'feedback_id',
        'old_status',
        'new_status',
        'admin_user_id',
        'admin_comment',
        'is_visible_to_user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible_to_user' => 'boolean',
    ];

    /**
     * Get the feedback for this history entry.
     */
    public function feedback(): BelongsTo
    {
        return $this->belongsTo(Feedback::class);
    }

    /**
     * Get the admin user who made this status change.
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    /**
     * Get the old status label.
     */
    public function getOldStatusLabelAttribute(): ?string
    {
        if (!$this->old_status) {
            return null;
        }

        return match ($this->old_status) {
            Feedback::STATUS_SUBMITTED => 'Submitted',
            Feedback::STATUS_UNDER_REVIEW => 'Under Review',
            Feedback::STATUS_PLANNED => 'Planned',
            Feedback::STATUS_IN_PROGRESS => 'In Progress',
            Feedback::STATUS_RESOLVED => 'Resolved',
            Feedback::STATUS_CLOSED => 'Closed',
            default => 'Unknown',
        };
    }

    /**
     * Get the new status label.
     */
    public function getNewStatusLabelAttribute(): string
    {
        return match ($this->new_status) {
            Feedback::STATUS_SUBMITTED => 'Submitted',
            Feedback::STATUS_UNDER_REVIEW => 'Under Review',
            Feedback::STATUS_PLANNED => 'Planned',
            Feedback::STATUS_IN_PROGRESS => 'In Progress',
            Feedback::STATUS_RESOLVED => 'Resolved',
            Feedback::STATUS_CLOSED => 'Closed',
            default => 'Unknown',
        };
    }
}
