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

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'accessLevel' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Video $video)
    {
        $video->delete();
        session()->flash('message', 'Video deleted successfully.');
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
