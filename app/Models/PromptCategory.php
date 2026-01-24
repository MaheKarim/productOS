<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all prompts in this category.
     */
    public function prompts()
    {
        return $this->hasMany(Prompt::class, 'category_id');
    }

    /**
     * Get only published prompts count.
     */
    public function publishedPromptsCount()
    {
        return $this->prompts()->where('status', 'published')->count();
    }

    /**
     * Scope: Active categories only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
