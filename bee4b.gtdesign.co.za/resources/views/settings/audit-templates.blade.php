<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Audit Templates</h2>
  </x-slot>

  <div class="">
    <div class="">
      <!-- exactly the same “card” wrapper as your Create Audit page -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @livewire('audit-template-builder')
        </div>
      </div>
    </div>
  </div>
</x-app-layout>