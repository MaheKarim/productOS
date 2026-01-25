<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

class DashboardController extends Controller
{
    public function index()
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

        return view('admin.dashboard', compact('stats', 'aiStats', 'providerStats'));
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
}
