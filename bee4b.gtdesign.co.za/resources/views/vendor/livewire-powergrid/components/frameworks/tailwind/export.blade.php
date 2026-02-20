<div x-data="{ open: false }"
     @click.away="open = false">
    <div class="flex items-center gap-1">
        <x-button @click.prevent="open = ! open">
            <div class="flex items-center gap-1">
                {{-- <x-livewire-powergrid::icons.download class="h-5 w-5 text-white dark:text-gray-300"/> --}}
                <div class="font-bold">
                    <span>Export</span>
                </div>
            </div>
        </x-button>

        @if (isset($bulkActions))
            @if ($showDeleted)
                <x-button colour="blue" :disabled="$checkboxValues == []" wire:click="bulkRestore">
                    <div class="flex justify-center items-center gap-1">
                        <x-icons.refresh size="18" />
                        <div>Restore</div>
                    </div>
                </x-button>

                <x-button colour="red" :disabled="$checkboxValues == []" wire:click="$set('showConfirmDeleteModal', true)">
                    <div class="flex justify-center items-center gap-1">
                        <x-icons.bin-solid size="18" />
                        <div>Permanently Delete</div>
                    </div>
                </x-button>
            @else
                <x-button :disabled="$checkboxValues == []" wire:click="bulkArchive">
                    <div class="flex justify-center items-center gap-1">
                        <x-icons.archive-filled size="18" />
                        <div>Archive</div>
                    </div>
                </x-button>
            @endif
        @endif
    </div>

    <div x-show="open"
         x-cloak
         x-transition:enter="transform duration-200"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transform duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="mt-2 w-auto bg-white shadow-xl absolute z-10 dark:bg-gray-500"
         style="z-index:99999999999999">
        @if(in_array('excel',$exportType))
            <div class="flex px-4 py-2 text-gray-400 dark:text-gray-300">
                <span class="w-12">Excel</span>
                <a x-on:click="$wire.call('exportToXLS'); open = false"
                   href="#"
                   class="px-2 block text-gray-800 hover:bg-gray-50 hover:text-black-300 dark:text-gray-200 dark:hover:bg-gray-700 rounded">
                    @lang('livewire-powergrid::datatable.labels.all')
                </a>
                @if($checkbox)
                    <a x-on:click="$wire.call('exportToXLS', true); open = false"
                       href="#"
                       class="px-2 block text-gray-800 hover:bg-gray-50 hover:text-black-300 dark:text-gray-200 dark:hover:bg-gray-700 rounded">
                        @lang('livewire-powergrid::datatable.labels.selected')
                    </a>
                @endif
            </div>
        @endif
        @if(in_array('csv',$exportType))
            <div class="flex px-4 py-2 text-gray-400 dark:text-gray-300">
                <span class="w-12">Csv</span>
                <a x-on:click="$wire.call('exportToCsv'); open = false" href="#"
                   class="px-2 block text-gray-800 hover:bg-gray-50 hover:text-black-300 dark:text-gray-200 dark:hover:bg-gray-700 rounded">
                    @lang('livewire-powergrid::datatable.labels.all')
                </a>
                @if($checkbox)
                    <a x-on:click="$wire.call('exportToCsv', true); open = false" href="#"
                       class="px-2 block text-gray-800 hover:bg-gray-50 hover:text-black-300 dark:text-gray-200 dark:hover:bg-gray-700 rounded">
                        @lang('livewire-powergrid::datatable.labels.selected')
                    </a>
                @endif
            </div>
        @endif
    </div>

    @if (isset($bulkActions))
        <x-jet-confirmation-modal wire:model="showConfirmDeleteModal">
            <x-slot name="title">Delete record</x-slot>
            <x-slot name="content">
                <div>
                    <div>Are you sure you would like to delete the selected records?</div>
                    <div class="text-red-500 text-sm">This action is irreversible</div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex items-center gap-1">
                    <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                    <x-buttons.delete-button wire:click="bulkPermanentlyDelete">Delete</x-buttons.delete-button>
                </div>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
