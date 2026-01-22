<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialFormRequest;
use App\Models\Testimonial;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::with('project')->orderBy('order', 'asc')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::active()->ordered()->get();
        return view('admin.testimonials.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialFormRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('avatar_image')) {
            $data['avatar_image'] = $request->file('avatar_image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $testimonial->load('project');
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $projects = Project::active()->ordered()->get();
        return view('admin.testimonials.edit', compact('testimonial', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialFormRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();

        // Handle image upload and delete old image
        if ($request->hasFile('avatar_image')) {
            if ($testimonial->avatar_image) {
                Storage::disk('public')->delete($testimonial->avatar_image);
            }
            $data['avatar_image'] = $request->file('avatar_image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete associated image
        if ($testimonial->avatar_image) {
            Storage::disk('public')->delete($testimonial->avatar_image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(Testimonial $testimonial)
    {
        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->save();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial status updated successfully.');
    }
}
