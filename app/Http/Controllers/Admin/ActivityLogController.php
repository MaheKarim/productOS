<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureUsage;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the feature usage logs with analytics.
     */
    public function index(Request $request)
    {
        $query = FeatureUsage::with(['user', 'feature'])->latest();

        // 1. Filtering
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('feature')) {
            $query->where('feature_key', $request->feature);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Analytics (Calculated on filtered data for strict analysis, or overall?)
        // Usually cards show overall or filtered depending on UX. Let's do filtered stats.
        // Cloning query for aggregations to avoid modifying the main pagination query
        $statsQuery = clone $query;

        $stats = [
            'total_usages' => $statsQuery->count(),
            'total_credits' => $statsQuery->sum('credits_deducted'),
            'success_count' => (clone $statsQuery)->where('status', 'success')->count(),
            'failed_count' => (clone $statsQuery)->where('status', '!=', 'success')->count(),
        ];

        $logs = $query->paginate(20)->withQueryString();

        // Data for filters
        $features = \App\Models\Feature::all();
        // Users for filter dropdown might be too many, so maybe assume search is enough or recent users

        return view('admin.activity-logs.index', compact('logs', 'stats', 'features'));
    }
}
