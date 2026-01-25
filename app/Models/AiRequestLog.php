<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiRequestLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'ai_provider_id',
        'model',
        'status',
        'response_time_ms',
        'input_tokens',
        'output_tokens',
        'cost',
        'error_message',
        'endpoint',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'response_time_ms' => 'integer',
        'input_tokens' => 'integer',
        'output_tokens' => 'integer',
        'cost' => 'decimal:6',
        'metadata' => 'array',
    ];

    /**
     * Get the provider that owns this log.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(AiProvider::class, 'ai_provider_id');
    }

    /**
     * Scope to filter by provider.
     */
    public function scopeForProvider($query, int $providerId)
    {
        return $query->where('ai_provider_id', $providerId);
    }

    /**
     * Scope to filter by model.
     */
    public function scopeForModel($query, string $model)
    {
        return $query->where('model', $model);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope to filter errors.
     */
    public function scopeErrors($query)
    {
        return $query->where('status', 'error');
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeInDateRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    /**
     * Scope to filter last N days.
     */
    public function scopeLastDays($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope to filter last N hours.
     */
    public function scopeLastHours($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    /**
     * Get total tokens (input + output).
     */
    public function getTotalTokensAttribute(): int
    {
        return ($this->input_tokens ?? 0) + ($this->output_tokens ?? 0);
    }

    /**
     * Log a successful request.
     */
    public static function logSuccess(
        int $providerId,
        string $model,
        int $responseTimeMs,
        ?int $inputTokens = null,
        ?int $outputTokens = null,
        float $cost = 0,
        ?string $endpoint = null,
        ?array $metadata = null
    ): self {
        return static::create([
            'ai_provider_id' => $providerId,
            'model' => $model,
            'status' => 'success',
            'response_time_ms' => $responseTimeMs,
            'input_tokens' => $inputTokens,
            'output_tokens' => $outputTokens,
            'cost' => $cost,
            'endpoint' => $endpoint,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Log a failed request.
     */
    public static function logError(
        int $providerId,
        string $model,
        int $responseTimeMs,
        string $errorMessage,
        ?string $endpoint = null,
        ?array $metadata = null
    ): self {
        return static::create([
            'ai_provider_id' => $providerId,
            'model' => $model,
            'status' => 'error',
            'response_time_ms' => $responseTimeMs,
            'error_message' => $errorMessage,
            'endpoint' => $endpoint,
            'metadata' => $metadata,
        ]);
    }
}
