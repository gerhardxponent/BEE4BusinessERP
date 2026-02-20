<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductDetails extends Component
{
    use AuthorizesRequests;

    public Product $product;
    public $product_backup;
    public $editMode = false;
    public $breadcrumbs = [];

    protected function rules()
    {
        return [
            'product.name' => ['required', Rule::unique('products', 'name')->ignore($this->product->id)],
            'product.description' => 'required',
            'product.price' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->product = Product::find($id);
        $this->product_backup = $this->product;
        $this->breadcrumbs = ['Products', $this->product->name];
    }

    public function render()
    {
        return view('livewire.products.product-details');
    }

    public function setEdit()
    {
        if($this->editMode) {
            $this->product = $this->product_backup;
            $this->resetErrorBag();
        }
        $this->editMode = !$this->editMode;
    }

    public function update()
    {
        $this->authorize('edit products');
        $this->validate();
        $this->product->save();
        $this->editMode = false;
    }
}
