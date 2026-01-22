<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'industry',
        'headline_metric',
        'problem',
        'strategy',
        'implementation',
        'results',
        'tools_used',
        'is_featured',
    ];

    protected $casts = [
        'implementation' => 'array',
        'results' => 'array',
        'tools_used' => 'array',
        'is_featured' => 'boolean',
    ];
}
