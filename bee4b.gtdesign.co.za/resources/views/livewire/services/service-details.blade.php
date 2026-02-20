<div>
    {{-- <x-header>
        <x-slot name="title">{{ $service->name }} Details</x-slot>
    </x-header> --}}    
    <x-details>
        <x-slot name="headerDetails">
            <div class="font-bold text-xl">{{ $service->name }}</div>
        </x-slot>

        <x-slot name="headerButtons">
            @if($editMode)
            <x-jet-button wire:click="update" class="bg-sky-600 hover:bg-sky-500 active:bg-sky-700">Save</x-jet-button>
            @endif
            <x-jet-button wire:click="setEdit">@if($editMode) Cancel @else Edit @endif</x-jet-button>
        </x-slot>

        {{-- <x-slot name="leftColumn"> --}}
            @section('fullWidth')
            <div class="bg-white p-8 rounded-lg w-1/2">
                <table class="table-fixed">
                    <tr>
                        <td class="font-bold">Name</td>
                        @if($editMode)
                        <td>
                            <span>@error('service.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                            <x-jet-input class="w-full" type="text" wire:model.delay="service.name" />
                        </td>
                        @else
                        <td>{{ $service->name }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Description</td>
                        @if($editMode)
                        <td><x-textarea class="w-full" wire:model.delay="service.description" /></td>
                        @else
                        <td>{{ $service->description }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="font-bold">Price</td>
                        @if($editMode)
                        <td><x-jet-input class="w-full" type="number" wire:model.delay="service.price" /></td>
                        @else
                        <td>R {{ $service->price }}</td>
                        @endif
                    </tr>
                </table>
            </div>
            @endsection
        {{-- </x-slot> --}}
    </x-details>
</div>
