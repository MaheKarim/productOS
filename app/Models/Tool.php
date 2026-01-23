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
        'faqs',
        'is_active',
        'sort_order',
        'problem_solved',
        'when_to_use',
        'when_not_to_use',
        'data_required',
        'outcome',
    ];

    protected $casts = [
        'calculator_config' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(ToolCategory::class, 'category_id');
    }
}
