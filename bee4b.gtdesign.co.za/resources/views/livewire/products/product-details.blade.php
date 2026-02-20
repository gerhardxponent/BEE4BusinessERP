<div>
    {{-- <x-header>
        <x-slot name="title">{{ $product->name }} Details</x-slot>
    </x-header> --}}
    <x-header :breadcrumbs="$breadcrumbs" />

    <x-details>
        <x-slot name="headerDetails">
            <div class="font-bold text-xl">{{ $product->name }}</div>
        </x-slot>

        <x-slot name="headerButtons">
            @can('edit products')
            @if($editMode)
            <x-jet-button wire:click="update" class="bg-sky-600 hover:bg-sky-500 active:bg-sky-700">Save</x-jet-button>
            @endif
            <x-jet-button wire:click="setEdit">@if($editMode) Cancel @else Edit @endif</x-jet-button>
            @endcan
        </x-slot>

        <x-slot name="leftColumn">
            <div class="border p-4">
                <table class="table-fixed">
                    <tr>
                        <td class="font-bold">Name</td>
                        @if($editMode)
                        <td>
                            <span>@error('product.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                            <x-jet-input class="w-full" wire:model="product.name" type="text" />
                        </td>
                        @else
                        <td>{{ $product->name }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Description</td>
                        @if($editMode)
                        <td><x-textarea class="w-full" wire:model="product.description" /></td>
                        @else
                        <td>{{ $product->description }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Price</td>
                        @if($editMode)
                        <td><x-jet-input class="w-full" wire:model="product.price" type="number" /></td>
                        @else
                        <td>R {{ $product->price }}</td>
                        @endif
                    </tr>
                </table>
            </div>
        </x-slot>
    </x-details>
</div>
