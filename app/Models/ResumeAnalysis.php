<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeAnalysis extends Model
{
    use HasFactory;

    protected $table = 'resume_analyses';

    protected $fillable = [
        'user_id',
        'file_name',
        'overall_score',
        'priority_summary',
        'section_breakdown',
        'content_metrics',
        'ats_checklist',
        'improvement_examples',
        'contact_validation',
        'resume_length',
        'missing_sections',
        'keyword_suggestions',
        'formatting_issues',
        'section_scores',
        'recommendations',
        'action_verbs',
        'raw_resume_text',
    ];

    protected $casts = [
        'priority_summary' => 'array',
        'section_breakdown' => 'array',
        'content_metrics' => 'array',
        'ats_checklist' => 'array',
        'improvement_examples' => 'array',
        'contact_validation' => 'array',
        'resume_length' => 'array',
        'missing_sections' => 'array',
        'keyword_suggestions' => 'array',
        'formatting_issues' => 'array',
        'section_scores' => 'array',
        'recommendations' => 'array',
        'action_verbs' => 'array',
    ];

    /**
     * Get the user who owns this analysis.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the score color based on the overall score.
     */
    public function getScoreColorAttribute(): string
    {
        if ($this->overall_score >= 80) {
            return '#10b981'; // green
        } elseif ($this->overall_score >= 60) {
            return '#f59e0b'; // amber
        } elseif ($this->overall_score >= 40) {
            return '#f97316'; // orange
        }
        return '#ef4444'; // red
    }

    /**
     * Get the score label based on the overall score.
     */
    public function getScoreLabelAttribute(): string
    {
        if ($this->overall_score >= 80) {
            return 'Excellent';
        } elseif ($this->overall_score >= 60) {
            return 'Good';
        } elseif ($this->overall_score >= 40) {
            return 'Needs Improvement';
        }
        return 'Poor';
    }
}
