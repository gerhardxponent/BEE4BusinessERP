<?php

namespace App\Http\Livewire\Quotes;

use App\Models\Clients;
use App\Models\Contact;
use App\Models\Quote;
use Livewire\Component;

class QuoteNew extends Component
{
    public $quote;
    public $clients;
    public $contacts;
    public $serviceArr;

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

        'quoteItems.*.quantity' => 'required',
        'quoteItems.*.discount' => 'required',
        'quoteItems.*.description' => 'required',

        'testVar' => 'required'
    ];

    public function mount()
    {
        $this->quote = Quote::make();
        $this->clients = Clients::all();
        $this->contacts = Contact::all();

        $this->serviceArr = collect([]);
    }

    public function render()
    {
        return view('livewire.quotes.quote-new');
    }

    public function addService($id)
    {
        if ($this->serviceArr->doesntContain($id))
            $this->serviceArr->push($id);
    }
}
