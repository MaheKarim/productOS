<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapProgress extends Model
{
    protected $table = 'roadmap_user_progress';
    protected $guarded = [];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(RoadmapTopic::class);
    }
}
