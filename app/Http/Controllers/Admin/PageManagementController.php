<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageManagementController extends Controller
{
    /**
     * Display all pages
     */
    public function index()
    {
        $pages = Page::with('seoMetadata')
            ->withCount('analytics')
            ->orderBy('menu_order')
            ->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show edit form for a page
     */
    public function edit(Page $page)
    {
        $page->load('seoMetadata', 'versions');
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update page settings
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'route_name' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'show_in_navigation' => 'boolean',
            'menu_order' => 'integer|min:0',
            'inactive_behavior' => 'in:coming_soon,404,redirect_home,maintenance',
            'scheduled_activation' => 'nullable|date',
            'scheduled_deactivation' => 'nullable|date|after:scheduled_activation',
        ]);

        $page->update($validated);

        // Save version
        $page->saveVersion('page_update', 'Page settings updated');

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully');
    }

    /**
     * Toggle page activation status
     */
    public function toggleStatus(Page $page)
    {
        $page->update(['is_active' => !$page->is_active]);

        $changeType = $page->is_active ? 'activation' : 'deactivation';
        $page->saveVersion($changeType, "Page {$changeType} via toggle");

        return back()->with('success', "Page {$changeType} successful");
    }

    /**
     * Bulk activate/deactivate pages
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'page_ids' => 'required|array',
            'page_ids.*' => 'exists:pages,id',
            'action' => 'required|in:activate,deactivate',
        ]);

        $isActive = $validated['action'] === 'activate';

        Page::whereIn('id', $validated['page_ids'])
            ->update(['is_active' => $isActive]);

        $count = count($validated['page_ids']);
        $action = $validated['action'] . 'd';

        return back()->with('success', "{$count} page(s) {$action} successfully");
    }

    /**
     * Update SEO metadata
     */
    public function updateSeo(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:200',
            'keywords' => 'nullable|string',
            'focus_keyword' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|url',
            'robots_index' => 'in:index,noindex',
            'robots_follow' => 'in:follow,nofollow',
            'include_in_sitemap' => 'boolean',
            'sitemap_priority' => 'numeric|min:0|max:1',
            'sitemap_frequency' => 'in:always,hourly,daily,weekly,monthly,yearly,never',
        ]);

        if ($page->seoMetadata) {
            $page->seoMetadata->update($validated);
        } else {
            $page->seoMetadata()->create($validated);
        }

        // Recalculate SEO score
        $score = $page->seoMetadata->calculateSeoScore();

        // Save version
        $page->saveVersion('seo_update', 'SEO metadata updated');

        return back()->with('success', "SEO updated successfully. Score: {$score}/100");
    }

    /**
     * Show analytics for a page
     */
    public function analytics(Page $page)
    {
        $analytics = $page->analytics()
            ->orderByDesc('date')
            ->limit(30)
            ->get();

        return view('admin.pages.analytics', compact('page', 'analytics'));
    }

    /**
     * Show version history
     */
    public function versions(Page $page)
    {
        $versions = $page->versions()->with('user')->paginate(20);
        return view('admin.pages.versions', compact('page', 'versions'));
    }
}
