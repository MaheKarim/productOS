<?php

namespace App\Livewire\Directory;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Models\DirectoryItem;

class DirectoryList extends Component
{
    use WithPagination;

    public $type;
    public $search = '';
    public $filters = [];
    public $sort = 'rating';
    public $view = 'grid';

    public function mount($type)
    {
        $this->type = $type;
    }

    #[On('filterUpdated')]
    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    #[Computed]
    public function items()
    {
        $query = DirectoryItem::query()
            ->where('type', $this->type)
            ->where('is_active', true)
            ->where('verification_status', 'verified');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('tagline', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        // Apply Filters
        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        if (!empty($this->filters['pricing']) && in_array($this->type, ['tools', 'learning'])) {
            if ($this->filters['pricing'] !== 'all') {
                $query->where('pricing_model', $this->filters['pricing']);
            }
        }

        if (!empty($this->filters['difficulty']) && $this->type === 'learning') {
            if ($this->filters['difficulty'] !== 'all') {
                $query->where('difficulty_level', $this->filters['difficulty']);
            }
        }

        if (!empty($this->filters['hiring']) && $this->type === 'companies' && $this->filters['hiring']) {
            $query->where('is_hiring', true);
        }

        // Sort Logic
        switch ($this->sort) {
            case 'newest':
                $query->latest();
                break;
            case 'popular':
                $query->orderByDesc('view_count');
                break;
            case 'az':
                $query->orderBy('name');
                break;
            case 'featured':
                $query->orderByDesc('is_featured')->latest();
                break;
            default: // rating/featured
                $query->orderByDesc('is_featured')->latest();
        }

        return $query->paginate(24);
    }

    public function render()
    {
        return view('livewire.directory.directory-list');
    }
}
