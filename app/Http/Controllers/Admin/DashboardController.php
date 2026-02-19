<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\HeroSection;
use App\Models\AboutSection;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\FooterSettings;
use App\Models\DirectoryItem;
use App\Models\DirectoryClick;
use App\Models\AiRequestLog;
use App\Models\AiProvider;
use App\Models\User;
use App\Models\FeatureUsage;
use App\Models\Feature;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            // CMS Stats
            'hero' => HeroSection::count(),
            'about' => AboutSection::count(),
            'services' => Service::count(),
            'projects' => Project::count(),
            'testimonials' => Testimonial::count(),
            'footer' => FooterSettings::count(),

            // Directory Stats
            'directory_items' => DirectoryItem::count(),
            'directory_pending' => DirectoryItem::where('verification_status', 'pending')->count(),
            'directory_clicks' => DirectoryClick::whereMonth('clicked_at', now()->month)->count(),
            'directory_featured' => DirectoryItem::where('is_featured', true)->count(),
        ];

        // AI Health Stats (last 24 hours)
        $aiStats = $this->getAiHealthStats();

        // AI Provider Stats by provider
        $providerStats = $this->getProviderStats();

        // Hero Metrics
        $heroStats = $this->getHeroStats();

        // Groq Rate Limits Analytics
        $selectedModel = $request->get('model', 'all');
        $groqRateLimits = $this->getGroqRateLimits($selectedModel);

        // Dashboard Analytics Data
        $analyticsData = $this->getInitialAnalyticsData();

        return view('admin.dashboard', compact('stats', 'aiStats', 'providerStats', 'groqRateLimits', 'heroStats', 'analyticsData'));
    }

    /**
     * Get initial analytics data for dashboard
     */
    protected function getInitialAnalyticsData(): array
    {
        return [
            'current_year' => now()->year,
            'previous_year' => now()->year - 1,
            'available_years' => [now()->year, now()->year - 1, now()->year - 2],
        ];
    }

    /**
     * Get Hero metrics for the dashboard (24h vs previous 24h).
     */
    protected function getHeroStats(): array
    {
        $now = now();
        $last24h = $now->copy()->subHours(24);
        $prev24h = $now->copy()->subHours(48);

        // 1. Total API Requests
        $currentRequests = AiRequestLog::where('created_at', '>=', $last24h)->count();
        $prevRequests = AiRequestLog::whereBetween('created_at', [$prev24h, $last24h])->count();

        $requestsChange = 0;
        if ($prevRequests > 0) {
            $requestsChange = round((($currentRequests - $prevRequests) / $prevRequests) * 100, 1);
        } else {
            $requestsChange = $currentRequests > 0 ? 100 : 0;
        }

        // 2. Active Users (Mock for now, as we don't have detailed user activity logs linked yet)
        // In a real app, calculate DAU from activity logs.
        $currentUsers = \App\Models\User::count(); // Fallback to total users
        $usersChange = 12.5; // Mock growth

        // 3. Total Cost
        $currentCost = AiRequestLog::where('created_at', '>=', $last24h)->sum('cost') ?? 0;
        $prevCost = AiRequestLog::whereBetween('created_at', [$prev24h, $last24h])->sum('cost') ?? 0;

        $costChange = 0;
        if ($prevCost > 0) {
            $costChange = round((($currentCost - $prevCost) / $prevCost) * 100, 1);
        } else {
            $costChange = $currentCost > 0 ? 100 : 0;
        }

        // 4. Avg Latency
        $currentLatency = AiRequestLog::where('created_at', '>=', $last24h)->avg('response_time_ms') ?? 0;
        $prevLatency = AiRequestLog::whereBetween('created_at', [$prev24h, $last24h])->avg('response_time_ms') ?? 0;

        $latencyChange = 0;
        if ($prevLatency > 0) {
            $latencyChange = round((($currentLatency - $prevLatency) / $prevLatency) * 100, 1);
        }

        return [
            'requests' => [
                'value' => $currentRequests,
                'change' => $requestsChange,
                'trend' => $requestsChange >= 0 ? 'up' : 'down'
            ],
            'users' => [
                'value' => $currentUsers,
                'change' => $usersChange,
                'trend' => 'up'
            ],
            'cost' => [
                'value' => round($currentCost, 3),
                'change' => $costChange,
                'trend' => $costChange <= 0 ? 'good' : 'bad' // Cost going down is usually good, but context matters. Let's assume up is "spending more"
            ],
            'latency' => [
                'value' => round($currentLatency),
                'change' => $latencyChange,
                'trend' => $latencyChange <= 0 ? 'good' : 'bad'
            ]
        ];
    }
    protected function getGroqRateLimits(string $selectedModel = 'all'): array
    {
        $groq = AiProvider::where('slug', 'groq')->first();

        if (!$groq) {
            return [
                'available' => false,
                'message' => 'Groq provider not configured',
                'selectedModel' => $selectedModel,
                'availableModels' => [],
                'usage' => [
                    'rpm' => ['current' => 0, 'limit' => 0, 'percent' => 0],
                    'tpm' => ['current' => 0, 'limit' => 0, 'percent' => 0],
                    'rpd' => ['current' => 0, 'limit' => 0, 'percent' => 0],
                    'tpd' => ['current' => 0, 'limit' => 0, 'percent' => 0],
                ],
                'recommendations' => [],
                'hourlyTrend' => [],
                'lastUpdated' => now()->format('H:i:s'),
            ];
        }

        // Get all models used for Groq to populate selector
        $availableModels = AiRequestLog::where('ai_provider_id', $groq->id)
            ->distinct()
            ->pluck('model')
            ->filter()
            ->values()
            ->toArray();

        // Default rate limits for Groq Free tier (Global)
        $globalLimits = [
            'rpm' => $groq->settings['rate_limits']['rpm'] ?? 30,
            'tpm' => $groq->settings['rate_limits']['tpm'] ?? 30000,
            'rpd' => $groq->settings['rate_limits']['rpd'] ?? 1000,
            'tpd' => $groq->settings['rate_limits']['tpd'] ?? 500000,
        ];

        // Specific model limits (Example for Groq Free Tier)
        $modelLimits = [
            'llama-3.3-70b-versatile' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
            'llama-3.1-70b-versatile' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
            'llama-3.1-8b-instant' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
            'mixtral-8x7b-32768' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
            'gemma2-9b-it' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
            'llava-v1.5-7b-4096-preview' => ['rpm' => 30, 'tpm' => 30000, 'rpd' => 1000, 'tpd' => 500000],
        ];

        // Use selected model limits or global
        $currentLimits = ($selectedModel !== 'all' && isset($modelLimits[$selectedModel]))
            ? $modelLimits[$selectedModel]
            : $globalLimits;

        $now = now();
        $minuteAgo = $now->copy()->subMinute();
        $dayStart = $now->copy()->startOfDay();

        // Base query
        $query = AiRequestLog::where('ai_provider_id', $groq->id);

        if ($selectedModel !== 'all') {
            $query->where('model', $selectedModel);
        }

        // Requests per minute
        $rpm = (clone $query)->where('created_at', '>=', $minuteAgo)->count();

        // Tokens per minute
        $tpm = (clone $query)->where('created_at', '>=', $minuteAgo)
            ->selectRaw('SUM(COALESCE(input_tokens, 0) + COALESCE(output_tokens, 0)) as total')
            ->value('total') ?? 0;

        // Requests per day
        $rpd = (clone $query)->where('created_at', '>=', $dayStart)->count();

        // Tokens per day
        $tpd = (clone $query)->where('created_at', '>=', $dayStart)
            ->selectRaw('SUM(COALESCE(input_tokens, 0) + COALESCE(output_tokens, 0)) as total')
            ->value('total') ?? 0;

        // Calculate percentages
        $usage = [
            'rpm' => ['current' => $rpm, 'limit' => $currentLimits['rpm'], 'percent' => min(100, round(($rpm / max($currentLimits['rpm'], 1)) * 100))],
            'tpm' => ['current' => $tpm, 'limit' => $currentLimits['tpm'], 'percent' => min(100, round(($tpm / max($currentLimits['tpm'], 1)) * 100))],
            'rpd' => ['current' => $rpd, 'limit' => $currentLimits['rpd'], 'percent' => min(100, round(($rpd / max($currentLimits['rpd'], 1)) * 100))],
            'tpd' => ['current' => $tpd, 'limit' => $currentLimits['tpd'], 'percent' => min(100, round(($tpd / max($currentLimits['tpd'], 1)) * 100))],
        ];

        // Generate recommendations
        $recommendations = [];
        if ($usage['rpm']['percent'] > 70) {
            $recommendations[] = ['type' => 'warning', 'message' => 'RPM usage is high (' . $usage['rpm']['percent'] . '%). Consider batching requests.'];
        }
        if ($usage['tpm']['percent'] > 70) {
            $recommendations[] = ['type' => 'warning', 'message' => 'Token usage per minute is high. Consider using smaller context windows.'];
        }
        if ($usage['rpd']['percent'] > 80) {
            $recommendations[] = ['type' => 'danger', 'message' => 'Daily request limit nearly reached. Upgrade to Developer plan for higher limits.'];
        }
        if ($usage['tpd']['percent'] > 80) {
            $recommendations[] = ['type' => 'danger', 'message' => 'Daily token limit nearly reached. Consider upgrading your plan.'];
        }
        if (empty($recommendations)) {
            $recommendations[] = ['type' => 'success', 'message' => 'All rate limits are within healthy ranges.'];
        }

        // Hourly trend data (last 24 hours)
        $hourlyTrend = AiRequestLog::where('ai_provider_id', $groq->id)
            ->where('created_at', '>=', $now->copy()->subHours(24))
            ->selectRaw('DATE_FORMAT(created_at, "%H:00") as hour, COUNT(*) as requests, SUM(COALESCE(input_tokens, 0) + COALESCE(output_tokens, 0)) as tokens')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour')
            ->toArray();

        return [
            'available' => true,
            'provider' => $groq,
            'usage' => $usage,
            'recommendations' => $recommendations,
            'hourlyTrend' => $hourlyTrend,
            'lastUpdated' => $now->format('H:i:s'),
            'availableModels' => $availableModels,
            'selectedModel' => $selectedModel,
        ];
    }


    /**
     * Get AI health statistics for last 24 hours.
     */
    protected function getAiHealthStats(): array
    {
        $since = now()->subHours(24);

        $totalRequests = AiRequestLog::where('created_at', '>=', $since)->count();
        $successfulRequests = AiRequestLog::where('created_at', '>=', $since)
            ->where('status', 'success')
            ->count();
        $errorCount = $totalRequests - $successfulRequests;

        $avgResponseTime = AiRequestLog::where('created_at', '>=', $since)
            ->avg('response_time_ms') ?? 0;

        $totalCost = AiRequestLog::where('created_at', '>=', $since)
            ->sum('cost') ?? 0;

        $totalTokens = AiRequestLog::where('created_at', '>=', $since)
            ->selectRaw('SUM(COALESCE(input_tokens, 0) + COALESCE(output_tokens, 0)) as total')
            ->value('total') ?? 0;

        return [
            'total_requests' => $totalRequests,
            'successful_requests' => $successfulRequests,
            'error_count' => $errorCount,
            'error_rate' => $totalRequests > 0 ? round(($errorCount / $totalRequests) * 100, 1) : 0,
            'avg_response_time' => round($avgResponseTime),
            'total_cost' => round($totalCost, 4),
            'total_tokens' => $totalTokens,
        ];
    }

    /**
     * Get per-provider statistics for last 24 hours.
     */
    protected function getProviderStats(): array
    {
        $since = now()->subHours(24);

        return AiRequestLog::where('ai_request_logs.created_at', '>=', $since)
            ->join('ai_providers', 'ai_request_logs.ai_provider_id', '=', 'ai_providers.id')
            ->select(
                'ai_providers.id',
                'ai_providers.name',
                'ai_providers.slug',
                \DB::raw('COUNT(*) as total_requests'),
                \DB::raw('SUM(CASE WHEN ai_request_logs.status = \'error\' THEN 1 ELSE 0 END) as error_count'),
                \DB::raw('AVG(ai_request_logs.response_time_ms) as avg_response_time'),
                \DB::raw('SUM(ai_request_logs.cost) as total_cost')
            )
            ->groupBy('ai_providers.id', 'ai_providers.name', 'ai_providers.slug')
            ->get()
            ->map(function ($item) {
                $item->error_rate = $item->total_requests > 0
                    ? round(($item->error_count / $item->total_requests) * 100, 1)
                    : 0;
                $item->avg_response_time = round($item->avg_response_time ?? 0);
                $item->total_cost = round($item->total_cost ?? 0, 4);
                return $item;
            })
            ->toArray();
    }

    /**
     * Get monthly user registration trend data for charts
     */
    public function getUserRegistrationData(Request $request)
    {
        $year = $request->get('year', now()->year);
        $previousYear = $year - 1;

        // Get current year data
        $currentYearData = User::selectRaw('DATE_FORMAT(created_at, "%m") as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Get previous year data for comparison
        $previousYearData = User::selectRaw('DATE_FORMAT(created_at, "%m") as month, COUNT(*) as count')
            ->whereYear('created_at', $previousYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $months = [];
        $currentYearCounts = [];
        $previousYearCounts = [];
        $cumulativeCounts = [];
        $cumulative = 0;

        for ($i = 1; $i <= 12; $i++) {
            $monthLabel = date('M', mktime(0, 0, 0, $i, 1));
            $months[] = $monthLabel;

            // SQLite returns months as "01", "02", etc.
            $key = sprintf('%02d', $i);

            $currentYearCounts[] = $currentYearData[$key] ?? 0;
            $previousYearCounts[] = $previousYearData[$key] ?? 0;
            $cumulative += $currentYearData[$key] ?? 0;
            $cumulativeCounts[] = $cumulative;
        }

        // Find peak registration months
        $maxCurrent = max($currentYearCounts);
        $peakMonths = [];
        foreach ($currentYearCounts as $index => $count) {
            if ($count === $maxCurrent && $count > 0) {
                $peakMonths[] = $months[$index];
            }
        }

        return response()->json([
            'labels' => $months,
            'current_year' => [
                'data' => $currentYearCounts,
                'total' => array_sum($currentYearCounts),
                'peak_months' => $peakMonths,
                'peak_count' => $maxCurrent
            ],
            'previous_year' => [
                'data' => $previousYearCounts,
                'total' => array_sum($previousYearCounts)
            ],
            'cumulative' => $cumulativeCounts,
            'year' => $year,
            'prev_year' => $previousYear
        ]);
    }

    /**
     * Get feature-wise credit consumption data
     */
    public function getCreditConsumptionData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $period = $request->get('period', 'all'); // today, week, month, all

        // Determine date range based on period
        if ($period === 'today') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($period === 'week') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        } elseif ($period === 'month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        }

        // Build query
        $query = FeatureUsage::where('status', 'success');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        // Get feature consumption data
        $featureData = $query->selectRaw('
            feature_key,
            SUM(credits_deducted) as total_credits,
            COUNT(DISTINCT user_id) as user_count,
            COUNT(*) as usage_count
        ')
            ->groupBy('feature_key')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->feature_key => [
                        'total_credits' => (int) $item->total_credits,
                        'user_count' => (int) $item->user_count,
                        'usage_count' => (int) $item->usage_count,
                    ]
                ];
            })->toArray();

        // Get all active features
        $features = Feature::where('is_active', true)->get()->keyBy('key');

        // Prepare data for each feature
        $labels = [];
        $creditsData = [];
        $usersData = [];
        $percentages = [];
        $totalCredits = 0;

        foreach ($features as $feature) {
            $labels[] = $feature->name;
            $credits = $featureData[$feature->key]['total_credits'] ?? 0;
            $users = $featureData[$feature->key]['user_count'] ?? 0;
            $creditsData[] = $credits;
            $usersData[] = $users;
            $totalCredits += $credits;
        }

        // Calculate percentages
        foreach ($creditsData as $credits) {
            $percentages[] = $totalCredits > 0 ? round(($credits / $totalCredits) * 100, 1) : 0;
        }

        // Calculate average credits per user per feature
        $avgCreditsPerUser = [];
        foreach ($creditsData as $index => $credits) {
            $avgCreditsPerUser[] = $usersData[$index] > 0 ? round($credits / $usersData[$index], 2) : 0;
        }

        return response()->json([
            'labels' => $labels,
            'credits' => $creditsData,
            'users' => $usersData,
            'percentages' => $percentages,
            'avg_credits_per_user' => $avgCreditsPerUser,
            'total_credits' => $totalCredits,
            'total_users' => array_sum($usersData),
            'period' => $period
        ]);
    }

    /**
     * Get dashboard summary metrics
     */
    public function getDashboardMetrics()
    {
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        $totalCredits = User::sum('credits');
        $totalUserCount = count(User::all());
        $totalCreditsInCirculation = $totalCredits;
        $avgCredits = $totalUserCount > 0 ? round($totalCredits / $totalUserCount, 2) : 0;

        // Get credit consumption by feature for summary
        $featureConsumption = FeatureUsage::where('status', 'success')
            ->selectRaw('feature_key, SUM(credits_deducted) as total')
            ->groupBy('feature_key')
            ->pluck('total', 'feature_key')
            ->toArray();

        // Get recent credit refill/purchase trends (last 7 days)
        $creditRefills = User::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, SUM(credits) as credits')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'credits' => (int) $item->credits
                ];
            })->toArray();

        // Get feature activation status
        $featureStatus = Feature::select('key', 'name', 'is_active', 'credit_cost')
            ->get()
            ->map(function ($feature) use ($featureConsumption) {
                return [
                    'name' => $feature->name,
                    'is_active' => $feature->is_active,
                    'credit_cost' => $feature->credit_cost,
                    'credits_consumed' => $featureConsumption[$feature->key] ?? 0
                ];
            })->toArray();

        return response()->json([
            'users' => [
                'active' => $activeUsers,
                'inactive' => $inactiveUsers,
                'total' => $activeUsers + $inactiveUsers
            ],
            'credits' => [
                'total_in_circulation' => $totalCreditsInCirculation,
                'average_per_user' => $avgCredits
            ],
            'feature_consumption' => $featureConsumption,
            'credit_refills' => $creditRefills,
            'feature_status' => $featureStatus
        ]);
    }
}
