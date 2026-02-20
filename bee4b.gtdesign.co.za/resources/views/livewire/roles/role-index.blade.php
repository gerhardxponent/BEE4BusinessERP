<div>
    {{-- <x-header>
        <x-slot name="title">Roles</x-slot>
        <x-slot name="button"><x-create-button wire:click="createRole">Create Role</x-create-button></x-slot>
    </x-header> --}}

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <livewire:roles.role-table />
        </div>
    </div>
</div>
