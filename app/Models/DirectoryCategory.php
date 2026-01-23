<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectoryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'slug',
        'description',
        'icon',
        'color_class',
        'display_order',
        'is_active',
        'item_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'item_count' => 'integer',
        'display_order' => 'integer',
    ];
}
