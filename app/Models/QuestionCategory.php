<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class QuestionCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the questions that belong to this category.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'category_question', 'question_category_id', 'question_id')
            ->withTimestamps();
    }

    /**
     * Scope to filter only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get questions count.
     */
    public function getQuestionsCountAttribute(): int
    {
        return $this->questions()->count();
    }
}
