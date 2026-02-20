@if($searchInput)
    <div class="flex flex-row mt-2 md:mt-0 w-full grow justify-start sm:justify-center md:justify-end">
        <div class="relative w-full float-end float-right flex justify-end">
            <span class="absolute inset-y-0 left-0 flex items-center pl-1">
                <span class="p-1 focus:outline-none focus:shadow-outline">
                <x-livewire-powergrid::icons.search class="text-gray-300 dark:text-gray-200"/>
                </span>
            </span>
            <input wire:model.debounce.600ms="search" type="text"
                   style="padding-left: 36px !important;"
                   class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                   placeholder="{{ trans('livewire-powergrid::datatable.placeholders.search') }}" >
            @if($search)
                <span class="absolute inset-y-0 right-0 flex items-center pl-1">
                    <span class="p-1 focus:outline-none focus:shadow-outline cursor-pointer">
                        <a wire:click.prevent="$set('search','')">
                            <x-livewire-powergrid::icons.x class="text-gray-300 dark:text-gray-200"/>
                        </a>
                    </span>
                </span>
            @endif
        </div>
    </div>
@endif
