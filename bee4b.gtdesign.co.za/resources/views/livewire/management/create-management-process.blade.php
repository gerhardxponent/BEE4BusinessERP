<div class="space-y-6">
    <x-back>all Processes</x-back>

    <div class="text-2xl">New Management Process</div>

    <div class="space-y-2">
        <div class="w-1/2">
            <x-jet-label for="name" value="Name" />
            <x-jet-input type="text" id="name" wire:model.defer="newProcess.name" />
        </div>

        <div class="w-1/2">
            <x-jet-label for="icon" value="Icon" />
            <x-select id="icon" wire:model.defer="newProcess.icon_id">
                <option value="">Please select an icon...</option>
            @foreach ($icons as $icon)
                <option value="{{ $icon->id }}">{{ $icon->name }}</option>
            @endforeach
            </x-select>

            <div class="p-4 bg-white flex flex-row items-start flex-wrap h-40 w-1/3 overflow-y-scroll gap-2">
                @foreach ($icons as $i => $icon)
                    <div 
                        class="
                            w-11 h-11 border border-gray-300 p-1 rounded-md active:scale-[0.9] active:bg-gray-100 transition-all
                            @if($i === 1) bg-indigo-500 text-white @endif
                        "
                        >
                        {!! $icon->svg !!}
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <x-jet-button wire:click="createProcess">Create Process</x-jet-button>
        </div>
    </div>
</div>
