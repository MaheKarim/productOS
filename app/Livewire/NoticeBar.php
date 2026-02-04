<?php

namespace App\Livewire;

use App\Models\NoticeBar as NoticeBarModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log
use Livewire\Component;

class NoticeBar extends Component
{
    public $notice;

    public function mount()
    {
        $this->loadNotice();
    }

    public function loadNotice()
    {
        $query = NoticeBarModel::active();

        // Audience Logic
        if (Auth::check()) {
            $audience = ['all', 'free'];
            $query->whereIn('audience', $audience);
        } else {
            // Guests only see 'all'
            $query->where('audience', 'all');
        }

        $this->notice = $query->latest()->first();
    }

    public function render()
    {
        return view('livewire.notice-bar');
    }
}
