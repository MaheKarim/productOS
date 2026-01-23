<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DirectoryItem;
use App\Models\DirectoryClick;
use App\Models\DirectoryCategory;
// Request is already imported in clean controller stub usually, but let's check.
// Actually, in the previous replace I added `use Illuminate\Http\Request` which caused conflict if it was already there.
// I will just remove the extra import and implement index.

class DirectoryController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_items' => DirectoryItem::count(),
            'pending' => DirectoryItem::where('verification_status', 'pending')->count(),
            'featured' => DirectoryItem::where('is_featured', true)->count(),
            'clicks_month' => DirectoryClick::whereMonth('clicked_at', now()->month)->count(),
        ];

        $byType = DirectoryItem::selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $recentItems = DirectoryItem::latest()->take(5)->get();
        $recentClicks = DirectoryClick::with('directoryItem')->latest('clicked_at')->take(5)->get();

        return view('admin.directory.dashboard', compact('stats', 'byType', 'recentItems', 'recentClicks'));
    }

    public function index(Request $request)
    {
        $query = DirectoryItem::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(20)->withQueryString();

        return view('admin.directory.index', compact('items'));
    }
    public function create()
    {
        $categories = DirectoryCategory::where('is_active', true)->orderBy('type')->orderBy('name')->get();
        return view('admin.directory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'category' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['uuid'] = (string) \Illuminate\Support\Str::uuid();
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        $data['submitted_by'] = auth()->id();
        $data['verification_status'] = 'verified';

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('directory/logos', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_hiring'] = $request->has('is_hiring');
        $data['bd_available'] = $request->has('bd_available');
        $data['certificate'] = $request->has('certificate');

        DirectoryItem::create($data);

        return redirect()->route('admin.directory.index')->with('success', 'Item created successfully.');
    }

    public function edit($id)
    {
        $item = DirectoryItem::findOrFail($id);
        $categories = DirectoryCategory::where('is_active', true)->orderBy('type')->orderBy('name')->get();
        return view('admin.directory.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = DirectoryItem::findOrFail($id);

        $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'category' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url',
        ]);

        $data = $request->all();

        if ($request->name !== $item->name) {
            $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        }

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('directory/logos', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_hiring'] = $request->has('is_hiring');
        $data['bd_available'] = $request->has('bd_available');
        $data['certificate'] = $request->has('certificate');

        $item->update($data);

        return redirect()->route('admin.directory.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        DirectoryItem::findOrFail($id)->delete();
        return redirect()->route('admin.directory.index')->with('success', 'Item deleted successfully.');
    }

    public function toggleActive($id)
    {
        $item = DirectoryItem::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        return back()->with('success', 'Status updated.');
    }

    public function verify($id)
    {
        $item = DirectoryItem::findOrFail($id);
        $item->update(['verification_status' => 'verified']);
        return back()->with('success', 'Item verified.');
    }
}
