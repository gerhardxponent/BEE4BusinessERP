<div>
    {{-- <x-header>
        <x-slot name="title">Create Service</x-slot>
    </x-header> --}}
    <x-header :breadcrumbs="$breadcrumbs" />
    
    <form class="w-1/4 space-y-2">
        @csrf
        <div>
            <span>@error('service.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="name" value="Name" />
            <x-jet-input class="w-full" type="text" id="name" wire:model.delay="service.name" />
        </div>
        
        <div>
            <span>@error('service.description') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="description" value="Description" />
            <x-textarea id="description" class="w-full" wire:model.delay="service.description" />
        </div>

        <div>
            <span>@error('service.price') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="price" value="Price" />
            <x-jet-input type="number" id="price" wire:model.delay="service.price" class="w-full"/>
        </div>

        <x-jet-button wire:click.prevent="createService">Submit</x-jet-button>
    </form>
</div>
