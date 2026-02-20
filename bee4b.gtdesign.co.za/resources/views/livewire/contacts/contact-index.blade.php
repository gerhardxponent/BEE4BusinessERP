<div>
    <x-toast.success-event />

    {{-- <x-button wire:click="sendEmail">Send email</x-button> --}}

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            {{-- @if(!$showArchives) --}}
                <livewire:contacts.contacts-table />
            {{-- @else --}}
                {{-- <livewire:contacts.contact-archives/> --}}
            {{-- @endif --}}
        </div>
    </div>

    <livewire:contacts.create-contact />
</div>
