<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ResumeAnalysis extends Model
{
    use HasFactory;

    protected $table = 'resume_analyses';

    protected $fillable = [
        'user_id',
        'uuid',
        'file_name',
        'job_id',
        'analysis_type',
        'overall_score',
        'confidence_score',
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
        'job_description',
        'analysis_results',
    ];

    /**
     * Bootstrap the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

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
        'analysis_results' => 'array',
        'job_description' => 'array',
    ];

    /**
     * Get the user who owns this analysis.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job associated with this analysis (if any).
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Check if this is a job comparison analysis.
     */
    public function isJobComparison(): bool
    {
        return $this->analysis_type === 'job_comparison' && !is_null($this->job_id);
    }

    /**
     * Get the analysis results as a decoded array.
     */
    public function getAnalysisResultsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    /**
     * Set the analysis results as JSON.
     */
    public function setAnalysisResultsAttribute($value)
    {
        $this->attributes['analysis_results'] = is_array($value) ? json_encode($value) : $value;
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
