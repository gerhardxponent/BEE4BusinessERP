<?php

namespace App\Http\Livewire\Suppliers;

use Livewire\Component;

class SupplierDetails extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        $this->breadcrumbs = ['Suppliers'];
    }

    public function render()
    {
        return view('livewire.suppliers.supplier-details');
    }
}
