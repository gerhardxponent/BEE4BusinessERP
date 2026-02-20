<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;

class ServiceIndex extends Component
{
    public function render()
    {
        return view('livewire.services.service-index');
    }

    public function createService()
    {
        return redirect()->to('service/create');
    }
}
