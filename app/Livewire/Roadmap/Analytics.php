<?php

namespace App\Livewire\Roadmap;

use App\Models\RoadmapCategory;
use App\Models\RoadmapTopic;
use App\Models\RoadmapProgress;
use Livewire\Component;
use Livewire\Attributes\On;

class Analytics extends Component
{
    public $refreshKey = 0;

    #[On('roadmap-updated')]
    public function refreshAnalytics()
    {
        $this->refreshKey++;
    }

    public function render()
    {
        $user = auth()->user();

        $totalTopics = RoadmapTopic::count();
        $completedTopics = RoadmapProgress::where('user_id', $user->id)
            ->where('status', '>=', 2) // Completed or Mastered
            ->count();

        $percentage = $totalTopics > 0 ? round(($completedTopics / $totalTopics) * 100) : 0;

        $categories = RoadmapCategory::withCount('topics')->get();

        $categoryProgress = $categories->map(function ($category) use ($user) {
            $completed = RoadmapProgress::where('user_id', $user->id)
                ->whereHas('topic', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->where('status', '>=', 2)
                ->count();

            return [
                'name' => $category->name,
                'completed' => $completed,
                'total' => $category->topics_count,
                'percentage' => $category->topics_count > 0 ? round(($completed / $category->topics_count) * 100) : 0,
            ];
        });

        return view('livewire.roadmap.analytics', [
            'totalTopics' => $totalTopics,
            'completedTopics' => $completedTopics,
            'percentage' => $percentage,
            'categoryProgress' => $categoryProgress,
        ]);
    }
}
