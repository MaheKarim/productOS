<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportSectionController extends Controller
{
    /**
     * Display the support section settings.
     */
    public function index()
    {
        $support = SupportSection::first() ?? new SupportSection([
            'headline' => 'Enjoying These Tools?',
            'body_text' => "If these resources save you time or help you succeed, consider supporting my work!\nEvery cup of coffee fuels more tools, updates, and free resources for Product Managers.",
            'show_progress_bar' => true,
            'progress_value' => 75,
            'progress_goal' => 100,
            'progress_label' => 'Support Goal',
            'is_active' => true,
        ]);

        return view('admin.support.index', compact('support'));
    }

    /**
     * Store or update the support section.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:255',
            'body_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'buymeacoffee_url' => 'nullable|url|max:255',
            'show_progress_bar' => 'boolean',
            'progress_value' => 'nullable|integer|min:0',
            'progress_goal' => 'nullable|integer|min:1',
            'progress_label' => 'nullable|string|max:100',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ]);

        $support = SupportSection::first() ?? new SupportSection();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($support->image_path && Storage::disk('public')->exists($support->image_path)) {
                Storage::disk('public')->delete($support->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('support', 'public');
        }

        // Handle checkbox values
        $validated['show_progress_bar'] = $request->has('show_progress_bar');
        $validated['is_active'] = $request->has('is_active');

        // Remove 'image' from validated data (we use 'image_path' instead)
        unset($validated['image']);

        $support->fill($validated);
        $support->save();

        return redirect()->route('admin.support-section.index')
            ->with('success', 'Support section updated successfully!');
    }

    /**
     * Toggle the active status.
     */
    public function toggle(SupportSection $support)
    {
        $support->is_active = !$support->is_active;
        $support->save();

        return back()->with('success', 'Support section visibility updated.');
    }

    /**
     * Remove the image.
     */
    public function removeImage()
    {
        $support = SupportSection::first();

        if ($support && $support->image_path) {
            if (Storage::disk('public')->exists($support->image_path)) {
                Storage::disk('public')->delete($support->image_path);
            }
            $support->image_path = null;
            $support->save();
        }

        return back()->with('success', 'Image removed successfully.');
    }
}
