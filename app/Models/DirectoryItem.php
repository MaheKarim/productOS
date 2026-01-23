<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'type',
        'name',
        'slug',
        'tagline',
        'description',
        'logo_path',
        'website_url',
        'external_url',
        'category',
        'sub_categories',
        'tags',
        'pricing_model',
        'price_range',
        'bd_available',
        'payment_methods',
        'key_features',
        'pros',
        'cons',
        'use_cases',
        'content_type',
        'language',
        'difficulty_level',
        'duration',
        'instructor',
        'platform',
        'certificate',
        'company_size',
        'industry',
        'location',
        'product_type',
        'is_hiring',
        'salary_range',
        'application_url',
        'application_tips',
        'remote_policy',
        'member_count',
        'activity_level',
        'join_url',
        'template_type',
        'file_format',
        'download_url',
        'preview_url',
        'view_count',
        'click_count',
        'bookmark_count',
        'verification_status',
        'is_featured',
        'is_active',
        'featured_until',
        'submitted_by',
        'admin_notes',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'sub_categories' => 'array',
        'tags' => 'array',
        'payment_methods' => 'array',
        'key_features' => 'array',
        'pros' => 'array',
        'cons' => 'array',
        'use_cases' => 'array',
        'bd_available' => 'boolean',
        'certificate' => 'boolean',
        'is_hiring' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function clicks()
    {
        return $this->hasMany(DirectoryClick::class);
    }
}
