<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'youtube_url',
        'video_id_str',
        'channel_name',
        'channel_logo',
        'channel_id',
        'title',
        'thumbnail_url',
        'upload_date',
        'duration',
        'view_count',
        'transcript',
        'transcript_fetch_attempts',
        'transcript_fetch_error',
        'transcript_fetched_at',
        'access_level',
        'processing_status',
        'ai_provider_id',
        'system_prompt',
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'transcript_fetched_at' => 'datetime',
    ];

    public function aiOutput()
    {
        return $this->hasOne(AiOutput::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'video_topics')
            ->withPivot('confidence_score', 'is_verified')
            ->withTimestamps();
    }

    public function aiProvider()
    {
        return $this->belongsTo(AiProvider::class);
    }
}
