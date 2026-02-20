@props([
    'showModal' => true
])

<div>
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">Attention</x-slot>
        <x-slot name="content">You do not have permission to do that</x-slot>
        <x-slot name="footer">
            <x-buttons.cancel-button x-on:click="show = false">Close</x-buttons.cancel-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>