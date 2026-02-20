<?php

namespace App\Http\Livewire\Services;

use App\Models\Service;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ServiceDetails extends Component
{
    public Service $service;
    public $service_backup;
    public $editMode = false;
    public $breadcrumbs = [];

    protected function rules()
    {
        return [
            'service.name' => ['required', Rule::unique('services', 'name')->ignore($this->service->id)],
            'service.description' => 'required',
            'service.price' => 'required'
        ];
    }

    public function mount($id)
    {
        $this->service = Service::find($id);
        $this->service_backup = $this->service;
        $this->breadcrumbs = ['Services', $this->service->name];
    }

    public function render()
    {
        return view('livewire.services.service-details')
            ->layoutData([
                'backText' => 'all Services',
            ]);
    }

    public function setEdit()
    {
        if($this->editMode) {
            $this->service = $this->service_backup;
            $this->resetErrorBag();
        }

        $this->editMode = !$this->editMode;
    }

    public function update()
    {
        $this->validate();
        $this->service->save();
        $this->editMode = false;
    }
}
