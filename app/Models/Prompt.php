<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Prompt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'slug',
        'title',
        'prompt_text',
        'category_id',
        'ai_tool',
        'use_case_tags',
        'status',
        'description',
        'example_output',
        'author',
        'difficulty_level',
        'output_length',
        'related_prompt_ids',
        'tips',
        'copy_count',
        'view_count',
        'is_featured',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'created_by',
    ];

    protected $casts = [
        'use_case_tags' => 'array',
        'related_prompt_ids' => 'array',
        'tips' => 'array',
        'seo_keywords' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prompt) {
            if (empty($prompt->uuid)) {
                $prompt->uuid = (string) Str::uuid();
            }
            if (empty($prompt->slug)) {
                $prompt->slug = Str::slug($prompt->title);
            }
        });
    }

    // ============ RELATIONSHIPS ============

    /**
     * Get the category.
     */
    public function category()
    {
        return $this->belongsTo(PromptCategory::class, 'category_id');
    }

    /**
     * Get the creator.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get related prompts.
     */
    public function relatedPrompts()
    {
        if (empty($this->related_prompt_ids)) {
            return collect([]);
        }
        return static::whereIn('id', $this->related_prompt_ids)
            ->where('status', 'published')
            ->get();
    }

    // ============ SCOPES ============

    /**
     * Scope: Published prompts only.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: Featured prompts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: By category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: By AI tool.
     */
    public function scopeByTool($query, $tool)
    {
        return $query->where('ai_tool', $tool);
    }

    /**
     * Scope: By difficulty.
     */
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope: Search prompts.
     */
    public function scopeSearch($query, $term)
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('prompt_text', 'like', "%{$term}%")
                ->orWhereJsonContains('use_case_tags', $term);
        });
    }

    // ============ ACCESSORS ============

    /**
     * Get formatted prompt text (markdown to HTML).
     */
    public function getFormattedPromptTextAttribute()
    {
        return Str::markdown($this->prompt_text);
    }

    /**
     * Get AI tool display name.
     */
    public function getAiToolLabelAttribute()
    {
        return match ($this->ai_tool) {
            'chatgpt' => 'ChatGPT',
            'claude' => 'Claude',
            'gemini' => 'Gemini',
            'universal' => 'Universal',
            default => ucfirst($this->ai_tool),
        };
    }

    /**
     * Get difficulty badge color.
     */
    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty_level) {
            'beginner' => 'green',
            'intermediate' => 'amber',
            'advanced' => 'red',
            default => 'slate',
        };
    }

    // ============ METHODS ============

    /**
     * Increment copy count.
     */
    public function incrementCopyCount()
    {
        $this->increment('copy_count');
    }

    /**
     * Increment view count.
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
