<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerAssessment extends Model
{
    public const MAX_ENVIRONMENT_SCORE = 12;
    public const MAX_SKILLS_SCORE = 8;
    public const MAX_IMPACT_SCORE = 96;

    protected $fillable = [
        'user_id',
        'session_id',
        'manager_score',
        'resources_score',
        'team_score',
        'scope_score',
        'compensation_score',
        'culture_score',
        'communication_score',
        'leadership_score',
        'strategy_score',
        'execution_score',
        'environment_total',
        'skills_total',
        'impact_score',
        'notes',
        'assessment_date',
    ];

    protected $casts = [
        'manager_score' => 'decimal:2',
        'resources_score' => 'decimal:2',
        'team_score' => 'decimal:2',
        'scope_score' => 'decimal:2',
        'compensation_score' => 'decimal:2',
        'culture_score' => 'decimal:2',
        'communication_score' => 'decimal:2',
        'leadership_score' => 'decimal:2',
        'strategy_score' => 'decimal:2',
        'execution_score' => 'decimal:2',
        'environment_total' => 'decimal:2',
        'skills_total' => 'decimal:2',
        'impact_score' => 'decimal:2',
        'assessment_date' => 'datetime',
    ];

    /**
     * Get the user that owns this assessment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for current user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for recent assessments
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('assessment_date', 'desc')->limit($limit);
    }

    /**
     * Scope for session
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Calculate all totals
     */
    public function calculateTotals(): void
    {
        $this->environment_total = $this->manager_score
            + $this->resources_score
            + $this->team_score
            + $this->scope_score
            + $this->compensation_score
            + $this->culture_score;

        $this->skills_total = $this->communication_score
            + $this->leadership_score
            + $this->strategy_score
            + $this->execution_score;

        $this->impact_score = $this->environment_total * $this->skills_total;
    }

    /**
     * Get status based on impact score
     */
    public function getStatusAttribute(): string
    {
        $score = $this->impact_score;

        if ($score >= 81)
            return 'exceptional';
        if ($score >= 61)
            return 'thriving';
        if ($score >= 41)
            return 'growing';
        if ($score >= 21)
            return 'struggling';
        return 'critical';
    }

    /**
     * Get status label with emoji
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'exceptional' => '🌟 Exceptional',
            'thriving' => '🟢 Thriving',
            'growing' => '🟡 Growing',
            'struggling' => '🟠 Struggling',
            'critical' => '🔴 Critical',
            default => 'Unknown',
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'exceptional' => 'yellow',
            'thriving' => 'green',
            'growing' => 'amber',
            'struggling' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get all environment scores as array
     */
    public function getEnvironmentScoresAttribute(): array
    {
        return [
            'manager' => (float) $this->manager_score,
            'resources' => (float) $this->resources_score,
            'team' => (float) $this->team_score,
            'scope' => (float) $this->scope_score,
            'compensation' => (float) $this->compensation_score,
            'culture' => (float) $this->culture_score,
        ];
    }

    /**
     * Get all skills scores as array
     */
    public function getSkillsScoresAttribute(): array
    {
        return [
            'communication' => (float) $this->communication_score,
            'leadership' => (float) $this->leadership_score,
            'strategy' => (float) $this->strategy_score,
            'execution' => (float) $this->execution_score,
        ];
    }

    /**
     * Get strengths (scores >= 1.75)
     */
    public function getStrengthsAttribute(): array
    {
        $allScores = array_merge($this->environment_scores, $this->skills_scores);
        return array_filter($allScores, fn($score) => $score >= 1.75);
    }

    /**
     * Get weaknesses (scores < 1.0)
     */
    public function getWeaknessesAttribute(): array
    {
        $allScores = array_merge($this->environment_scores, $this->skills_scores);
        return array_filter($allScores, fn($score) => $score < 1.0);
    }

    /**
     * Get critical issues (scores < 0.75)
     */
    public function getCriticalIssuesAttribute(): array
    {
        $allScores = array_merge($this->environment_scores, $this->skills_scores);
        return array_filter($allScores, fn($score) => $score < 0.75);
    }
}
