<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('category')->active()->notExpired();

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%"); // Just in case
            });
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('job_type', $request->input('type'));
        }

        $jobs = $query->latest('is_featured')->latest()->paginate(12);

        $categories = JobCategory::withCount([
            'jobs' => function ($q) {
                $q->active()->notExpired();
            }
        ])->get();

        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function show($slug)
    {
        $job = Job::with('category', 'creator')->where('slug', $slug)->active()->notExpired()->firstOrFail();

        // Increment views
        $job->increment('views_count');

        // Related jobs
        $relatedJobs = Job::active()
            ->notExpired()
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->limit(3)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }
}

