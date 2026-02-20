<?php

namespace App\Http\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;

class CreateProject extends Component
{
    public Project $project;
    public $rules = [
        'project.project_name' => 'required',
        'project.project_category' => 'required',
        'project.project_description' => 'required',
        'project.target_start_date' => 'required',
        'project.target_end_date' => 'required',
        'project.client_id' => 'required',
        'project.user_id' => 'required'
    ];
    public $breadcrumbs = [];

    public function mount()
    {
        $this->project = Project::make();
        $this->breadcrumbs = ['Projects', 'Create Project'];
    }

    public function submit()
    {
        $this->validate();
        $this->project->save();
        return redirect()->to('/projects');
    }

    public function render()
    {
        return view('livewire.projects.create-project');
    }
}
