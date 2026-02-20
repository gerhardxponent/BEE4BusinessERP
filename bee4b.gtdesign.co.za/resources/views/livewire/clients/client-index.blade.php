<div class="relative">
   {{-- <x-button wire:click="readWord">Read Word</x-button> --}}

   {{-- <x-header>
      <x-slot name="title">
         {{ Auth::user()->hasRole('Client') || Auth::user()->hasRole('Client Sub User') ? 'Companies' : 'Clients' }}
      </x-slot>
      @can('create clients')
      <x-slot name="button"><x-create-button wire:click="createClient">Create Client</x-create-button></x-slot>
      @endcan
   </x-header> --}}

   {{-- <div class="w-20 h-20 bg-contain bg-no-repeat bg-red-500" style="background-image: url('{{ asset('/assets/logo/B4B_Logo.png') }}');"></div> --}}

   {{-- <img src="{{ Avatar::create('Joko Widodo')->toBase64() }}" />
   <div>
      {!! Avatar::create('Keshav Badul')->setDimension(50)->setFontSize(20)->toSvg()  !!}
   </div> --}}

   {{-- <div class="grid grid-rows-1 grid-cols-4 grid-flow-col gap-4">
      <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
         <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Total Clients</p>
         <a href="#">
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">102</h5>
         </a>
         <a href="#" class="inline-flex items-center text-green-600 hover:underline">
            +25.62%
         </a>
      </div>
      <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
         <div class="grid grid-rows-1 grid-cols-2 grid-flow-col items-center">
            <div class="p-4">
               <x-icons.map />
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                     <th scope="col">
                        Province
                     </th>
                     <th scope="col">
                        Clients
                     </th>
                  </tr>
               </thead>
               <tbody>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                     <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        KZN
                     </th>
                     <td>
                        5
                     </td>
                  </tr>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                     <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        JHB
                     </th>
                     <td>
                        11
                     </td>
                  </tr>
                  <tr class="bg-white dark:bg-gray-800">
                     <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        CPT
                     </th>
                     <td>
                        7
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
         <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Expired Certificates</p>
         <a href="#">
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">8</h5>
         </a>
         <a href="#" class="inline-flex items-center text-green-600 hover:underline">
            +5.00%
         </a>
      </div>
      <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
         <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Upcoming Audits</p>
         <a href="#">
            <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">5</h5>
         </a>
         <a href="#" class="inline-flex items-center text-red-600 hover:underline">
            -10.03%
         </a>
      </div>
   </div> --}}

   <div class="fixed z-50 top-20 right-5 space-y-4">
      @if (session()->has('created_client'))
      <x-toast.success message="{{ session('created_client') }}"></x-toast.success>
      @endif
   </div>

   {{-- <div class="mt-4">
      <x-button wire:click="$emit('toggleShowDeleted')">Trash</x-button>
   </div> --}}

   <div class="mt-4 space-y-2 ">
      <livewire:clients.clients-table/>
   </div>

   <x-jet-dialog-modal wire:model="restoreModal">
      <x-slot name="title">Restore Client</x-slot>
      <x-slot name="content">
         <div>
            Would you like to restore this client or permanently delete it?
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