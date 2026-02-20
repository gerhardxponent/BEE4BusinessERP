<div>
    <select wire:model="currentProduct">
        @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select>
    <x-jet-input type="number" wire:model="newItem.quantity" aria-placeholder="Quantity"/>
    <x-jet-button wire:click="addProduct">Add</x-jet-button>
    <x-jet-button wire:click="save">Save</x-jet-button>

    @foreach($invoiceItems as $index => $item)
        <div>
            <div>{{ $item['name'] }}</div>
            <div><x-jet-input type="number" wire:model="invoiceItems.{{ $index }}.quantity" /></div>
            <div>{{ $item['price'] * $invoiceItems[$index]['quantity'] }}</div>
        </div>
    @endforeach
</div>
