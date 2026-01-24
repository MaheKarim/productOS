<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoadmapTopic extends Model
{
    protected $guarded = [];

    protected $casts = [
        'resources' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(RoadmapCategory::class, 'category_id');
    }

    public function userProgress(): HasOne
    {
        return $this->hasOne(RoadmapProgress::class, 'topic_id')->where('user_id', auth()->id());
    }
}
