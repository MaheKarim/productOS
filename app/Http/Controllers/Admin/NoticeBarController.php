<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoticeBar;
use Illuminate\Http\Request;

class NoticeBarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = NoticeBar::latest()->paginate(10);
        return view('admin.notice-bars.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notice-bars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:60',
            'message' => 'required|string',
            'dismissible' => 'boolean',
            'expires_at' => 'nullable|date',
            'audience' => 'required|in:all,free,pro',
            'is_active' => 'boolean',
        ]);

        // Checkbox handling
        $validated['dismissible'] = $request->has('dismissible');
        $validated['is_active'] = $request->has('is_active');

        NoticeBar::create($validated);

        return redirect()->route('admin.notice-bars.index')
            ->with('success', 'Notice created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NoticeBar $noticeBar)
    {
        return view('admin.notice-bars.edit', compact('noticeBar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NoticeBar $noticeBar)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:60',
            'message' => 'required|string',
            'dismissible' => 'boolean',
            'expires_at' => 'nullable|date',
            'audience' => 'required|in:all,free,pro',
            'is_active' => 'boolean',
        ]);

        // Checkbox handling
        $validated['dismissible'] = $request->has('dismissible');
        $validated['is_active'] = $request->has('is_active');

        $noticeBar->update($validated);

        return redirect()->route('admin.notice-bars.index')
            ->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NoticeBar $noticeBar)
    {
        $noticeBar->delete();

        return redirect()->route('admin.notice-bars.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
