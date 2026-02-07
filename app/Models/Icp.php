<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Icp extends Model
{

    protected $fillable = [
        'user_id',
        'uuid',
        'project_name',
        'input_data',
        'generated_icp',
        'status',
    ];

    protected $casts = [
        'input_data' => 'array',
        'generated_icp' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
