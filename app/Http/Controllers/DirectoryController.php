<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DirectoryCategory;
use App\Models\DirectoryItem;
use App\Models\DirectoryClick;
// use Illuminate\Http\Request; // Already imported

class DirectoryController extends Controller
{
    public function index()
    {
        $categories = DirectoryCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        $featuredItems = DirectoryItem::where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('directory.index', compact('categories', 'featuredItems'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $results = DirectoryItem::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('tagline', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhereJsonContains('tags', $query);
            })
            ->take(10)
            ->get(['uuid', 'name', 'slug', 'type', 'logo_path', 'category', 'tagline']);

        return response()->json($results);
    }

    public function trackClick($uuid, Request $request)
    {
        $item = DirectoryItem::where('uuid', $uuid)->firstOrFail();

        $item->increment('click_count');

        DirectoryClick::create([
            'directory_item_id' => $item->id,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'clicked_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    // Category Pages
    private function categoryView($type, $title)
    {
        return view('directory.category', [
            'type' => $type,
            'title' => $title,
            'categories' => DirectoryCategory::where('type', $type)->where('is_active', true)->get()
        ]);
    }

    public function tools()
    {
        return $this->categoryView('tools', 'PM Tools & Software');
    }

    public function learning()
    {
        return $this->categoryView('learning', 'Learning Resources');
    }

    public function companies()
    {
        return $this->categoryView('companies', 'Companies Hiring PMs');
    }

    public function communities()
    {
        return $this->categoryView('communities', 'Communities & Events');
    }

    public function templates()
    {
        return $this->categoryView('templates', 'Templates & Frameworks');
    }
}
