<?php

namespace App\Livewire\Feedback;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackDashboard extends Component
{
    use WithPagination;

    public $filterType = 'all';
    public $filterStatus = 'all';
    public $sortBy = 'newest';

    protected $queryString = [
        'filterType' => ['except' => 'all'],
        'filterStatus' => ['except' => 'all'],
        'sortBy' => ['except' => 'newest'],
    ];

    public function render()
    {
        $query = Auth::user()->activeFeedback()
            ->with([
                'statusHistory' => function ($query) {
                    $query->where('is_visible_to_user', true)->latest();
                },
                'attachments'
            ]);

        // Apply filters
        if ($this->filterType !== 'all') {
            $query->ofType($this->filterType);
        }

        if ($this->filterStatus !== 'all') {
            $query->ofStatus($this->filterStatus);
        }

        // Apply sorting
        if ($this->sortBy === 'newest') {
            $query->latest();
        } elseif ($this->sortBy === 'oldest') {
            $query->oldest();
        } elseif ($this->sortBy === 'updated') {
            $query->orderBy('updated_at', 'desc');
        }

        $feedbackList = $query->paginate(10);

        return view('livewire.feedback.feedback-dashboard', [
            'feedbackList' => $feedbackList,
        ]);
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function getFeedbackCountProperty()
    {
        return Auth::user()->activeFeedback()->count();
    }

    public function getActiveFeedbackCountProperty()
    {
        return Auth::user()->activeFeedback()->activeStatus()->count();
    }

    public function getResolvedFeedbackCountProperty()
    {
        return Auth::user()->activeFeedback()->resolved()->count();
    }
}
