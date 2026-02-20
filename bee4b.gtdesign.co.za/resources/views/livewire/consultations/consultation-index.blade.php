<div>
    {{-- <x-header>
        <x-slot name="title">Consultations</x-slot>
        @can('create consultations')
        <x-slot name="button"><x-create-button wire:click="createConsultation">Create Consultation</x-create-button></x-slot>
        @endcan
    </x-header> --}}

    <div class="fixed z-50 top-20 right-5 space-y-4">
        @if (session()->has('message'))
        <x-toast.success message="{{ session('message') }}"></x-toast.success>
        @endif
    </div>

    {{-- <div class="grid grid-rows-1 grid-cols-4 grid-flow-col gap-4">
        <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
           <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Total Consultations</p>
           <a href="#">
              <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">88</h5>
           </a>
           <a href="#" class="inline-flex items-center text-green-600 hover:underline">
              +25.62%
           </a>
        </div>
        <div class="w-full row-span-1 p-6 bg-white rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Upcoming Consultations</p>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col">
                            Analyst
                        </th>
                        <th scope="col">
                            Client
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Reg Glutz
                        </th>
                        <td>
                            Edge Training
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Jerain Moodley
                        </th>
                        <td>
                            Edge Hotel School
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Keshav Badul
                        </th>
                        <td>
                            Tesla Motors
                        </td>
                    </tr>
                </tbody>
            </table>
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

    <div class="mt-4 space-y-2">
        <div class="mt-1">
            <livewire:consultations.consultations-table />
        </div>
    </div>

    <livewire:consultations.components.create-consultation-modal />
</div>