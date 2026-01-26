<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'keywords',
        'parent_id',
        'description',
        'metadata',
    ];

    protected $casts = [
        'keywords' => 'array',
        'metadata' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(Topic::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Topic::class, 'parent_id');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_topics')
            ->withPivot('confidence_score', 'is_verified')
            ->withTimestamps();
    }
}
