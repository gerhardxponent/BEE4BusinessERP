<?php

namespace App\Http\Livewire\Management;

use App\Models\Icon;
use App\Models\ManagementProcess;
use Livewire\Component;

class CreateManagementProcess extends Component
{
    public $newProcess;
    public $icons;

    protected $rules = [
        'newProcess.name' => 'required',
        'newProcess.icon_id' => 'required',
    ];

    public function mount()
    {
        $this->newProcess = ManagementProcess::make();
        $this->icons = Icon::all();
    }

    public function render()
    {
        return view('livewire.management.create-management-process');
    }

    public function createProcess()
    {
        $this->newProcess->save();
        return redirect()->to('/management/' . $this->newProcess->id);
    }
}
