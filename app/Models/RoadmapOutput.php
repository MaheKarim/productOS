<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapOutput extends Model
{
    protected $fillable = [
        'session_id',
        'simplified_version',
        'detailed_version',
        'strategic_version',
        'metric_framework',
        'benchmarks',
        'execution_toolkit',
        'generation_time_ms',
        'token_count',
    ];

    protected $casts = [
        'simplified_version' => 'array',
        'detailed_version' => 'array',
        'strategic_version' => 'array',
        'metric_framework' => 'array',
        'benchmarks' => 'array',
        'execution_toolkit' => 'array',
    ];

    /**
     * Get the session that owns the output.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(RoadmapSession::class, 'session_id');
    }

    /**
     * Get progress records for this output.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(UserRoadmapProgress::class, 'output_id');
    }

    /**
     * Get the appropriate version based on user level.
     */
    public function getVersionForLevel(string $level): ?array
    {
        return match ($level) {
            'junior' => $this->simplified_version,
            'mid' => $this->detailed_version,
            'senior' => $this->strategic_version,
            default => $this->simplified_version,
        };
    }

    /**
     * Get all available versions.
     */
    public function getAvailableVersionsAttribute(): array
    {
        $versions = [];

        if (!empty($this->simplified_version)) {
            $versions['junior'] = 'Simple 90-Day Plan';
        }
        if (!empty($this->detailed_version)) {
            $versions['mid'] = 'Quarterly OKR Roadmap';
        }
        if (!empty($this->strategic_version)) {
            $versions['senior'] = 'Strategic Framework';
        }

        return $versions;
    }

    /**
     * Get primary framework type from metric_framework.
     */
    public function getPrimaryFrameworkAttribute(): ?string
    {
        return $this->metric_framework['type'] ?? null;
    }

    /**
     * Check if output has all versions.
     */
    public function hasAllVersions(): bool
    {
        return !empty($this->simplified_version)
            && !empty($this->detailed_version)
            && !empty($this->strategic_version);
    }

    /**
     * Get total checkpoints count across all versions.
     */
    public function getTotalCheckpointsAttribute(): int
    {
        $count = 0;

        $version = $this->simplified_version ?? $this->detailed_version ?? $this->strategic_version;

        if ($version && isset($version['phases'])) {
            foreach ($version['phases'] as $phase) {
                $count += count($phase['checkpoints'] ?? []);
            }
        }

        return $count;
    }
}
