<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FooterSettingsFormRequest;
use App\Models\FooterSettings;
use Illuminate\Support\Facades\Storage;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footers = FooterSettings::orderBy('order', 'asc')->paginate(10);
        return view('admin.footer.index', compact('footers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FooterSettingsFormRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('logo_image')) {
            $data['logo_image'] = $request->file('logo_image')->store('footer', 'public');
        }

        FooterSettings::create($data);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer settings created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FooterSettings $footer)
    {
        return view('admin.footer.show', compact('footer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FooterSettings $footer)
    {
        return view('admin.footer.edit', compact('footer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FooterSettingsFormRequest $request, FooterSettings $footer)
    {
        $data = $request->validated();

        // Handle image upload and delete old image
        if ($request->hasFile('logo_image')) {
            if ($footer->logo_image) {
                Storage::disk('public')->delete($footer->logo_image);
            }
            $data['logo_image'] = $request->file('logo_image')->store('footer', 'public');
        }

        $footer->update($data);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer settings updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FooterSettings $footer)
    {
        // Delete associated image
        if ($footer->logo_image) {
            Storage::disk('public')->delete($footer->logo_image);
        }

        $footer->delete();

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer settings deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggle(FooterSettings $footer)
    {
        $footer->is_active = !$footer->is_active;
        $footer->save();

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer status updated successfully.');
    }
}
