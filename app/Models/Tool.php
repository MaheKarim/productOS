<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'difficulty',
        'time_estimate',
        'calculator_config',
        'content',
        'is_active',
    ];

    protected $casts = [
        'calculator_config' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ToolCategory::class, 'category_id');
    }
}
