<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiProvider;
use App\Models\AiRequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiHealthController extends Controller
{
    /**
     * Get database-specific date format for grouping by hour.
     */
    protected function getHourDateFormat(): string
    {
        $driver = DB::connection()->getDriverName();

        return match ($driver) {
            'sqlite' => "strftime('%Y-%m-%d %H:00:00', created_at)",
            'mysql', 'mariadb' => "DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00')",
            'pgsql' => "TO_CHAR(created_at, 'YYYY-MM-DD HH24:00:00')",
            'sqlsrv' => "FORMAT(created_at, 'yyyy-MM-dd HH:00:00')",
            default => "DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00')",
        };
    }

    /**
     * Display the AI provider health dashboard.
     */
    public function index()
    {
        $providers = AiProvider::with('models')->get();

        // Summary statistics for last 24 hours
        $stats = $this->getSummaryStats(24);

        // Provider-specific stats
        $providerStats = $this->getProviderStats();

        // Requests by model
        $modelStats = $this->getModelStats();

        return view('admin.ai-providers.health-dashboard', [
            'providers' => $providers,
            'stats' => $stats,
            'providerStats' => $providerStats,
            'modelStats' => $modelStats,
        ]);
    }

    /**
     * Get chart data for AJAX updates.
     */
    public function chartData(Request $request)
    {
        $hours = $request->get('hours', 24);
        $providerId = $request->get('provider_id');

        return response()->json([
            'responseTimeData' => $this->getResponseTimeChartData($hours, $providerId),
            'requestVolumeData' => $this->getRequestVolumeChartData($hours, $providerId),
            'errorRateData' => $this->getErrorRateChartData($hours),
            'costTrendData' => $this->getCostTrendChartData($hours, $providerId),
        ]);
    }

    /**
     * Get summary statistics for the dashboard cards.
     */
    protected function getSummaryStats(int $hours = 24): array
    {
        $since = now()->subHours($hours);

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
     * Get per-provider statistics.
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
                DB::raw('COUNT(*) as total_requests'),
                DB::raw('SUM(CASE WHEN ai_request_logs.status = \'error\' THEN 1 ELSE 0 END) as error_count'),
                DB::raw('AVG(ai_request_logs.response_time_ms) as avg_response_time'),
                DB::raw('SUM(ai_request_logs.cost) as total_cost'),
                DB::raw('SUM(COALESCE(ai_request_logs.input_tokens, 0) + COALESCE(ai_request_logs.output_tokens, 0)) as total_tokens')
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
     * Get per-model statistics.
     */
    protected function getModelStats(): array
    {
        $since = now()->subHours(24);

        return AiRequestLog::where('ai_request_logs.created_at', '>=', $since)
            ->join('ai_providers', 'ai_request_logs.ai_provider_id', '=', 'ai_providers.id')
            ->select(
                'ai_providers.name as provider_name',
                'ai_request_logs.model',
                DB::raw('COUNT(*) as request_count'),
                DB::raw('AVG(ai_request_logs.response_time_ms) as avg_response_time'),
                DB::raw('SUM(COALESCE(ai_request_logs.input_tokens, 0) + COALESCE(ai_request_logs.output_tokens, 0)) as total_tokens'),
                DB::raw('SUM(ai_request_logs.cost) as total_cost')
            )
            ->groupBy('ai_providers.name', 'ai_request_logs.model')
            ->orderByDesc('request_count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->avg_response_time = round($item->avg_response_time ?? 0);
                $item->total_cost = round($item->total_cost ?? 0, 4);
                return $item;
            })
            ->toArray();
    }

    /**
     * Get response time chart data.
     */
    protected function getResponseTimeChartData(int $hours, ?int $providerId = null): array
    {
        $since = now()->subHours($hours);

        $query = AiRequestLog::where('created_at', '>=', $since)
            ->where('status', 'success');

        if ($providerId) {
            $query->where('ai_provider_id', $providerId);
        }

        $data = $query->select(
            DB::raw($this->getHourDateFormat() . ' as hour'),
            'ai_provider_id',
            DB::raw('AVG(response_time_ms) as avg_time')
        )
            ->groupBy('hour', 'ai_provider_id')
            ->orderBy('hour')
            ->get();

        // Group by provider
        $providers = AiProvider::pluck('name', 'id')->toArray();
        $chartData = [];

        foreach ($data as $item) {
            $providerName = $providers[$item->ai_provider_id] ?? 'Unknown';
            if (!isset($chartData[$providerName])) {
                $chartData[$providerName] = [];
            }
            $chartData[$providerName][] = [
                'x' => $item->hour,
                'y' => round($item->avg_time),
            ];
        }

        return $chartData;
    }

    /**
     * Get request volume chart data.
     */
    protected function getRequestVolumeChartData(int $hours, ?int $providerId = null): array
    {
        $since = now()->subHours($hours);

        $query = AiRequestLog::where('created_at', '>=', $since);

        if ($providerId) {
            $query->where('ai_provider_id', $providerId);
        }

        $data = $query->select(
            DB::raw($this->getHourDateFormat() . ' as hour'),
            'ai_provider_id',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('hour', 'ai_provider_id')
            ->orderBy('hour')
            ->get();

        $providers = AiProvider::pluck('name', 'id')->toArray();
        $chartData = [];

        foreach ($data as $item) {
            $providerName = $providers[$item->ai_provider_id] ?? 'Unknown';
            if (!isset($chartData[$providerName])) {
                $chartData[$providerName] = [];
            }
            $chartData[$providerName][] = [
                'x' => $item->hour,
                'y' => $item->count,
            ];
        }

        return $chartData;
    }

    /**
     * Get error rate chart data per provider.
     */
    protected function getErrorRateChartData(int $hours): array
    {
        $since = now()->subHours($hours);

        return AiRequestLog::where('ai_request_logs.created_at', '>=', $since)
            ->join('ai_providers', 'ai_request_logs.ai_provider_id', '=', 'ai_providers.id')
            ->select(
                'ai_providers.name',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN ai_request_logs.status = \'error\' THEN 1 ELSE 0 END) as errors')
            )
            ->groupBy('ai_providers.name')
            ->get()
            ->map(function ($item) {
                return [
                    'provider' => $item->name,
                    'error_rate' => $item->total > 0 ? round(($item->errors / $item->total) * 100, 1) : 0,
                    'success_rate' => $item->total > 0 ? round((($item->total - $item->errors) / $item->total) * 100, 1) : 100,
                ];
            })
            ->toArray();
    }

    /**
     * Get cost trend chart data.
     */
    protected function getCostTrendChartData(int $hours, ?int $providerId = null): array
    {
        $since = now()->subHours($hours);

        $query = AiRequestLog::where('created_at', '>=', $since);

        if ($providerId) {
            $query->where('ai_provider_id', $providerId);
        }

        $data = $query->select(
            DB::raw($this->getHourDateFormat() . ' as hour'),
            'ai_provider_id',
            DB::raw('SUM(cost) as total_cost')
        )
            ->groupBy('hour', 'ai_provider_id')
            ->orderBy('hour')
            ->get();

        $providers = AiProvider::pluck('name', 'id')->toArray();
        $chartData = [];

        foreach ($data as $item) {
            $providerName = $providers[$item->ai_provider_id] ?? 'Unknown';
            if (!isset($chartData[$providerName])) {
                $chartData[$providerName] = [];
            }
            $chartData[$providerName][] = [
                'x' => $item->hour,
                'y' => round($item->total_cost, 4),
            ];
        }

        return $chartData;
    }
}
