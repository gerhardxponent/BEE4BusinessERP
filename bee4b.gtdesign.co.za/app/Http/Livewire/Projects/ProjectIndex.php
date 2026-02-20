<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;

class ProjectIndex extends Component
{
    public function render()
    {
        return view('livewire.projects.project-index');
    }

    public function createProject() { return redirect()->to('/project/create');}
}
