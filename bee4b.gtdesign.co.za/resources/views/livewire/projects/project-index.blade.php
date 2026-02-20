<div>
   <x-header>
      <x-slot name="title">Projects</x-slot>
      <x-slot name="button"><x-create-button wire:click="createClient">Create Project</x-create-button></x-slot>
   </x-header>

   <div class="mt-4 space-y-2">
      <livewire:projects.projects-table/>
   </div>
</div>
