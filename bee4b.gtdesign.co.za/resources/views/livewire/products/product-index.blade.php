<div>
    <x-header>
        <x-slot name="title">Products</x-slot>
        @can('create products')
        <x-slot name="button"><x-create-button wire:click="createProduct">Create Product</x-create-button></x-slot>
        @endcan
    </x-header>

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <livewire:products.product-index-table/>
        </div>
    </div>
</div>