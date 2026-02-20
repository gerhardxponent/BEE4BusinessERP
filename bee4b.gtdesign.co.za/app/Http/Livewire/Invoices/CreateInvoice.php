<?php

namespace App\Http\Livewire\Invoices;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Livewire\Component;

class CreateInvoice extends Component
{
    public $listeners = ['refreshComponent' => '$refresh'];

    public Invoice $invoice;
    public InvoiceItem $newItem;
    public $currentProduct;
    public $products;
    public $invoiceItems = [];

    public $test = [];

    protected $rules = [
        'newItem.quantity' => 'required',
        'invoiceItems.*.quantity' => 'required'
    ];

    public function mount()
    {
        $this->invoice = Invoice::make();
        $this->newItem = InvoiceItem::make();
        $this->products = Product::all();
    }

    public function render()
    {
        return view('livewire.invoices.create-invoice');
    }

    public function addProduct()
    {
        $product = Product::find($this->currentProduct);

        array_push($this->invoiceItems, [
            'id' => $this->currentProduct,
            'name' => $product->name,
            'price' => $product->price,
            'type' => 'Product',
            'quantity' => 1
        ]);

        $this->emit('refreshComponent');
    }

    public function save()
    {
        $this->invoice->client_id = 5;
        $this->invoice->save();

        $total = 0.00;

        foreach($this->invoiceItems as $item) {
            $new = InvoiceItem::make();
            $new->quantity = $item['quantity'];

            $product = Product::find($item['id']);

            $total += $product->price * $item['quantity'];

            $new->itemable()->associate($product);
            $this->invoice->items()->save($new);
        }

        $this->invoice->total = $total;
        $this->invoice->save();
    }
}
