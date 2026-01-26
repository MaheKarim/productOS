<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPrompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'is_default',
        'type',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_default', false);
    }

    public function scopeForType($query, $type = 'youtube_analysis')
    {
        return $query->where('type', $type);
    }
}
