<div class="relative" x-data="{ showFilters: false }">
    <div class="w-1/2 space-y-2 mb-4">
        @if ($showHeader)
        <div class="flex justify-start items-center gap-1">
            <div class="w-full">
                <x-search-clear wire:model="searchString" />
            </div>

            <x-buttons.flat2 x-on:click="showFilters = !showFilters;">
                <x-slot name="icon">
                    <x-icons.filter />
                </x-slot>
                Filters
            </x-buttons.flat2>

            <x-buttons.flat2 wire:click="export">
                <x-slot name="icon">
                    <x-icons.table-export />
                </x-slot>
                Export
            </x-buttons.flat2>
        </div>
        @endif

        <div x-show="showFilters" class="space-y-4 bg-white p-8 rounded-xl">
            {{-- Type filter --}}
            <div>
                <x-jet-label for="type" value="Type" />
                <x-select2-multiple wire:model="filters.type" wire:key="filter-type" id="filter-type">
                    <option value="">All</option>
                    @foreach ($this->types as $type)
                    <option value="{{ $type->activity_type }}">{{ ucfirst($type->activity_type) }}</option>
                    @endforeach
                </x-select2-multiple>
            </div>
            {{-- End type filter --}}

            {{-- User filter --}}
            <div>
                <x-jet-label for="users" value="User" />
                <x-select2-multiple wire:model="filters.user" wire:key="filter-users" id="filter-users">
                    <option value="">All</option>
                    @foreach (App\Models\User::all() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-select2-multiple>
            </div>
            {{-- End user filter --}}

            {{-- Date filter --}}
            <div>
                <x-jet-label for="flatpickr_operation_date" value="Date" />
                <x-date-range id="flatpickr_operation_date" wire:model.lazy="filters.date" :options="['mode' => 'range']" />
            </div>
            {{-- End date filter --}}

            {{-- Clear all  --}}
            <x-jet-button wire:click="clearFilters">Clear filters</x-jet-button>
            {{-- End clear all --}}
        </div>
    </div>

    <div class="ml-6">
        @foreach($activities as $activity)
            <div class="relative flex items-center activity-section border-l-2 border-indigo-300 py-4 pr-4 w-full z-[99]">
                {{-- Icon --}}
                <div class="-translate-x-1/2">
                    <div class="bg-indigo-500 rounded-full p-1 text-white">
                        @switch($activity->activity_type)
                            @case('file upload')
                                <x-icons.file-upload />
                                @break

                            @case('create')
                                <x-icons.plus />
                                @break

                            @case('update')
                                <x-icons.refresh />
                                @break

                            @case('delete')
                                <x-icons.bin />
                                @break
                            
                            @case('task status change')
                                <x-icons.check />
                                @break

                            @case('comment')
                                <x-icons.comment />
                                @break
                        
                            @default
                                <x-icons.plus />
                        @endswitch
                    </div>
                </div>
                {{-- End icon --}}

                {{-- Card --}}
                <div class="flex flex-col bg-white rounded-lg p-4 shadow-md border-l-2 border-indigo-400">
                    <div class="flex gap-1 items-center">
                        <div class="mr-1 shadow-md border-2 border-white w-8 h-8 bg-indigo-200 text-base p-2 rounded-full flex items-center justify-center">
                            <span class="font-bold text-sm">{{ isset($activity->user->name) ? $this->generateInitials($activity->user->name) : '' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex gap-1">
                                <div>
                                    <span class="font-bold">{{ isset($activity->user->name) ? $activity->user->name : 'Deleted user' }}</span>
                                    <span>{!! $activity->title !!}</span>
                                    <span class="text-gray-700 text-sm"> - {{ $this->activityTime($activity->created_at) }}</span>
                                </div>
                            </div>
                            @if($showPath)
                            <div class="text-sm text-gray-600">{!! $activity->path !!}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-2">{!! $activity->body !!}</div>
                </div>
                {{-- End card --}}
            </div>
        @endforeach

        @if ($showPages)
        {{ $activities->links('custom-pagination') }}
        @endif
    </div>

    {{-- MODALS --}}
    <livewire:global-components.file-details-modal />
    {{-- END MODALS --}}
</div>

