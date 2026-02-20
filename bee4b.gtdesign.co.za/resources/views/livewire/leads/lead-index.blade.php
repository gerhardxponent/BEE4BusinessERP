<div class="relative">
   {{-- <x-header>
      <x-slot name="title">Leads</x-slot>
      @can('create leads')
      <x-slot name="button"><x-create-button wire:click="createLead">Create Lead</x-create-button></x-slot>
      @endcan
  </x-header> --}}

   {{-- <div class="mt-4">
      <x-button wire:click="$emit('toggleShowDeleted')">Trash</x-button>
   </div> --}}

  {{-- Notification --}}
  <div class="fixed z-50 top-20 right-5 space-y-4">
      @if (session()->has('message'))
      <x-toast.success message="{{ session('message') }}"></x-toast.success>
      @endif
   </div>
   {{-- End Notification --}}

   <div class="mt-4 space-y-2">
      <livewire:leads.leads-table/>
   </div>

   <x-jet-dialog-modal wire:model="restoreModal">
      <x-slot name="title">Restore Lead</x-slot>
      <x-slot name="content">
         <div>
            Would you like to restore this Lead or permanently delete it?
         </div>
      </x-slot>
      <x-slot name="footer">
         <div class="flex justify-end items-center gap-1">
            <x-button wire:click="restore">Restore</x-button>
            <x-button class="bg-red-500" wire:click="permanentlyDelete">Delete</x-button>
         </div>
      </x-slot>
   </x-jet-dialog-modal>
</div>