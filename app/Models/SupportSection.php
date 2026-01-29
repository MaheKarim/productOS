<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class SupportSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'headline',
        'body_text',
        'image_path',
        'buymeacoffee_url',
        'show_progress_bar',
        'progress_value',
        'progress_goal',
        'progress_label',
        'twitter_url',
        'linkedin_url',
        'is_active',
    ];

    protected $casts = [
        'show_progress_bar' => 'boolean',
        'is_active' => 'boolean',
        'progress_value' => 'integer',
        'progress_goal' => 'integer',
    ];

    /**
     * Get the image URL for the support section.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Get progress percentage.
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->progress_goal <= 0) {
            return 0;
        }

        return min(100, round(($this->progress_value / $this->progress_goal) * 100));
    }

    /**
     * Scope for active support sections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the first active support section or create a default one.
     */
    public static function firstActive(): ?self
    {
        return static::active()->first();
    }
}
