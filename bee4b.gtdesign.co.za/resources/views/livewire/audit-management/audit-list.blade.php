<div>
    {{-- <x-header>
        <x-slot name="title">Audits</x-slot>
        <x-slot name="button">
            <div class="flex items-center gap-1">
                @can ('create audits')
                    @can('edit audits')
                        <x-jet-button wire:click="defaultsRedirect">Audit settings</x-jet-button>
                    @endcan
                    <x-create-button wire:click="createAudit">Create Audit</x-create-button>
                @endcan
            </div>
        </x-slot>
    </x-header> --}}
    @can('edit audits')
        @unless(auth()->user()->client_id)
        <x-jet-button wire:click="defaultsRedirect">Audit settings</x-jet-button>
        <x-button wire:click="showDeleted">Archived</x-button>
        @endunless
    @endcan

    <livewire:audit-management.components.audit-table />

    <x-jet-dialog-modal wire:model="showCreateAuditModal">
        <x-slot name="title">Create Audit</x-slot>
        <x-slot name="content">
            <div class="space-y-2">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input type="text" id="name" wire:model.defer="newAudit.name" />
                </div>

                <div>
                    <x-jet-label for="client-select2" value="Client" />
                    <x-select2-multiple wire:model.defer="newAudit.client_id" wire:key="set-client" id="client-select2">
                        <option value="">Select Client</option>
                        @foreach($clients as $clients)
                        <option value="{{ $clients->id }}">{{ $clients->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex items-center gap-1 justify-end">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createAudit">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    <livewire:global-components.restore-or-delete-modal :deleteFiles="true" />
</div>
