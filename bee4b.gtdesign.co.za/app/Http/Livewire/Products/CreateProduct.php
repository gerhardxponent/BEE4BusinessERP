<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateProduct extends Component
{
    use AuthorizesRequests;

    public Product $product;
    public $breadcrumbs = [];

    protected function rules()
    {
        return [
            'product.name' => ['required', Rule::unique('products', 'name')->ignore($this->product->id)],
            'product.description' => 'required',
            'product.price' => 'required'
        ];
    }

    public function mount()
    {
        $this->product = Product::make();
        $this->breadcrumbs = ['Products', $this->product->name];
    }

    public function render()
    {
        return view('livewire.products.create-product');
    }

    public function createProduct()
    {
        $this->authorize('create products');
        $this->validate();
        $this->product->save();
        return redirect()->to('products');
    }
}
