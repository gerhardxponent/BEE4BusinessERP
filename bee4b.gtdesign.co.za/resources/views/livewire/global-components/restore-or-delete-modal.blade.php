<div>
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">Restore or Delete</x-slot>
        <x-slot name="content">
            Would you like to <span class="font-bold">restore</span> or 
            <span class="font-bold">permanently delete</span> 
            this record
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-1 items-center justify-end">
                <x-button wire:click="restore">Restore</x-button>
                <x-button wire:click="permanentlyDelete" class="bg-red-500">Delete</x-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
