<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'type',
        'changefreq',
        'priority',
        'lastmod',
        'is_active',
        'source_model',
        'source_route',
        'sort_order',
        'notes',
    ];

    protected $casts = [
        'lastmod' => 'datetime',
        'is_active' => 'boolean',
        'priority' => 'decimal:1',
    ];

    /**
     * Get active sitemap items ordered by sort_order
     */
    public static function getActiveItems()
    {
        return static::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get items by type
     */
    public static function getByType(string $type)
    {
        return static::where('type', $type)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Scope for active items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Get available changefreq options
     */
    public static function getChangefreqOptions(): array
    {
        return [
            'always' => 'Always',
            'hourly' => 'Hourly',
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'never' => 'Never',
        ];
    }

    /**
     * Get available type options
     */
    public static function getTypeOptions(): array
    {
        return [
            'static' => 'Static Page',
            'dynamic' => 'Dynamic Content',
            'external' => 'External Link',
        ];
    }

    /**
     * Get full URL with domain
     */
    public function getFullUrlAttribute(): string
    {
        if (str_starts_with($this->url, 'http')) {
            return $this->url;
        }

        return url($this->url);
    }

    /**
     * Get lastmod formatted for XML
     */
    public function getLastmodFormattedAttribute(): string
    {
        return $this->lastmod?->format('Y-m-d') ?? now()->format('Y-m-d');
    }
}
