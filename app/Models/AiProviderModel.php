<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiProviderModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'ai_provider_id',
        'model_name',
        'display_name',
        'rate_limit_per_minute',
        'max_tokens_limit',
        'cost_per_1k_input',
        'cost_per_1k_output',
        'is_active',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'rate_limit_per_minute' => 'integer',
        'max_tokens_limit' => 'integer',
        'cost_per_1k_input' => 'decimal:6',
        'cost_per_1k_output' => 'decimal:6',
    ];

    /**
     * Get the provider that owns this model.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(AiProvider::class, 'ai_provider_id');
    }

    /**
     * Scope to get only active models.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the display name or fallback to model name.
     */
    public function getDisplayNameAttribute($value): string
    {
        return $value ?: $this->model_name;
    }
}
