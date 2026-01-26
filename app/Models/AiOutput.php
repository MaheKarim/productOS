<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'summary_english',
        'summary_bangla',
        'actionable_skills',
        'faqs',
        'key_insights',
        'read_reason',
        'generated_at',
    ];

    protected $casts = [
        'actionable_skills' => 'array',
        'faqs' => 'array',
        'key_insights' => 'array',
        'generated_at' => 'datetime',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
