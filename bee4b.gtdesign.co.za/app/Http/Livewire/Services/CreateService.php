<?php

namespace App\Http\Livewire\Services;

use App\Models\Service;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateService extends Component
{
    public Service $service;
    public $breadcrumbs = [];

    protected function rules()
    {
        return [
            'service.name' => ['required', Rule::unique('services', 'name')->ignore($this->service->id)],
            'service.description' => 'required',
            'service.price' => 'required'
        ];
    }

    public function mount()
    {
        $this->service = Service::make();
        $this->breadcrumbs = ['Services', 'Create Service'];
    }

    public function render()
    {
        return view('livewire.services.create-service');
    }

    public function createService()
    {
        $this->validate();
        $this->service->save();
        return redirect()->to('/services');
    }
}
