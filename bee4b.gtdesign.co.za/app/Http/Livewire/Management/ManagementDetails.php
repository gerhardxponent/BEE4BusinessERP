<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use App\Models\ManagementProcess;

class ManagementDetails extends Component
{
    public $managementProcess;
    public $tabs = ['projects', 'files', 'contacts', 'activity'];
    public $currentTab = 'projects';

    protected $listeners = [
        'update:managementProcess-name' => 'updateName'
    ];

    protected $queryString = [
        'currentTab' => ['as' => 'tab']
    ];

    public function mount($id)
    {
        $this->managementProcess = ManagementProcess::with('boards')->where('id', $id)->first();
        // dd($this->managementProcess->icon->svg);
    }

    public function render()
    {
        return view('livewire.management.management-details')
            ->layoutData([
                'backText' => 'all Management Projects',
            ]);;
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function updateName($value, $model, $id, $field)
    {
        ('App\Models\\' . $model)::find($id)->update([ $field => $value ]);
    }
}
