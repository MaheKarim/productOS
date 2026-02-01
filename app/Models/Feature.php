<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'is_active',
        'credit_cost',
        'route_name',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'credit_cost' => 'integer',
    ];
}
