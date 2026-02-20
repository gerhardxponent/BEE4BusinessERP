<div>
    {{-- <x-header>
        <x-slot name="title">Quote</x-slot>
        @can('create quotes')
        <x-slot name="button"><x-create-button wire:click="createQuote">Create Quote</x-create-button></x-slot>
        @endcan
    </x-header> --}}
    
    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <livewire:quotes.quote-table />
        </div>
    </div>
</div>
