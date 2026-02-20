<div class="relative">
    <x-header>
        <x-slot name="title">My Boards</x-slot>
        <x-slot name="button"><x-create-button wire:click="createBoard">Create Board</x-create-button></x-slot>
    </x-header>

    {{-- Notification --}}
    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('message'))
        <x-toast.success message="{{ session('message') }}"></x-toast.success>
        @endif
    </div>
    {{-- End Notification --}}

    <livewire:boards.board-table/>

    <x-modal.dialog wire:model="modal">
        <x-slot name="title"></x-slot>
        <x-slot name="content"></x-slot>
        <x-slot name="footer"></x-slot>
    </x-modal.dialog>
</div>
