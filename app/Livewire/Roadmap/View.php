<?php

namespace App\Livewire\Roadmap;

use App\Models\RoadmapCategory;
use App\Models\RoadmapProgress;
use App\Models\RoadmapTopic;
use Livewire\Component;

class View extends Component
{
    public function updateStatus($topicId, $status)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            $this->dispatch('notify', type: 'warning', message: 'Please log in to track your progress.');
            return;
        }

        $statusLabels = [0 => 'Not Started', 1 => 'In Progress', 2 => 'Completed', 3 => 'Mastered'];

        // 0: Not Started, 1: In Progress, 2: Completed, 3: Mastered
        RoadmapProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'topic_id' => $topicId,
            ],
            [
                'status' => $status,
                'completed_at' => is_numeric($status) && $status >= 2 ? now() : null,
            ]
        );

        $topic = RoadmapTopic::find($topicId);
        $this->dispatch('notify', type: 'success', message: "'{$topic->name}' marked as {$statusLabels[$status]}!");
        $this->dispatch('roadmap-updated'); // To notify Analytics component if needed
    }

    public function render()
    {
        $categories = RoadmapCategory::with([
            'topics' => function ($q) {
                // Load userProgress only if user is logged in
                if (auth()->check()) {
                    $q->with('userProgress');
                }
            }
        ])->orderBy('order')->get();

        return view('livewire.roadmap.view', [
            'categories' => $categories,
        ]);
    }
}
