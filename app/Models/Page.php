<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_navigation' => 'boolean',
        'access_restrictions' => 'array',
        'scheduled_activation' => 'datetime',
        'scheduled_deactivation' => 'datetime',
    ];

    public function seoMetadata()
    {
        return $this->hasOne(PageSeoMetadata::class);
    }

    public function versions()
    {
        return $this->hasMany(PageVersion::class)->orderByDesc('created_at');
    }

    public function analytics()
    {
        return $this->hasMany(PageAnalytics::class);
    }

    /**
     * Check if page is accessible based on active status and scheduling
     */
    public function isAccessible(): bool
    {
        // Check active status
        if (!$this->is_active) {
            return false;
        }

        // Check scheduled activation/deactivation
        $now = now();
        if ($this->scheduled_activation && $now->lt($this->scheduled_activation)) {
            return false;
        }
        if ($this->scheduled_deactivation && $now->gte($this->scheduled_deactivation)) {
            return false;
        }

        // Check access restrictions (future enhancement)
        if ($this->access_restrictions) {
            // TODO: Implement role/auth checks
            // For now, return true
        }

        return true;
    }

    /**
     * Save a version snapshot when changes are made
     */
    public function saveVersion(string $changeType, string $note = null): PageVersion
    {
        return $this->versions()->create([
            'user_id' => auth()->id(),
            'data' => [
                'page' => $this->toArray(),
                'seo' => $this->seoMetadata?->toArray(),
            ],
            'change_type' => $changeType,
            'change_note' => $note,
            'created_at' => now(),
        ]);
    }

    /**
     * Get pages that should appear in navigation
     */
    public static function navigationPages()
    {
        return static::where('is_active', true)
            ->where('show_in_navigation', true)
            ->orderBy('menu_order')
            ->get();
    }
}
