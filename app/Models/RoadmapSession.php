<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RoadmapSession extends Model
{
    protected $fillable = [
        'user_id',
        'session_uuid',
        'user_level',
        'product_type',
        'product_stage',
        'team_size',
        'funding_stage',
        'mrr_range',
        'challenges',
        'priorities',
        'current_metrics',
        'input_context',
        'ai_model_used',
        'complexity_level',
        'status',
        'error_message',
    ];

    protected $casts = [
        'challenges' => 'array',
        'priorities' => 'array',
        'current_metrics' => 'array',
        'input_context' => 'array',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($session) {
            if (empty($session->session_uuid)) {
                $session->session_uuid = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the user that owns the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the output for this session.
     */
    public function output(): HasOne
    {
        return $this->hasOne(RoadmapOutput::class, 'session_id');
    }

    /**
     * Get the latest output for this session.
     */
    public function latestOutput(): HasOne
    {
        return $this->hasOne(RoadmapOutput::class, 'session_id')->latestOfMany();
    }

    /**
     * Get the progress for this session.
     */
    public function progress()
    {
        return $this->hasOneThrough(
            UserRoadmapProgress::class,
            RoadmapOutput::class,
            'session_id', // Foreign key on roadmap_outputs table
            'output_id', // Foreign key on user_roadmap_progress table
            'id', // Local key on roadmap_sessions table
            'id'  // Local key on roadmap_outputs table
        );
    }

    /**
     * Scope for user's sessions.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for user level.
     */
    public function scopeByLevel($query, string $level)
    {
        return $query->where('user_level', $level);
    }

    /**
     * Scope for completed sessions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for recent sessions.
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Check if session is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if session is generating.
     */
    public function isGenerating(): bool
    {
        return $this->status === 'generating';
    }

    /**
     * Get user level label.
     */
    public function getUserLevelLabelAttribute(): string
    {
        return match ($this->user_level) {
            'junior' => 'Junior PM',
            'mid' => 'Mid-Level PM',
            'senior' => 'Senior PM / Founder',
            default => 'Unknown',
        };
    }

    /**
     * Get product type label.
     */
    public function getProductTypeLabelAttribute(): string
    {
        return match ($this->product_type) {
            'saas' => 'SaaS',
            'marketplace' => 'Marketplace',
            'ecommerce' => 'E-commerce',
            'mobile_app' => 'Mobile App',
            'other' => 'Other',
            default => 'Not specified',
        };
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'generating' => 'yellow',
            'completed' => 'green',
            'failed' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get complexity level based on user level.
     */
    public static function getComplexityForLevel(string $level): string
    {
        return match ($level) {
            'junior' => 'basic',
            'mid' => 'standard',
            'senior' => 'advanced',
            default => 'basic',
        };
    }
}
