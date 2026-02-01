<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::all();
        return view('admin.features.index', compact('features'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
            'credit_cost' => 'required|integer|min:0',
        ]);

        // Handle checkbox logic (if unchecked, it's not sent in request)
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : false;
        // Optimization: If form sends is_active as 0/1 explicitly (hidden input pattern), use that. 
        // But for toggles usually we handle presence. 
        // Let's rely on the hidden input approach used in form.blade.php usually, or just boolean helper

        // Actually, for toggle endpoints usually we might use a dedicated 'toggle' method, 
        // but here we are doing a full update.
        // Let's assume the form sends 'is_active' checkbox.

        $feature->update([
            'is_active' => $request->boolean('is_active'),
            'credit_cost' => $request->integer('credit_cost'),
        ]);

        return redirect()->back()->with('success', 'Feature updated successfully.');
    }
}
