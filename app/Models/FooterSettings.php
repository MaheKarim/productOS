<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_active',
        'order',
        'logo_text',
        'description',
        'logo_image',
        'linkedin_url',
        'twitter_url',
        'github_url',
        'email',
        'column1_links',
        'column2_links',
        'column3_links',
        'copyright_text',
        'privacy_policy_url',
        'terms_url',
        'meta_title',
        'meta_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'column1_links' => 'array',
        'column2_links' => 'array',
        'column3_links' => 'array',
    ];

    /**
     * Scope a query to only include active footer settings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the first active footer setting.
     *
     * @return FooterSettings|null
     */
    public static function firstActive()
    {
        return static::where('is_active', true)->orderBy('order', 'asc')->first();
    }

    /**
     * Scope a query to order by specified column.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the logo image URL.
     *
     * @return string|null
     */
    public function getLogoImageUrlAttribute(): ?string
    {
        return $this->logo_image ? asset('storage/' . $this->logo_image) : null;
    }
}
