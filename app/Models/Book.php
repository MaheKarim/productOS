<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $guarded = [];

    protected $casts = [
        'total_pages' => 'integer',
        'status' => 'string',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug) && !empty($book->title)) {
                $book->slug = $book->generateUniqueSlug($book->title);
            }
        });

        static::updating(function ($book) {
            if ($book->isDirty('title') && !empty($book->title)) {
                $book->slug = $book->generateUniqueSlug($book->title);
            }
        });
    }

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(BookChapter::class)->orderBy('order');
    }

    public function summaries(): HasMany
    {
        return $this->hasMany(BookSummary::class);
    }

    public function fullSummary(): HasOne
    {
        return $this->hasOne(BookSummary::class)->where('type', 'full');
    }
}
