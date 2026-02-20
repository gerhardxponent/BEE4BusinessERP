<?php

namespace App\Http\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;

class CreateSupplier extends Component
{
    public $breadcrumbs = [];

    public Supplier $supplier;

    protected function rules()
    {
        return [
            'supplier.suppliername' => 'required',
            'supplier.industry' => 'required',
            'supplier.address' => 'required',
            'supplier.email' => 'required|email',
            'supplier.city' => 'required',
            'supplier.province' => 'required',
            'supplier.country' => 'required',
            'supplier.postalcode' => 'required',
        ];
    }
    public function render()
    {
        return view('livewire.suppliers.create-supplier');
    }

    public function mount()
    {
        $this->supplier=Supplier::make();
        $this->breadcrumbs = ['Suppliers', 'Create Supplier'];
    }

    public function createSupplier()
    {
        $this->validate();
        $this->supplier->save();
        return redirect()->to('/suppliers');
    }
}
