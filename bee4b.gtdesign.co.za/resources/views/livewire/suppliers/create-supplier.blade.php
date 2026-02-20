<div>
    {{-- <x-header>
        <x-slot name="title">Create Supplier</x-slot>
    </x-header> --}}
    <x-header :breadcrumbs="$breadcrumbs" />

    <form class="w-1/4 space-y-2">
        @csrf
        <div>
            <span>@error('supplier.suppliername') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="name" value="Name" />
            <x-jet-input class="w-full" type="text" id="name" wire:model.delay="supplier.suppliername" />
        </div>

        <div>
            <span>@error('supplier.industry') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="industry" value="Industry" />
            <x-jet-input class="w-full" type="text" id="industry" wire:model.delay="supplier.industry" />
        </div>
        
        <div>
            <span>@error('supplier.address') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="address" value="Address" />
            <x-textarea id="address" class="w-full" wire:model.delay="supplier.address" />
        </div>

        <div>
            <span>@error('supplier.email') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="email" value="Email" />
            <x-jet-input type="text" id="email" wire:model.delay="supplier.email" class="w-full"/>
        </div>

        <div>
            <span>@error('supplier.province') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="province" value="Province" />
            <x-jet-input type="text" id="province" wire:model.delay="supplier.province" class="w-full"/>
        </div>

        <div>
            <span>@error('supplier.country') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="country" value="Country" />
            <x-jet-input type="text" id="country" wire:model.delay="supplier.country" class="w-full"/>
        </div>

        <div>
            <span>@error('supplier.postalcode') <span class="text-red-500">{{ $message }}</span> @enderror</span>
            <x-jet-label for="postalcode" value="Postal Code" />
            <x-jet-input type="text" id="postalcode" wire:model.delay="supplier.postalcode" class="w-full"/>
        </div>

        <x-jet-button wire:click.prevent="createSupplier">Submit</x-jet-button>
    </form>
</div>
