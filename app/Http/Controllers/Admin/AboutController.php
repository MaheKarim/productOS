<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutSectionFormRequest;
use App\Models\AboutSection;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = AboutSection::orderBy('order', 'asc')->paginate(10);
        return view('admin.about.index', compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AboutSectionFormRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        AboutSection::create($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutSection $about)
    {
        return view('admin.about.show', compact('about'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutSection $about)
    {
        return view('admin.about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AboutSectionFormRequest $request, AboutSection $about)
    {
        $data = $request->validated();

        // Handle image upload and delete old image
        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutSection $about)
    {
        // Delete associated image
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'About section deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(AboutSection $about)
    {
        $about->is_active = !$about->is_active;
        $about->save();

        return redirect()->route('admin.about.index')
            ->with('success', 'About section status updated successfully.');
    }
}
