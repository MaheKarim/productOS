<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAnalytics extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Track a page view
     */
    public static function trackView(int $pageId, $request = null): void
    {
        $date = now()->toDateString();

        $analytics = static::firstOrCreate(
            [
                'page_id' => $pageId,
                'date' => $date,
            ],
            [
                'views' => 0,
                'unique_visitors' => 0,
            ]
        );

        $analytics->increment('views');

        // Track unique visitors using session
        $sessionKey = "page_view_{$pageId}_{$date}";
        if ($request && !session()->has($sessionKey)) {
            $analytics->increment('unique_visitors');
            session()->put($sessionKey, true);
        }
    }
}
