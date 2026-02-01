<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feature_key',
        'credits_deducted',
        'credits_remaining',
        'status',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
        'credits_deducted' => 'integer',
        'credits_remaining' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feature()
    {
        // Assuming we might want to link to the Feature model, though key is stored directly
        // This allows for efficient querying even if the feature record is deleted/soft-deleted
        return $this->belongsTo(Feature::class, 'feature_key', 'key');
    }
}
