<?php

namespace App\Http\Controllers;

use App\Models\SitemapItem;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tool;
use App\Models\Page;
use App\Models\DirectoryItem;
use App\Models\Job;
use App\Models\Prompt;
use App\Models\Book;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate the sitemap.xml
     */
    public function index(): Response
    {
        $urls = [];

        // Get manually added sitemap items
        $manualItems = SitemapItem::active()->ordered()->get();
        foreach ($manualItems as $item) {
            $urls[] = [
                'loc' => $item->full_url,
                'lastmod' => $item->lastmod_formatted,
                'changefreq' => $item->changefreq,
                'priority' => $item->priority,
            ];
        }

        // Auto-generate dynamic URLs from models
        $urls = array_merge($urls, $this->getDynamicUrls());

        // Remove duplicates based on URL
        $urls = $this->removeDuplicateUrls($urls);

        $content = view('sitemap.xml', compact('urls'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Get dynamic URLs from various models
     */
    protected function getDynamicUrls(): array
    {
        $urls = [];

        // Projects/Portfolio
        foreach (Project::where('is_active', true)->get() as $project) {
            $urls[] = [
                'loc' => route('portfolio.show', $project->slug),
                'lastmod' => $project->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.7,
            ];
        }

        // Services
        foreach (Service::where('is_active', true)->get() as $service) {
            $urls[] = [
                'loc' => url('/services#' . $service->slug),
                'lastmod' => $service->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.6,
            ];
        }

        // Tools
        foreach (Tool::where('is_active', true)->get() as $tool) {
            if ($tool->category) {
                $urls[] = [
                    'loc' => route('tools.show', ['category' => $tool->category->slug, 'tool' => $tool->slug]),
                    'lastmod' => $tool->updated_at->format('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => 0.6,
                ];
            }
        }

        // Pages
        foreach (Page::where('is_active', true)->get() as $page) {
            $urls[] = [
                'loc' => url($page->slug),
                'lastmod' => $page->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.5,
            ];
        }

        // Directory Items
        foreach (DirectoryItem::where('is_active', true)->get() as $item) {
            $urls[] = [
                'loc' => route('directory.index', ['item' => $item->slug]),
                'lastmod' => $item->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => 0.5,
            ];
        }

        // Jobs
        foreach (Job::where('is_active', true)->get() as $job) {
            $urls[] = [
                'loc' => route('jobs.show', $job->slug),
                'lastmod' => $job->updated_at->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => 0.6,
            ];
        }

        // Prompts
        foreach (Prompt::where('is_active', true)->get() as $prompt) {
            $urls[] = [
                'loc' => route('prompts.show', $prompt->slug),
                'lastmod' => $prompt->updated_at->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => 0.5,
            ];
        }

        // Books
        foreach (Book::where('is_active', true)->get() as $book) {
            $urls[] = [
                'loc' => route('books.show', $book->slug),
                'lastmod' => $book->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => 0.5,
            ];
        }

        return $urls;
    }

    /**
     * Remove duplicate URLs keeping the one with highest priority
     */
    protected function removeDuplicateUrls(array $urls): array
    {
        $unique = [];

        foreach ($urls as $url) {
            $loc = rtrim($url['loc'], '/');
            if (!isset($unique[$loc]) || $url['priority'] > $unique[$loc]['priority']) {
                $unique[$loc] = $url;
            }
        }

        return array_values($unique);
    }
}
