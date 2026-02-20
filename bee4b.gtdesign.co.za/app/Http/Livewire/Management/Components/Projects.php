<?php

namespace App\Http\Livewire\Management\Components;

use App\Http\Livewire\GlobalComponents\Projects as GlobalComponentsProjects;
use App\Models\Board;
use Livewire\Component;

class Projects extends GlobalComponentsProjects
{
    // public function mount($id, $type)
    // {

    // }

    public function initialiseBoard($id, $type)
    {
        $this->activeBoard = Board::where('is_management', 1)->first();
        // dd($this->activeBoard);
    }

    // public function render()
    // {
    //     return view('livewire.management.components.projects');
    // }
}
