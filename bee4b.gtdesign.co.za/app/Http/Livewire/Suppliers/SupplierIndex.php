<?php

namespace App\Http\Livewire\Suppliers;

use Livewire\Component;

class SupplierIndex extends Component
{
    public function render()
    {
        return view('livewire.suppliers.supplier-index');
    }

    public function createSupplier()
    {
        return redirect()->to('/suppliers/create');
    }
}
