<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'question',
        'answers',
        'correct_answer',
        'explanation',
        'difficulty',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'answers' => 'array',
        'correct_answer' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the categories this question belongs to.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(QuestionCategory::class, 'category_question', 'question_id', 'question_category_id')
            ->withTimestamps();
    }

    /**
     * Scope to filter only active questions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by difficulty.
     */
    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeInCategory($query, int $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('question_categories.id', $categoryId);
        });
    }

    /**
     * Get the difficulty badge color.
     */
    public function getDifficultyColorAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'bg-teal-100 text-teal-800',
            'medium' => 'bg-amber-100 text-amber-800',
            'hard' => 'bg-red-100 text-red-800',
            default => 'bg-slate-100 text-slate-800',
        };
    }

    /**
     * Get answers count.
     */
    public function getAnswersCountAttribute(): int
    {
        return is_array($this->answers) ? count($this->answers) : 0;
    }

    /**
     * Get truncated question text.
     */
    public function getTruncatedQuestionAttribute(): string
    {
        return \Illuminate\Support\Str::limit($this->question, 100);
    }
}
