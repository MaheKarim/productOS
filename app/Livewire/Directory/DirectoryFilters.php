<?php

namespace App\Livewire\Directory;

use Livewire\Component;
use App\Models\DirectoryCategory;

class DirectoryFilters extends Component
{
    public $type;
    public $filters = [];
    public $categories = [];

    public function mount($type)
    {
        $this->type = $type;
        $this->categories = DirectoryCategory::where('type', $type)
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // Initialize filters
        $this->filters = [
            'category' => '',
            'pricing' => 'all',
            'difficulty' => 'all',
            'hiring' => false,
        ];
    }

    public function updatedFilters()
    {
        $this->dispatch('filterUpdated', $this->filters);
    }

    public function render()
    {
        return view('livewire.directory.directory-filters');
    }
}
