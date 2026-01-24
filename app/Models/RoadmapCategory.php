<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapCategory extends Model
{
    protected $guarded = [];

    public function topics(): HasMany
    {
        return $this->hasMany(RoadmapTopic::class, 'category_id')->orderBy('id'); // Default order
    }
}
