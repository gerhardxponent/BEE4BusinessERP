<div
    x-data="{
        isEditing: false,
        focus: function() {
            setTimeout(() => {
                const selectInput = this.$refs.selectInput;
                selectInput.focus();
                selectInput.select();
            }, 120);
        },
        validate: function() {
            this.isEditing = false;
        }
    }"
    x-cloak
    class="w-100"
>
    <div x-show="!isEditing">
        <div
            {{-- @if($permission === '' || Auth::user()->hasPermissionTo($permission))  --}}
            x-on:click="() => {
                isEditing = true;
                if($refs.textInput) 
                    focus();
            }" 
            {{-- @endif --}}
            class="hover:underline cursor-pointer"
            >
            @if($valueId === null || $valueId === '')
            <div class="text-gray-500 underline cursor-pointer">Set...</div>
            @else
            <div class="group flex gap-1">
                <span>{{ $valueText }}</span>
                <span class="hidden group-hover:block">
                    <x-icons.pencil size="20" />
                </span>                    
            </div>
            @endif
        </div>
    </div>

    <div x-show="isEditing" class="flex flex-col text-black">
        <form class="flex" wire:submit.prevent="save">
            <x-select2-multiple 
                id="{{ $itemId }}-select2"
                wire:model.defer="valueId"  
                wire:key="{{ $itemId }}-jasaljsdhjksad"
                >
                <option value="">Please select an option</option>
                @foreach($options as $option)
                <option value="{{ $option->id }}">{{ $option->name }}</option>
                @endforeach
            </x-select2-multiple>

            <div class="flex flex-row justify-center items-center ml-1 gap-1">
                <button type="button" class="p-1 text-red-600 bg-red-100 active:bg-red-300 transition-colors rounded-md flex justify-center items-center" title="Cancel" x-on:click="isEditing = false">
                    <x-icons.close size="20" />
                </button>
                <button
                    type="submit"
                    class="p-1 text-green-600 bg-green-100 active:bg-green-300 transition-colors rounded-md flex justify-center items-center"
                    title="Save"
                    {{-- x-on:click="isEditing = false" --}}
                    x-on:click="validate()"
                    >
                    <x-icons.check size="20" />
                </button>
            </div>
        </form>
    </div>
</div>