<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_listings';

    protected $fillable = [
        'job_title',
        'company_name',
        'location',
        'job_type',
        'experience_level',
        'salary_range',
        'job_details',
        'category_id',
        'is_featured',
        'status',
        'views_count',
        'applications_count',
        'source_url',
        'posted_date',
        'expires_at',
        'job_data',
        'slug',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'job_data' => 'array',
        'metadata' => 'array',
        'posted_date' => 'date',
        'expires_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now()->startOfDay());
        });
    }
}
