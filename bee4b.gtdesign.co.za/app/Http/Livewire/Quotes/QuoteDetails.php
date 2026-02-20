<?php

namespace App\Http\Livewire\Quotes;

use App\Models\Clients;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteItem;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class QuoteDetails extends Component
{
    use AuthorizesRequests;

    public $listeners = [
        'updateSelection' => 'addProducts',
        'refreshComponent' => '$refresh'
    ];

    public $quote;
    public $quoteArray = [];
    // public $toBeDeleted = [];
    // public $toBeAdded = [];
    public $clients;
    public $contacts;
    public $showProductsModal = false;
    public $editing = false;

    public $itemsTotal = 0.00;
    public $totalDiscount = 0.00;
    public $subtotal = 0.00;
    public $grandTotal = 0.00;
    public $totalVat = 0.00;

    public $quoteID;

    public $stages = [
        'Created', 'Delivered', 'Reviewed', 'Accepted', 'Rejected'
    ];

    protected $rules = [
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

        'quote.items.*.quantity' => 'required',
        'quote.items.*.discount' => 'required',

        'quoteArray.*.quantity' => 'required',
        'quoteArray.*.discount' => 'required',

        'toBeAdded.*.discount' => 'required',
        'toBeAdded.*.discount' => 'required',
    ];

    public function mount($id)
    {
        $this->quoteID = $id;
        $this->quote = Quote::find($id);
        // dd($this->quote->name);
        $this->clients = Clients::all();
        $this->contacts = Contact::all();
        $this->resetQuoteItems();
    }

    public function render()
    {
        return view('livewire.quotes.quote-details')
            ->layoutData([
                'backText' => 'all Quotes'
            ]);
    }

    public function toggleEdit()
    {
        //cancel edit
        if($this->editing) {
            $this->quote = Quote::find($this->quoteID);
            $this->resetQuoteItems();
        }

        $this->editing = !$this->editing;
        $this->emit('refreshComponent');
    }

    public function resetQuoteItems()
    {
        $this->quoteArray = [];

        foreach($this->quote->items as $item) {
            array_push($this->quoteArray, [
                'id' => $item->id,
                'name' => $item->itemable->name,
                'price' => $item->itemable->price,
                'type' => 'Product',
                'quantity' => $item->quantity,
                'discount' => $item->discount,
                'description' => $item->description,
                'toBeDeleted' => false,
                'toBeAdded' => false
            ]);
        }

        $this->calcTotal();
    }

    public function calcTotal()
    {
        $this->grandTotal = 0.00;
        $this->totalDiscount = 0.00;
        $this->totalVat = 0.00;
        $this->subtotal = 0.00;
        $this->itemsTotal = 0.00;

        foreach($this->quoteArray as $item) {
            if(!$item['toBeDeleted']) {
                $this->itemsTotal += $item['quantity'] * $item['price'];
                $this->totalDiscount += $item['discount'];
                $this->totalVat += ($item['quantity'] * $item['price'] - $item['discount']) * 0.15;
                $this->grandTotal += $item['quantity'] * $item['price'] - $item['discount'] + (($item['quantity'] * $item['price'] - $item['discount']) * 0.15);
            }
        }
        $this->subtotal = $this->itemsTotal - $this->totalDiscount;
    }

    public function addProducts($ids)
    {
        foreach($ids as $id) {
            $product = Product::find($id);

            array_push($this->quoteArray, [
                'id' => $id,
                'name' => $product->name,
                'price' => $product->price,
                'type' => 'Product',
                'quantity' => 1,
                'discount' => 0.00,
                'description' => '',
                'toBeDeleted' => false,
                'toBeAdded' => true
            ]);
        }

        $this->calcTotal();
        $this->showProductsModal = false;
        $this->emit('refreshComponent');
    }

    public function deleteItem($index)
    {
        if($this->quoteArray[$index]['toBeAdded']) {
            unset($this->quoteArray[$index]);
        }else {
            $this->quoteArray[$index]['toBeDeleted'] = true;
        }

        $this->calcTotal();
        $this->emit('refreshComponent');
    }

    public function removeToBeAdded($index)
    {
        unset($this->toBeAdded[$index]);

        $this->emit('refreshComponent');
        $this->calcTotal();
    }

    public function saveChanges()
    {
        $this->quote->total = $this->grandTotal;
        $this->quote->total_discount = $this->totalDiscount;
        $this->quote->subtotal = $this->subtotal;
        $this->quote->total_vat = $this->totalVat;
        $this->quote->items_total = $this->itemsTotal;
        $this->quote->save();

        foreach($this->quoteArray as $item) {
            if($item['toBeDeleted']) {
                QuoteItem::find($item['id'])->delete();
            }

            if($item['toBeAdded']) {
                $newItem = QuoteItem::make();
                $newItem->quantity = $item['quantity'];
                $newItem->discount = $item['discount'];
                $newItem->description = $item['description'];

                $product = Product::find($item['id']);

                $newItem->itemable()->associate($product);
                $this->quote->items()->save($newItem);
            }

            if(!$item['toBeDeleted'] && !$item['toBeAdded']) {
                $quoteItem = QuoteItem::find($item['id']);

                $quoteItem->quantity = $item['quantity'];
                $quoteItem->discount = $item['discount'];
                $quoteItem->description = $item['description'];

                $quoteItem->save();
            }
        }

        $this->editing = false;
        $this->emitSelf('refreshComponent');
    }

    // public $listeners = ['updateSelection'];

    // public $quote;
    // public $products;
    // public $productQtys = [];
    // public $breadcrumbs = [];
    // public $editing = false;
    // public $showProductsModal = false;
    // public $deleted = [];
    // public $new = [];

    // public $testVal = true;

    // protected $rules = [
    //     'testVal' => 'required'
    // ];

    // public function generatePdf()
    // {
    //     // dd($this->quote->products);

    //     $customer = new Buyer([
    //         'name' => 'John Doe',
    //         'custom_fields' => [
    //             'email' => 'test@example.com',
    //         ],
    //     ]);

    //     // $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);
    
    //     $items = [];

    //     foreach($this->quote->products as $product) {
    //         $item = (new InvoiceItem())
    //                     ->title($product->name)
    //                     ->pricePerUnit($product->price)
    //                     ->quantity($product->pivot->quantity);
    //         array_push($items, $item);
    //     }

    //     $invoice = Invoice::make()
    //         ->buyer($customer)
    //         ->currencySymbol('R')
    //         ->currencyFormat('{SYMBOL}{VALUE}')
    //         ->addItems($items);

            
    //     $invoice->save();
    //     // dd($invoice->filename);
    //     return Storage::download($invoice->filename);

    //     // dd($invoice->url());
        
    //     // return $invoice->stream();
    // }

    // public function mount($id)
    // {
    //     $this->quote = Quote::find($id);
    //     $this->products = $this->quote->products()->get();

    //     foreach($this->quote->products as $product) {
    //         $this->productQtys[$product->id] = $product->pivot->quantity;
    //     }

    //     $this->breadcrumbs = ['Quotes', $this->quote->name];
    // }

    

    // public function toggleEdit()
    // {
    //     $this->authorize('edit quotes');
    //     $this->editing = !$this->editing;
    // }

    // public function updateSelection($values)
    // {
    //     foreach($values as $id) {
    //         if(!in_array($id, array_keys($this->productQtys))) {
    //             $this->productQtys[$id] = 1;
    //             array_push($this->new, $id);
    //         }
    //     }
    //     $this->products = Product::find(array_keys($this->productQtys));
    //     // $this->changedQty();
    //     // $this->updateQuote();
    //     $this->showProductsModal = false;
    // }

    // public function delete($product, $id)
    // {
    //     // unset($this->products[$index]);
    //     // unset($this->productQtys[$id]);
    //     if(isset($this->deleted[$id])) {
    //         unset($this->deleted[$id]);
    //     }else {
    //         $this->deleted[$id] = $product;
    //     }
    // }

    // public function updateQuote()
    // {
    //     foreach($this->deleted as $id => $product) {
    //         unset($this->products[array_search($product, $this->products->toArray())]);
    //         unset($this->productQtys[$id]);
    //     }
    //     $this->deleted = [];
    //     $this->new = [];

    //     $this->quote->products()->detach();
    //     foreach($this->products as $product) {
    //         // $this->quote->products()->detach($product);
    //         $this->quote->products()->attach($product, ['quantity' => $this->productQtys[$product->id]]);
    //     }
    //     // $this->quote->products()->syncWithPivotValues($this->products, ['quantity' => ]);
    // }

    // public function updateTotal($productIndex, $qtyIndex)
    // {
        
    // }
}
