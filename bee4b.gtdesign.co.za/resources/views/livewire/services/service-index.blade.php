<div>
    <x-header>
        <x-slot name="title">Services</x-slot>
        <x-slot name="button"><x-create-button wire:click="createService">Create Service</x-create-button></x-slot>
    </x-header>

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <livewire:services.service-index-table/>
        </div>
    </div>
</div>
