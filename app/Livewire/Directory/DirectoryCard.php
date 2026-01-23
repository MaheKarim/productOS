<?php

namespace App\Livewire\Directory;

use Livewire\Component;
use App\Models\DirectoryItem;

class DirectoryCard extends Component
{
    public DirectoryItem $item;

    public function render()
    {
        return view('livewire.directory.directory-card');
    }
}
