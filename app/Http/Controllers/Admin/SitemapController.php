<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitemapItem;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tool;
use App\Models\Page;
use App\Models\DirectoryItem;
use App\Models\Job;
use App\Models\Prompt;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    /**
     * Display a listing of sitemap items
     */
    public function index()
    {
        $sitemapItems = SitemapItem::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => SitemapItem::count(),
            'active' => SitemapItem::where('is_active', true)->count(),
            'static' => SitemapItem::where('type', 'static')->count(),
            'dynamic' => SitemapItem::where('type', 'dynamic')->count(),
            'external' => SitemapItem::where('type', 'external')->count(),
        ];

        // Get auto-generated content counts
        $autoStats = [
            'projects' => Project::where('is_active', true)->count(),
            'services' => Service::where('is_active', true)->count(),
            'tools' => Tool::where('is_active', true)->count(),
            'pages' => Page::where('is_active', true)->count(),
            'directory_items' => DirectoryItem::where('is_active', true)->count(),
            'jobs' => Job::where('is_active', true)->count(),
            'prompts' => Prompt::where('is_active', true)->count(),
            'books' => Book::where('is_active', true)->count(),
        ];

        return view('admin.sitemap.index', compact('sitemapItems', 'stats', 'autoStats'));
    }

    /**
     * Show the form for creating a new sitemap item
     */
    public function create()
    {
        $changefreqOptions = SitemapItem::getChangefreqOptions();
        $typeOptions = SitemapItem::getTypeOptions();

        return view('admin.sitemap.create', compact('changefreqOptions', 'typeOptions'));
    }

    /**
     * Store a newly created sitemap item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|string|max:500',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:static,dynamic,external',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'priority' => 'required|numeric|min:0.0|max:1.0',
            'lastmod' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SitemapItem::create($validated);

        return redirect()->route('admin.sitemap.index')
            ->with('success', 'Sitemap item created successfully!');
    }

    /**
     * Show the form for editing a sitemap item
     */
    public function edit(SitemapItem $sitemap)
    {
        $changefreqOptions = SitemapItem::getChangefreqOptions();
        $typeOptions = SitemapItem::getTypeOptions();

        return view('admin.sitemap.edit', compact('sitemap', 'changefreqOptions', 'typeOptions'));
    }

    /**
     * Update the specified sitemap item
     */
    public function update(Request $request, SitemapItem $sitemap)
    {
        $validated = $request->validate([
            'url' => 'required|string|max:500',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:static,dynamic,external',
            'changefreq' => 'required|in:always,hourly,daily,weekly,monthly,yearly,never',
            'priority' => 'required|numeric|min:0.0|max:1.0',
            'lastmod' => 'nullable|date',
            'sort_order' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $sitemap->update($validated);

        return redirect()->route('admin.sitemap.index')
            ->with('success', 'Sitemap item updated successfully!');
    }

    /**
     * Toggle sitemap item active status
     */
    public function toggle(SitemapItem $sitemap)
    {
        $sitemap->update(['is_active' => !$sitemap->is_active]);

        return redirect()->back()
            ->with('success', $sitemap->is_active ? 'Sitemap item activated!' : 'Sitemap item deactivated!');
    }

    /**
     * Remove the specified sitemap item
     */
    public function destroy(SitemapItem $sitemap)
    {
        $sitemap->delete();

        return redirect()->route('admin.sitemap.index')
            ->with('success', 'Sitemap item deleted successfully!');
    }

    /**
     * Bulk action for sitemap items
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No items selected.');
        }

        switch ($action) {
            case 'activate':
                SitemapItem::whereIn('id', $ids)->update(['is_active' => true]);
                $message = count($ids) . ' items activated successfully!';
                break;
            case 'deactivate':
                SitemapItem::whereIn('id', $ids)->update(['is_active' => false]);
                $message = count($ids) . ' items deactivated successfully!';
                break;
            case 'delete':
                SitemapItem::whereIn('id', $ids)->delete();
                $message = count($ids) . ' items deleted successfully!';
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action.');
        }

        return redirect()->route('admin.sitemap.index')->with('success', $message);
    }

    /**
     * Generate default static pages
     */
    public function generateDefaults()
    {
        $defaults = [
            ['url' => '/', 'name' => 'Home', 'type' => 'static', 'priority' => 1.0, 'changefreq' => 'daily'],
            ['url' => '/about', 'name' => 'About', 'type' => 'static', 'priority' => 0.8, 'changefreq' => 'monthly'],
            ['url' => '/services', 'name' => 'Services', 'type' => 'static', 'priority' => 0.8, 'changefreq' => 'monthly'],
            ['url' => '/portfolio', 'name' => 'Portfolio', 'type' => 'static', 'priority' => 0.8, 'changefreq' => 'weekly'],
            ['url' => '/contact', 'name' => 'Contact', 'type' => 'static', 'priority' => 0.6, 'changefreq' => 'yearly'],
            ['url' => '/tools', 'name' => 'Tools', 'type' => 'static', 'priority' => 0.7, 'changefreq' => 'weekly'],
            ['url' => '/prompts', 'name' => 'Prompt Library', 'type' => 'static', 'priority' => 0.6, 'changefreq' => 'weekly'],
            ['url' => '/directory', 'name' => 'Directory', 'type' => 'static', 'priority' => 0.6, 'changefreq' => 'weekly'],
            ['url' => '/jobs', 'name' => 'Jobs', 'type' => 'static', 'priority' => 0.6, 'changefreq' => 'daily'],
            ['url' => '/books', 'name' => 'Books', 'type' => 'static', 'priority' => 0.6, 'changefreq' => 'weekly'],
            ['url' => '/roadmap', 'name' => 'Roadmap', 'type' => 'static', 'priority' => 0.5, 'changefreq' => 'monthly'],
        ];

        $created = 0;
        foreach ($defaults as $item) {
            // Check if URL already exists
            if (!SitemapItem::where('url', $item['url'])->exists()) {
                SitemapItem::create(array_merge($item, [
                    'is_active' => true,
                    'lastmod' => now(),
                ]));
                $created++;
            }
        }

        return redirect()->route('admin.sitemap.index')
            ->with('success', $created . ' default pages added to sitemap!');
    }

    /**
     * Preview the sitemap
     */
    public function preview()
    {
        $sitemapItems = SitemapItem::active()->ordered()->get();
        $urls = [];

        foreach ($sitemapItems as $item) {
            $urls[] = [
                'loc' => $item->full_url,
                'lastmod' => $item->lastmod_formatted,
                'changefreq' => $item->changefreq,
                'priority' => $item->priority,
                'name' => $item->name,
                'type' => $item->type,
            ];
        }

        return view('admin.sitemap.preview', compact('urls'));
    }
}
