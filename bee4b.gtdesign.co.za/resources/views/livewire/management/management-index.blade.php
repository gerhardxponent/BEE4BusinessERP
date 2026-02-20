<div>
    <x-toast.success-event />

    {{-- <div class="flex flex-row justify-between items-center">
        <div class="text-2xl font-bold">Management Projects</div>

        <x-create-button wire:click="$set('showCreateProcessModal', true)">
            Create Processs
        </x-create-button>
    </div> --}}

    <div class="mt-4 w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($this->processes as $process)
            <a href="./management/{{ $process->id }}">
                <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 hover:scale-[1.03] transition-all hover:shadow-lg">
                    <div class="flex flex-row gap-4">
                        <div class="w-20 h-20 bg-indigo-500 rounded-md text-white p-4">
                                {!! isset($process->icon->svg) ? $process->icon->svg : '' !!}
                        </div>
                        <div class="flex flex-col justify-center gap-1">
                            <h1 class="text-xl">{{ $process->name }}</h1>
                            <p class="text-gray-500 text-sm">{{ count($process->boards) }} Total Projects</p>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>     

    {{-- <style>
        .icon-grid {
            max-height: 100px;
        }
    </style> --}}
    
    {{-- MODALS --}}
    <x-jet-dialog-modal wire:model="showCreateProcessModal">
        <x-slot name="title">New Management Process</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="name" value="Name" />
                    <x-jet-input type="text" id="name" wire:model.defer="newProcess.name" />
                    <span>@error('newProcess.name') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                </div>

                <div class="flex flex-row gap-4">
                    <div>
                        <x-jet-label for="icon" value="Icon" />
                        <div
                            style="max-height: 140px;" 
                            id="icon" 
                            class="bg-white grid grid-cols-4 gap-2 p-2 overflow-y-scroll border border-gray-300 rounded-md max-w-max"
                            >
                            @foreach ($icons as $icon)
                                <div 
                                    wire:click="setIcon({{ $icon->id }})"
                                    class="
                                        w-11 h-11 border border-gray-300 p-1 rounded-md active:scale-[0.9] active:bg-gray-100 transition-all cursor-pointer
                                        @if($newProcess->icon_id === $icon->id) bg-indigo-500 text-white @endif
                                    "
                                    >
                                    {!! $icon->svg !!}
                                </div>
                            @endforeach
                        </div>
                        <span>@error('newProcess.icon_id') <span class="text-red-500">{{ $message }}</span> @enderror</span>
                    </div>

                    {{-- <div>
                        <x-jet-label for="icon" value="Icon" />
                        <div id="icon" class="bg-white grid grid-cols-4 gap-2 p-2 overflow-y-scroll max-h-40 border border-gray-300 rounded-md max-w-max">
                            @foreach ($icons as $i => $icon)
                                <div 
                                    class="
                                        w-11 h-11 border border-gray-300 p-1 rounded-md active:scale-[0.9] active:bg-gray-100 transition-all hover:bg-gray-50 cursor-pointer
                                        @if($i === 1) bg-indigo-500 text-white @endif
                                    "
                                    >
                                    {!! $icon->svg !!}
                                </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="flex flex-row items-center justify-end gap-1">
                <x-buttons.cancel-button x-on:click="show = false">Cancel</x-buttons.cancel-button>
                <x-jet-button wire:click="createProcess">Create</x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    {{-- END MODALS --}}
</div>