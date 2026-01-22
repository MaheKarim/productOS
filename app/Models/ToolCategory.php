<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'category_id');
    }
}
