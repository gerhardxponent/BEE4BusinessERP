<?php

namespace App\Http\Livewire\Quotes;

use App\Models\Clients;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CreateQuote extends Component
{
    use AuthorizesRequests;

    public $listeners = [
        'updateSelection' => 'addProducts',
        'updatedServices' => 'addServices',
        'refreshComponent' => '$refresh'
    ];
    public $quote;
    public $clients;
    public $clientId;
    public $contacts;
    public $showProductsModal = false;
    public $quoteItems = [];
    public $total = 0.00;
    public $totalDiscount = 0.00;
    public $totalVat = 0.00;
    public $subtotal = 0.00;
    public $itemsTotal = 0.00;
    public $stages = [
        'Created', 'Delivered', 'Reviewed', 'Accepted', 'Rejected'
    ];

    public $sameAsBilling = true;

    protected $rules = [
        'clientId' => 'required',

        'quote.name' => 'required',
        'quote.client_id' => 'required',
        'quote.stage' => 'required',
        'quote.valid_until' => 'required',
        'quote.contact_id' => 'required',
        'quote.description' => 'required',
        'quote.billing_address' => 'required',
        'quote.billing_city' => 'required',
        'quote.billing_province' => 'required',
        'quote.billing_postal_code' => 'required',
        'quote.billing_country' => 'required',
        'quote.shipping_address' => 'required',
        'quote.shipping_city' => 'required',
        'quote.shipping_province' => 'required',
        'quote.shipping_postal_code' => 'required',
        'quote.shipping_country' => 'required',

        'quoteItems.*.quantity' => 'required',
        'quoteItems.*.discount' => 'required',
        'quoteItems.*.description' => 'required',

        'testVar' => 'required'
    ];

    public $testVar;
    public $test = true;
    public function test()
    {
        dd($this->quote);
    }

    public function mount()
    {
        $this->quote = Quote::make();
        $this->clients = Clients::all();
        $this->contacts = Contact::all();
    }

    public function render()
    {
        return view('livewire.quotes.create-quote')
            ->layoutData([
                'backText' => 'all Quotes'
            ]);
    }

    public function toggleProductModal()
    {
        $this->showProductsModal = true;
    }

    public function updatedQuoteClientId($id)
    {
        $client = Clients::find($id);

        $this->quote->billing_address = $client->address;
        $this->quote->billing_city = $client->city;
        $this->quote->billing_province = $client->province; 
        $this->quote->billing_postal_code = $client->postal_code;
        $this->quote->billing_country = $client->country;  
    }

    public function updatedSameAsBilling($value)
    {
        if ($value == true) {
            $this->quote->shipping_address = $this->quote->billing_address;
            $this->quote->shipping_city = $this->quote->billing_city;
            $this->quote->shipping_province = $this->quote->billing_province;
            $this->quote->shipping_postal_code = $this->quote->billing_postal_code;
            $this->quote->shipping_country = $this->quote->billing_country;
        }
    }

    public function addProducts($ids)
    {
        foreach($ids as $id) {
            if(!in_array($id, array_column($this->quoteItems, 'id'))) {
                $product = Product::find($id);

                array_push($this->quoteItems, [
                    'id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'type' => 'Product',
                    'quantity' => 1,
                    'discount' => 0.00,
                    'description' => ''
                ]);
            }
        }

        $this->calcTotal();
        $this->showProductsModal = false;
        // $this->emit('refreshComponent');
    }

    public function addServices($ids)
    {
        foreach($ids as $id) {
            if(!in_array($id, array_column($this->quoteItems, 'id'))) {
                $service = Service::find($id);

                array_push($this->quoteItems, [
                    'id' => $id,
                    'name' => $service->name,
                    'price' => $service->price,
                    'type' => 'Service',
                    'quantity' => 1,
                    'discount' => 0.00,
                    'description' => ''
                ]);
            }
        }

        $this->calcTotal();
        $this->showProductsModal = false;
        // $this->emit('refreshComponent');
    }

    public function calcTotal()
    {
        $this->total = 0.00;
        $this->totalDiscount = 0.00;
        $this->totalVat = 0.00;
        $this->subtotal = 0.00;
        $this->itemsTotal = 0.00;

        foreach($this->quoteItems as $item) {
            $this->itemsTotal += $item['quantity'] * $item['price'];
            $this->totalDiscount += $item['discount'];
            $this->totalVat += ($item['quantity'] * $item['price'] - $item['discount']) * 0.15;
            $this->total += $item['quantity'] * $item['price'] - $item['discount'] + (($item['quantity'] * $item['price'] - $item['discount']) * 0.15);
        }
        $this->subtotal = $this->itemsTotal - $this->totalDiscount;
    }

    public function removeProduct($index)
    {
        unset($this->quoteItems[$index]);
        $this->calcTotal();
        $this->emit('refreshComponent');
    }

    public function createQuote()
    {
        $this->validate([
            'quote.name' => 'required',
            'quote.client_id' => 'required',
            'quote.stage' => 'required',
            'quote.valid_until' => 'required',
        ]);

        $this->quote->items_total = $this->itemsTotal;
        $this->quote->total = $this->total;
        $this->quote->total_discount = $this->totalDiscount;
        $this->quote->subtotal = $this->subtotal;
        $this->quote->total_vat = $this->totalVat;
        $this->quote->created_by = Auth::id();
        if($this->sameAsBilling) {
            $this->quote->shipping_address = $this->quote->billing_address;
            $this->quote->shipping_city = $this->quote->billing_city;
            $this->quote->shipping_province = $this->quote->billing_province;
            $this->quote->shipping_postal_code = $this->quote->billing_postal_code;
            $this->quote->shipping_country = $this->quote->billing_country;
        }

        $this->quote->save();

        foreach($this->quoteItems as $item) {
            $newItem = QuoteItem::make();
            $newItem->quantity = $item['quantity'];
            $newItem->discount = $item['discount'];
            $newItem->description = $item['description'];

            $product = Service::find($item['id']);

            $newItem->itemable()->associate($product);
            $this->quote->items()->save($newItem);
        }

        return redirect()->to('/quotes/' . $this->quote->id);
    }

    // public $showProductsModal = false;
    // public $showServicesModal = false;
    // public $breadcrumbs = [];

    // public $listeners = ['updateSelection', 'updatedServices'];

    // public Quote $quote;
    // public $clients;
    // public $selectedClient;
    // public $products = [];
    // public $services = [];
    // public $productQtys = [];
    // public $serviceQtys = [];
    // public $total = 0;
    // protected $rules = [
    //     'quote.name' => 'required',
    //     'quote.products.*.pivot.quantity' => 'required'
    // ];

    // public function mount()
    // {
    //     $this->quote = Quote::make();
    //     // dd($this->quote->products[0]);
    //     $this->clients = Clients::all();
    //     $this->breadcrumbs = ['Quotes', 'Create Quote'];
    // }

    // public function toggleProductModal()
    // {
    //     $this->showProductsModal = !$this->showProductsModal;
    // }

    // public function toggleServicesModal()
    // {
    //     $this->showServicesModal = !$this->showServicesModal;
    // }

    // public function updateSelection($values)
    // {
    //     foreach($values as $id) {
    //         if(!in_array($id, $this->productQtys)) {
    //             $this->productQtys[$id] = 1;
    //         }
    //     }
    //     $this->products = Product::find(array_keys($this->productQtys));
    //     $this->changedQty();
    //     $this->showProductsModal = false;
    // }

    // public function updatedServices($values)
    // {
    //     foreach($values as $id) {
    //         if(!in_array($id, $this->serviceQtys)) {
    //             $this->serviceQtys[$id] = 1;
    //         }
    //     }
    //     $this->services = Service::find(array_keys($this->serviceQtys));
    //     $this->changedQty();
    //     $this->showServicesModal = false;
    // }

    // public function changedQty()
    // {
    //     $this->total = 0;
    //     foreach($this->products as $product) {
    //         $this->total += $product->price * $this->productQtys[$product->id];
    //     }

    //     foreach($this->services as $service) {
    //         $this->total += $service->price * $this->serviceQtys[$service->id];
    //     }
    // }

    // public function incrementProduct($product)
    // {
    //     $this->productQtys[$product["id"]]++;
    //     $this->changedQty($this->productQtys[$product["id"]]);
    // }

    // public function incrementService($service)
    // {
    //     $this->serviceQtys[$service["id"]]++;
    //     $this->changedQty($this->serviceQtys[$service["id"]]);
    // }

    // public function decrementProduct($product)
    // {
    //     $this->productQtys[$product["id"]]--;
    //     $this->changedQty($this->productQtys[$product["id"]]);
    // }

    // public function decrementService($service)
    // {
    //     $this->serviceQtys[$service["id"]]--;
    //     $this->changedQty($this->serviceQtys[$service["id"]]);
    // }

    // public function removeProduct($index, $id)
    // {
    //     $this->total -= $this->products[$index]->price * $this->productQtys[$id];
    //     unset($this->products[$index]);
    //     unset($this->productQtys[$id]);
    // }

    // public function removeService($index, $id)
    // {
    //     $this->total -= $this->services[$index]->price * $this->serviceQtys[$id];
    //     unset($this->services[$index]);
    //     unset($this->productQtys[$id]);
    // }

    // public function createQuote()
    // {
    //     $this->authorize('create quotes');
    //     $this->validate();

    //     $this->quote->total = $this->total;
    //     $this->quote->client_id = $this->selectedClient;
    //     $this->quote->save();

    //     foreach($this->products as $product) {
    //         $this->quote->products()->attach($product, ['quantity' => $this->productQtys[$product->id]]);
    //     }
    //     foreach($this->services as $service) {
    //         $this->quote->services()->attach($service, ['quantity' => $this->serviceQtys[$service->id]]);
    //     }
    // }
}
