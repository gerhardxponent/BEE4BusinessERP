<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class ProductIndex extends Component
{
    public function render()
    {
        return view('livewire.products.product-index');
    }

    public function createProduct()
    {
        return redirect()->to('/product/create');
    }
}
