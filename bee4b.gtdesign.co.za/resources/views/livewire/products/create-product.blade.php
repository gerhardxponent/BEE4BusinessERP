<div>
    {{-- <x-header>
        <x-slot name="title">Create Product</x-slot>
    </x-header> --}}
    <x-header :breadcrumbs="$breadcrumbs" />

    <form class="w-1/4 space-y-2">
        @csrf
        <div>
            <span>@error('product.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="name" value="Name" />
            <x-jet-input class="w-full" type="text" id="name" wire:model.delay="product.name" />
        </div>

        <div>
            <span>@error('product.description') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="description" value="Description" />
            <textarea id="description" cols="30" rows="10" wire:model.delay="product.description" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'"></textarea>
        </div>

        <div>
            <span>@error('product.price') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="price" value="Price" />
            <x-jet-input type="number" id="price" wire:model.delay="product.price" class="w-full"/>
        </div>
        
        <x-jet-button wire:click.prevent="createProduct">Submit</x-jet-button>
    </form>
</div>
