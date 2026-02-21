<?php

namespace App\Livewire\Admin;

use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;

class VideoList extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $accessLevel = '';
    public $deleteVideoId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'accessLevel' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id = null)
    {
        $videoId = $id ?? $this->deleteVideoId;

        if (!$videoId) {
            return;
        }

        try {
            $video = Video::findOrFail($videoId);

            // Detach all topics (pivot table entries)
            $video->topics()->detach();

            // Delete related AI output if exists
            if ($video->aiOutput) {
                $video->aiOutput()->delete();
            }

            // Delete the video
            $video->delete();

            $this->deleteVideoId = null;
            $this->dispatch('notify', type: 'success', message: 'Video deleted successfully.');
        } catch (\Exception $e) {
            $this->deleteVideoId = null;
            $this->dispatch('notify', type: 'error', message: 'Failed to delete video: ' . $e->getMessage());
        }
    }

    public function retry(Video $video)
    {
        if ($video->processing_status !== 'failed') {
            return;
        }

        // Reset status to processing and dispatch the job again
        $video->update(['processing_status' => 'processing']);

        // Dispatch the video processing job
        \App\Jobs\ProcessYouTubeVideo::dispatch($video);

        session()->flash('message', 'Video reprocessing started.');
    }

    public function render()
    {
        $videos = Video::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('channel_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('processing_status', $this->status);
            })
            ->when($this->accessLevel, function ($query) {
                $query->where('access_level', $this->accessLevel);
            })
            ->with(['aiProvider', 'topics'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.video-list', [
            'videos' => $videos,
        ])->extends('admin.layout')->section('content');
    }
}
