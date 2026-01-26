<?php

namespace App\Livewire\Admin;

use App\Models\AiProvider;
use App\Models\Topic;
use App\Models\Video;
use App\Models\SystemPrompt;
use App\Services\YouTube\YouTubeService;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VideoUpload extends Component
{
    public $url;
    public $ai_provider_id;
    public $access_level = 'free';
    public $topic_id;
    public $custom_topic;
    public $system_prompt_id; // For the selector
    public $system_prompt; // Actual content override

    public $metadata = null;
    public $isLoading = false;
    public $error = null;

    protected $rules = [
        'url' => 'required|url',
        'ai_provider_id' => 'required|exists:ai_providers,id',
        'access_level' => 'required|in:free,premium',
    ];

    public function mount()
    {
        // Pre-select default prompt
        $default = SystemPrompt::default()->first();
        if ($default) {
            $this->system_prompt_id = $default->id;
            $this->system_prompt = $default->content;
        }
    }

    public function updatedUrl()
    {
        $this->metadata = null;
        $this->error = null;

        if (empty($this->url)) {
            return;
        }

        try {
            $this->validateOnly('url');
            $this->isLoading = true;

            $service = new YouTubeService();
            $videoId = $service->getVideoId($this->url);

            if (!$videoId) {
                $this->error = "Invalid YouTube URL";
                return;
            }

            // Check if already exists
            if (Video::where('video_id_str', $videoId)->exists()) {
                $this->error = "Video already exists in database.";
                // We could still show metadata but warn user
            }

            $this->metadata = $service->fetchMetadata($videoId);

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        } finally {
            $this->isLoading = false;
        }
    }

    public function updatedSystemPromptId($value)
    {
        if ($value) {
            $prompt = SystemPrompt::find($value);
            if ($prompt) {
                // Determine if we should overwrite existing content. 
                // Simple logic: Always overwrite if user changes the dropdown. 
                // Advanced: check if modified? Let's keep it simple for now.
                $this->system_prompt = $prompt->content;
            }
        }
    }

    public function save()
    {
        $this->validate();

        if (!$this->metadata) {
            $this->updatedUrl(); // Try to fetch again if missed
            if (!$this->metadata) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            $video = Video::create([
                'youtube_url' => $this->url,
                'video_id_str' => $this->metadata['video_id_str'],
                'channel_name' => $this->metadata['channel_name'],
                'channel_id' => $this->metadata['channel_id'],
                'channel_logo' => $this->metadata['channel_logo'],
                'title' => $this->metadata['title'],
                'thumbnail_url' => $this->metadata['thumbnail_url'],
                'upload_date' => $this->metadata['upload_date'],
                'duration' => $this->metadata['duration'],
                'view_count' => $this->metadata['view_count'],
                'access_level' => $this->access_level,
                'ai_provider_id' => $this->ai_provider_id,
                'processing_status' => 'pending',
                'system_prompt' => $this->system_prompt,
            ]);

            // Assign topic if selected
            if ($this->topic_id) {
                $video->topics()->attach($this->topic_id, ['is_verified' => true, 'confidence_score' => 1.0]);
            }

            DB::commit();

            // Dispatch Job
            \App\Jobs\ProcessYouTubeVideo::dispatch($video);

            session()->flash('message', 'Video successfully uploaded and queued for processing.');

            // Reset form
            $this->reset(['url', 'metadata', 'error']);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error = "Failed to save video: " . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.admin.video-upload', [
            'providers' => AiProvider::where('is_active', true)->get(),
            'topics' => Topic::all(),
            'systemPrompts' => SystemPrompt::latest()->get(),
        ])->extends('admin.layout')->section('content');
    }
}
