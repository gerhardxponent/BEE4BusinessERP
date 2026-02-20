<?php

namespace App\Http\Livewire\Quotes;

use Livewire\Component;

class QuoteIndex extends Component
{
    protected $listeners = [
        'createQuote',
    ];

    public function render()
    {
        return view('livewire.quotes.quote-index')
            ->layoutData([
                'title' => 'Quotes',
                'buttonPermission' => 'create quotes',
                'buttonAction' => 'createQuote',
                'buttonText' => 'Create Quote'
            ]);
    }

    public function createQuote() { return redirect()->to('quotes/create'); }
}
