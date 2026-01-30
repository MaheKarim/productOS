<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRoadmapProgress extends Model
{
    protected $table = 'user_roadmap_progress';

    protected $fillable = [
        'user_id',
        'output_id',
        'checkpoints_completed',
        'metrics_updated',
        'notes',
        'completion_percentage',
        'last_reviewed',
    ];

    protected $casts = [
        'checkpoints_completed' => 'array',
        'metrics_updated' => 'array',
        'notes' => 'array',
        'last_reviewed' => 'datetime',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the output for this progress.
     */
    public function output(): BelongsTo
    {
        return $this->belongsTo(RoadmapOutput::class, 'output_id');
    }

    /**
     * Mark a checkpoint as complete.
     */
    public function markCheckpointComplete(string $checkpointId): void
    {
        $completed = $this->checkpoints_completed ?? [];

        if (!in_array($checkpointId, $completed)) {
            $completed[] = $checkpointId;
            $this->checkpoints_completed = $completed;
            $this->recalculateCompletion();
            $this->last_reviewed = now();
            $this->save();
        }
    }

    /**
     * Mark a checkpoint as incomplete.
     */
    public function markCheckpointIncomplete(string $checkpointId): void
    {
        $completed = $this->checkpoints_completed ?? [];

        $this->checkpoints_completed = array_values(array_filter(
            $completed,
            fn($id) => $id !== $checkpointId
        ));

        $this->recalculateCompletion();
        $this->last_reviewed = now();
        $this->save();
    }

    /**
     * Toggle a checkpoint's completion status.
     */
    public function toggleCheckpoint(string $checkpointId): bool
    {
        $completed = $this->checkpoints_completed ?? [];

        if (in_array($checkpointId, $completed)) {
            $this->markCheckpointIncomplete($checkpointId);
            return false;
        } else {
            $this->markCheckpointComplete($checkpointId);
            return true;
        }
    }

    /**
     * Update a metric value.
     */
    public function updateMetric(string $metricId, $value): void
    {
        $metrics = $this->metrics_updated ?? [];
        $metrics[$metricId] = [
            'value' => $value,
            'updated_at' => now()->toISOString(),
        ];
        $this->metrics_updated = $metrics;
        $this->last_reviewed = now();
        $this->save();
    }

    /**
     * Add or update a note.
     */
    public function updateNote(string $sectionId, string $note): void
    {
        $notes = $this->notes ?? [];
        $notes[$sectionId] = [
            'content' => $note,
            'updated_at' => now()->toISOString(),
        ];
        $this->notes = $notes;
        $this->last_reviewed = now();
        $this->save();
    }

    /**
     * Recalculate completion percentage.
     */
    public function recalculateCompletion(): void
    {
        $output = $this->output;

        if (!$output) {
            return;
        }

        $totalCheckpoints = $output->total_checkpoints;
        $completedCount = count($this->checkpoints_completed ?? []);

        $this->completion_percentage = $totalCheckpoints > 0
            ? (int) round(($completedCount / $totalCheckpoints) * 100)
            : 0;
    }

    /**
     * Check if a checkpoint is completed.
     */
    public function isCheckpointCompleted(string $checkpointId): bool
    {
        return in_array($checkpointId, $this->checkpoints_completed ?? []);
    }

    /**
     * Get the number of completed checkpoints.
     */
    public function getCompletedCountAttribute(): int
    {
        return count($this->checkpoints_completed ?? []);
    }

    /**
     * Get or create progress for a user and output.
     */
    public static function getOrCreate(int $userId, int $outputId): self
    {
        return static::firstOrCreate(
            ['user_id' => $userId, 'output_id' => $outputId],
            [
                'checkpoints_completed' => [],
                'metrics_updated' => [],
                'notes' => [],
                'completion_percentage' => 0,
            ]
        );
    }
}
