<?php

namespace App\Services\YouTube;

use Illuminate\Support\Facades\Http;
use Youble\YouTubeTransApi\YouTubeTranscriptApi;
use Exception;
use DateInterval;

class YouTubeService
{
    protected $apiKey;
    protected $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    public function getVideoId(string $url): ?string
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function fetchMetadata(string $videoId): array
    {
        if (!$this->apiKey) {
            throw new Exception("YouTube API Key is not configured.");
        }

        $response = Http::get("{$this->baseUrl}/videos", [
            'key' => $this->apiKey,
            'id' => $videoId,
            'part' => 'snippet,contentDetails,statistics',
        ]);

        if (!$response->successful()) {
            throw new Exception("YouTube API Error: " . $response->body());
        }

        $data = $response->json();
        if (empty($data['items'])) {
            throw new Exception("Video not found.");
        }

        $item = $data['items'][0];
        $snippet = $item['snippet'];
        $statistics = $item['statistics'] ?? [];
        $contentDetails = $item['contentDetails'];

        return [
            'video_id_str' => $videoId,
            'title' => $snippet['title'],
            'channel_name' => $snippet['channelTitle'],
            'channel_id' => $snippet['channelId'],
            'channel_logo' => null, // Requires separate channel API call if needed, skipping for now to save quota
            'thumbnail_url' => $this->getBestThumbnail($snippet['thumbnails']),
            'upload_date' => $snippet['publishedAt'],
            'duration' => $this->convertDuration($contentDetails['duration']),
            'view_count' => $statistics['viewCount'] ?? 0,
            'raw' => $item,
        ];
    }

    public function fetchChannelLogo(string $channelId): ?string
    {
        if (!$this->apiKey)
            return null;

        $response = Http::get("{$this->baseUrl}/channels", [
            'key' => $this->apiKey,
            'id' => $channelId,
            'part' => 'snippet',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (!empty($data['items'])) {
                return $data['items'][0]['snippet']['thumbnails']['default']['url'] ?? null;
            }
        }
        return null;
    }

    public function fetchTranscript(string $videoId): ?string
    {
        try {
            // Use the new TranscriptApiService
            $service = app(TranscriptApiService::class);
            return $service->getTranscript($videoId);
        } catch (\Exception $e) {
            \Log::warning("New Transcript API failed for video {$videoId}: " . $e->getMessage());
            
            // Fallback to old logic or rethrow
            // For now, let's rethrow to ensure we use the configured API key and don't silently fail back to the old library which might not work.
            throw $e;
        }
    }

    protected function getBestThumbnail(array $thumbnails): string
    {
        if (isset($thumbnails['maxres']))
            return $thumbnails['maxres']['url'];
        if (isset($thumbnails['standard']))
            return $thumbnails['standard']['url'];
        if (isset($thumbnails['high']))
            return $thumbnails['high']['url'];
        if (isset($thumbnails['medium']))
            return $thumbnails['medium']['url'];
        return $thumbnails['default']['url'] ?? '';
    }

    protected function convertDuration(string $youtubeDuration): string
    {
        try {
            $interval = new DateInterval($youtubeDuration);
            return $interval->format('%H:%I:%S');
        } catch (Exception $e) {
            return $youtubeDuration;
        }
    }
}
