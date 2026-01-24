<?php

namespace App\Livewire;

use App\Models\Prompt;
use App\Models\PromptCategory;
use Livewire\Component;
use Livewire\WithPagination;

class PromptSearch extends Component
{
    use WithPagination;

    // Search & Filter State
    public $search = '';
    public $selectedCategory = null;
    public $selectedTool = null;
    public $selectedDifficulty = null;
    public $sortBy = 'popular';

    // Pagination
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null, 'as' => 'category'],
        'selectedTool' => ['except' => null, 'as' => 'tool'],
        'selectedDifficulty' => ['except' => null, 'as' => 'difficulty'],
        'sortBy' => ['except' => 'popular', 'as' => 'sort'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedTool()
    {
        $this->resetPage();
    }

    public function updatingSelectedDifficulty()
    {
        $this->resetPage();
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $this->selectedCategory == $categoryId ? null : $categoryId;
        $this->resetPage();
    }

    public function setTool($tool)
    {
        $this->selectedTool = $this->selectedTool === $tool ? null : $tool;
        $this->resetPage();
    }

    public function setDifficulty($difficulty)
    {
        $this->selectedDifficulty = $this->selectedDifficulty === $difficulty ? null : $difficulty;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategory = null;
        $this->selectedTool = null;
        $this->selectedDifficulty = null;
        $this->sortBy = 'popular';
        $this->resetPage();
    }

    public function trackCopy($promptId)
    {
        $prompt = Prompt::find($promptId);
        if ($prompt) {
            $prompt->incrementCopyCount();
        }
    }

    public function render()
    {
        $query = Prompt::with('category')->published();

        // Search
        if ($this->search) {
            $query->search($this->search);
        }

        // Filter by category
        if ($this->selectedCategory) {
            $query->byCategory($this->selectedCategory);
        }

        // Filter by AI tool
        if ($this->selectedTool) {
            $query->byTool($this->selectedTool);
        }

        // Filter by difficulty
        if ($this->selectedDifficulty) {
            $query->byDifficulty($this->selectedDifficulty);
        }

        // Sort
        switch ($this->sortBy) {
            case 'recent':
                $query->orderBy('created_at', 'desc');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'copies':
                $query->orderBy('copy_count', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('copy_count', 'desc')->orderBy('view_count', 'desc');
                break;
        }

        $prompts = $query->paginate($this->perPage);
        $categories = PromptCategory::active()->ordered()->withCount([
            'prompts' => function ($q) {
                $q->published();
            }
        ])->get();
        $featuredPrompts = Prompt::with('category')->published()->featured()->orderBy('copy_count', 'desc')->take(4)->get();

        $totalCount = Prompt::published()->count();

        return view('livewire.prompt-search', [
            'prompts' => $prompts,
            'categories' => $categories,
            'featuredPrompts' => $featuredPrompts,
            'totalCount' => $totalCount,
        ]);
    }
}
