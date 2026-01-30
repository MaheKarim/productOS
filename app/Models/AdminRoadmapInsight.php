<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoadmapInsight extends Model
{
    protected $fillable = [
        'metric_name',
        'user_segment',
        'dimension',
        'value',
        'insight_type',
        'recorded_date',
    ];

    protected $casts = [
        'value' => 'float',
        'recorded_date' => 'date',
    ];

    /**
     * Scope for specific metric.
     */
    public function scopeForMetric($query, string $metricName)
    {
        return $query->where('metric_name', $metricName);
    }

    /**
     * Scope for user segment.
     */
    public function scopeForSegment($query, string $segment)
    {
        return $query->where('user_segment', $segment);
    }

    /**
     * Scope for insight type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('insight_type', $type);
    }

    /**
     * Scope for date range.
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('recorded_date', [$startDate, $endDate]);
    }

    /**
     * Record a usage metric.
     */
    public static function recordUsage(string $metricName, float $value, ?string $segment = null, ?string $dimension = null): self
    {
        return static::create([
            'metric_name' => $metricName,
            'user_segment' => $segment,
            'dimension' => $dimension,
            'value' => $value,
            'insight_type' => 'usage',
            'recorded_date' => now()->toDateString(),
        ]);
    }

    /**
     * Record a success metric.
     */
    public static function recordSuccess(string $metricName, float $value, ?string $segment = null): self
    {
        return static::create([
            'metric_name' => $metricName,
            'user_segment' => $segment,
            'value' => $value,
            'insight_type' => 'success',
            'recorded_date' => now()->toDateString(),
        ]);
    }

    /**
     * Record a failure metric.
     */
    public static function recordFailure(string $metricName, float $value, ?string $segment = null): self
    {
        return static::create([
            'metric_name' => $metricName,
            'user_segment' => $segment,
            'value' => $value,
            'insight_type' => 'failure',
            'recorded_date' => now()->toDateString(),
        ]);
    }

    /**
     * Get aggregated stats for a metric.
     */
    public static function getAggregatedStats(string $metricName, int $days = 30): array
    {
        $startDate = now()->subDays($days)->toDateString();

        return static::where('metric_name', $metricName)
            ->where('recorded_date', '>=', $startDate)
            ->selectRaw('
                user_segment,
                SUM(value) as total,
                AVG(value) as average,
                COUNT(*) as count
            ')
            ->groupBy('user_segment')
            ->get()
            ->keyBy('user_segment')
            ->toArray();
    }
}
