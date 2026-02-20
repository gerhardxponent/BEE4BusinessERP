<div>
   <x-header>
      <x-slot name="title">Suppliers</x-slot>
      <x-slot name="button"><x-create-button wire:click="createSupplier">Create Supplier</x-create-button></x-slot>
  </x-header>

   <div class="mt-4 space-y-2">
      <livewire:suppliers.suppliers-table/>
   </div>
</div>