<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::ordered()->paginate(20);
        return view('admin.gifts.index', compact('gifts'));
    }

    public function create()
    {
        return view('admin.gifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'short_description' => 'required|string|max:500',
            'link' => 'required|url|max:500',
            'offer_percentage' => 'required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('gifts/logos', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Gift::create($validated);

        return redirect()->route('admin.gifts.index')->with('success', 'Gift offer created successfully.');
    }

    public function edit(Gift $gift)
    {
        return view('admin.gifts.edit', compact('gift'));
    }

    public function update(Request $request, Gift $gift)
    {
        $validated = $request->validate([
            'website_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'short_description' => 'required|string|max:500',
            'link' => 'required|url|max:500',
            'offer_percentage' => 'required|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($gift->logo && Storage::disk('public')->exists($gift->logo)) {
                Storage::disk('public')->delete($gift->logo);
            }
            $validated['logo'] = $request->file('logo')->store('gifts/logos', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $gift->update($validated);

        return redirect()->route('admin.gifts.index')->with('success', 'Gift offer updated successfully.');
    }

    public function destroy(Gift $gift)
    {
        if ($gift->logo && Storage::disk('public')->exists($gift->logo)) {
            Storage::disk('public')->delete($gift->logo);
        }

        $gift->delete();

        return redirect()->route('admin.gifts.index')->with('success', 'Gift offer deleted successfully.');
    }

    public function toggle(Gift $gift)
    {
        $gift->update(['is_active' => !$gift->is_active]);

        return redirect()->route('admin.gifts.index')->with(
            'success',
            'Gift offer ' . ($gift->is_active ? 'activated' : 'deactivated') . ' successfully.'
        );
    }
}
