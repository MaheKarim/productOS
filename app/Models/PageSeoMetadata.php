<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSeoMetadata extends Model
{
    use HasFactory;

    protected $table = 'page_seo_metadata';
    protected $guarded = [];

    protected $casts = [
        'schema_markup' => 'array',
        'seo_issues' => 'array',
        'include_in_sitemap' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Calculate SEO score based on completeness and best practices
     */
    public function calculateSeoScore(): int
    {
        $score = 0;
        $issues = [];

        // Title check (20 points)
        if ($this->title) {
            $titleLength = strlen($this->title);
            if ($titleLength >= 50 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength > 0 && $titleLength < 70) {
                $score += 15;
                if ($titleLength < 50) {
                    $issues[] = 'Title is too short (recommended: 50-60 characters)';
                } else {
                    $issues[] = 'Title is too long (recommended: 50-60 characters)';
                }
            }
        } else {
            $issues[] = 'Missing meta title';
        }

        // Description check (20 points)
        if ($this->description) {
            $descLength = strlen($this->description);
            if ($descLength >= 150 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength > 0 && $descLength < 200) {
                $score += 15;
                if ($descLength < 150) {
                    $issues[] = 'Description is too short (recommended: 150-160 characters)';
                } else {
                    $issues[] = 'Description is too long (recommended: 150-160 characters)';
                }
            }
        } else {
            $issues[] = 'Missing meta description';
        }

        // Keywords (15 points)
        if ($this->keywords) {
            $keywordCount = count(explode(',', $this->keywords));
            if ($keywordCount >= 3 && $keywordCount <= 10) {
                $score += 15;
            } else {
                $score += 10;
                $issues[] = 'Keyword count should be 3-10';
            }
        } else {
            $issues[] = 'Missing meta keywords';
        }

        // Focus keyword (15 points)
        if ($this->focus_keyword) {
            $score += 15;
            // Check if focus keyword appears in title
            if ($this->title && stripos($this->title, $this->focus_keyword) === false) {
                $issues[] = 'Focus keyword not found in title';
            }
        } else {
            $issues[] = 'Missing focus keyword';
        }

        // Canonical URL (10 points)
        if ($this->canonical_url) {
            $score += 10;
        } else {
            $issues[] = 'Missing canonical URL';
        }

        // Robots meta (10 points) - always present with defaults
        $score += 10;

        // Sitemap inclusion (10 points) - always present with defaults
        $score += 10;

        // Update SEO score and issues
        $this->update([
            'seo_score' => $score,
            'seo_issues' => $issues,
        ]);

        return $score;
    }
}
