<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroSectionFormRequest;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroes = HeroSection::orderBy('order', 'asc')->paginate(10);
        return view('admin.hero.index', compact('heroes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeroSectionFormRequest $request)
    {
        $data = $request->validated();

        // Handle image uploads
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('hero', 'public');
        }

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('hero', 'public');
        }

        HeroSection::create($data);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HeroSection $hero)
    {
        return view('admin.hero.show', compact('hero'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroSection $hero)
    {
        return view('admin.hero.edit', compact('hero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeroSectionFormRequest $request, HeroSection $hero)
    {
        $data = $request->validated();

        // Handle image uploads and delete old images
        if ($request->hasFile('background_image')) {
            if ($hero->background_image) {
                Storage::disk('public')->delete($hero->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('hero', 'public');
        }

        if ($request->hasFile('profile_image')) {
            if ($hero->profile_image) {
                Storage::disk('public')->delete($hero->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroSection $hero)
    {
        // Delete associated images
        if ($hero->background_image) {
            Storage::disk('public')->delete($hero->background_image);
        }
        if ($hero->profile_image) {
            Storage::disk('public')->delete($hero->profile_image);
        }

        $hero->delete();

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(HeroSection $hero)
    {
        $hero->is_active = !$hero->is_active;
        $hero->save();

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section status updated successfully.');
    }
}
