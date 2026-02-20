<?php

namespace App\Http\Livewire\Management;

use App\Models\Icon;
use App\Models\ManagementProcess;
use Livewire\Component;

class ManagementIndex extends Component
{
    // public $processes;
    public $newProcess;
    public $icons;
    public $showCreateProcessModal = false;

    protected $listeners = [
        'showNewProcessModal'
    ];

    protected $rules = [
        'newProcess.name' => 'required',
        'newProcess.icon_id' => 'required',
    ];

    public function mount()
    {
        // $this->processes = ManagementProcess::with('icon')->get();
        $this->icons = Icon::all();
        $this->newProcess = ManagementProcess::make();
        $this->newProcess->icon_id = $this->icons->first()->id;
    }

    public function render()
    {
        return view('livewire.management.management-index')
                    ->layoutData([
                        'title' => 'Management Projects',
                        'buttonPermission' => 'access management',
                        'buttonAction' => 'showNewProcessModal',
                        'buttonText' => 'Create Process'
                    ]);
    }

    public function getProcessesProperty()
    {
        return ManagementProcess::query()
            ->with('icon')
            ->with('boards')
            ->get();
    }

    public function setIcon($id)
    {
        $this->newProcess->icon_id = $id;
    }

    public function showNewProcessModal() { $this->showCreateProcessModal = true; }

    public function createProcess()
    {
        $this->validate([
            'newProcess.name' => 'required',
            'newProcess.icon_id' => 'required',
        ]);
        $this->newProcess->save();
        $this->showCreateProcessModal = false;

        $this->dispatchBrowserEvent('notify-success', ['message' => 'Process successfully created']);
    }
}
