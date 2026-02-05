<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobCategory;
use App\Services\JobParsingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    protected $parser;

    public function __construct(JobParsingService $parser)
    {
        $this->parser = $parser;
    }

    public function index()
    {
        $jobs = Job::with('category')->latest()->paginate(20);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = JobCategory::all();
        return view('admin.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:50',
            'experience_level' => 'nullable|string|max:50',
            'salary_range' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'job_details' => 'nullable|string',
            'category_id' => 'required|exists:job_categories,id',
            'status' => 'required|in:draft,active,inactive,expired',
            'source_url' => 'nullable|url',
            'job_data' => 'nullable|array',
            'metadata' => 'nullable|array',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['job_title'] . '-' . $validated['company_name'] . '-' . Str::random(6));
        $validated['created_by'] = auth()->id();
        $validated['posted_date'] = now();

        Job::create($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully.');
    }

    public function show(Job $job)
    {
        return view('admin.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $categories = JobCategory::all();
        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|max:50',
            'experience_level' => 'nullable|string|max:50',
            'salary_range' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'job_details' => 'nullable|string',
            'category_id' => 'required|exists:job_categories,id',
            'status' => 'required|in:draft,active,inactive,expired',
            'source_url' => 'nullable|url',
            'job_data' => 'nullable|array',
            'metadata' => 'nullable|array',
            'is_featured' => 'boolean',
        ]);

        if ($validated['job_title'] !== $job->job_title || $validated['company_name'] !== $job->company_name) {
            $validated['slug'] = Str::slug($validated['job_title'] . '-' . $validated['company_name'] . '-' . Str::random(6));
        }

        $job->update($validated);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function parse(Request $request)
    {
        $request->validate(['description' => 'required|string|min:10']);

        try {
            $data = $this->parser->parse($request->input('description'));
            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
