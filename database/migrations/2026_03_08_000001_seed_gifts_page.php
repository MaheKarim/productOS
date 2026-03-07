<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'gifts'],
            [
                'name' => 'Gifts',
                'route_name' => 'gifts.index',
                'is_active' => true,
                'show_in_navigation' => true,
                'menu_order' => 4,
            ]
        );

        $page->seoMetadata()->updateOrCreate(
            ['page_id' => $page->id],
            [
                'title' => 'Gift Offers & Deals | ProductOS',
                'description' => 'Discover exclusive gift offers and promotional deals from our partner websites. Save on premium products and services curated for product managers.',
                'keywords' => 'gift offers, deals, promotions, partner offers, discounts, PM resources',
                'focus_keyword' => 'gift offers',
                'canonical_url' => url('/gifts'),
            ]
        );

        // Calculate initial SEO score
        $page->seoMetadata->calculateSeoScore();
    }

    public function down(): void
    {
        $page = Page::where('slug', 'gifts')->first();
        if ($page) {
            $page->seoMetadata()?->delete();
            $page->delete();
        }
    }
};
