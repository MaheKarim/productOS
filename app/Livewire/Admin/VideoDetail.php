<?php

namespace App\Livewire\Admin;

use App\Models\Video;
use Livewire\Component;

class VideoDetail extends Component
{
    public Video $video;
    public $manual_transcript = '';

    public function mount(Video $video)
    {
        $this->video = $video->load(['aiOutput', 'topics', 'aiProvider']);
    }

    public function reprocess()
    {
        $this->video->update(['processing_status' => 'pending']);
        \App\Jobs\ProcessYouTubeVideo::dispatch($this->video);
        session()->flash('message', 'Reprocessing started.');
    }

    public function uploadTranscript()
    {
        $this->validate([
            'manual_transcript' => 'required|string|min:10',
        ]);

        $this->video->update([
            'transcript' => $this->manual_transcript,
            'transcript_fetch_attempts' => 0,
            'transcript_fetch_error' => 'Manually uploaded',
            'transcript_fetched_at' => now(),
            'processing_status' => 'pending',
        ]);

        // Dispatch AI analysis with the new transcript
        \App\Jobs\GenerateAiAnalysis::dispatch($this->video);

        session()->flash('message', 'Transcript uploaded successfully. AI analysis started.');
        $this->manual_transcript = '';
    }

    public function render()
    {
        return view('livewire.admin.video-detail')->extends('admin.layout')->section('content');
    }
}
