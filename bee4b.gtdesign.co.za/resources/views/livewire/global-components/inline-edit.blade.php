<div
    x-data="{
        isEditing: false,
        showError: false,
        regex: @entangle('regex'),
        type: @entangle('type'),
        focus: function() {
            setTimeout(() => {
                const textInput = this.$refs.textInput;
                textInput.focus();
                textInput.select();
            }, 120);
        },
        validate: function() {
            if (this.type === 'select2') {
                this.isEditing = false;
            } else {
                const regex = new RegExp(this.regex);
                const str = this.$refs.textInput.value;

                if (str.match(regex) === null) {
                    this.showError = true;
                } else {
                    this.isEditing = false;
                    this.showError = false;
                }
            }
        }
    }"
    x-cloak
    style="width: 500px"
    >
    <div x-show="!isEditing">
        <div
            @if($permission === '' || Auth::user()->hasPermissionTo($permission)) 
            x-on:click="() => {
                isEditing = true;
                if($refs.textInput) 
                    focus();
            }" 
            @endif
            class="hover:underline cursor-pointer"
            >
            @if($origName === null || $origName === '')
            <div class="text-gray-500 underline cursor-pointer">Set...</div>
            @else
            <div class="group flex gap-1 @if($alignCenter) justify-center @endif">
                @if($type === 'date')
                <span>{!! Carbon\Carbon::parse($origName)->format($dateFormat) !!}</span>
                @elseif ($type === 'select2')
                <span>{!! $selectOrigName !!}</span>
                @else
                <span>{!! $origName !!}</span>
                @endif
                <span class="hidden group-hover:block">
                    <x-icons.pencil size="20" />
                </span>                    
            </div>
            @endif
        </div>
    </div>

    <div x-show="isEditing" class="flex flex-col text-black">
        <form class="flex" wire:submit.prevent="save">
            @switch($type)
                @case('textarea')
                    <x-textarea
                        id="{{ $lineID }}"
                        type="text"
                        x-ref="textInput"
                        wire:model.lazy="newName"
                        rows="5"
                        x-on:keydown.enter="validate()"
                        x-on:keydown.escape="isEditing = false"
                        >
                    </x-textarea>
                    @break
                    
                @case('date')
                    <x-jet-input 
                        id="{{ $lineID }}"
                        type="date" 
                        x-ref="textInput"
                        wire:model.lazy="newName" 
                        x-on:keydown.enter="validate()"
                        x-on:keydown.escape="isEditing = false"
                    />
                    {{-- <x-input.flatpickr 
                        id="{{ $lineID }}" 
                        x-ref="textInput"
                        wire:model.lazy="newName" 
                        x-on:keydown.enter="validate()"
                        x-on:keydown.escape="isEditing = false"
                    /> --}}
                    @break

                @case('select2')
                    <x-select2-multiple 
                        id="{{ $lineID }}-select2"
                        wire:model="newName"  
                        wire:key="{{ $lineID }}-jasaljsdhjksad"
                        >
                        <option value="">Select Responsible Person</option>
                        @foreach($options as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select2-multiple>
                    @break

                @default
                    <x-jet-input 
                        id="{{ $lineID }}"
                        type="text"
                        x-ref="textInput"
                        wire:model.lazy="newName"
                        x-on:keydown.enter="validate()"
                        x-on:keydown.escape="isEditing = false"
                    />                    
            @endswitch

            {{-- <x-validation-error field="newName" /> --}}

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
        
        @if ($type === 'line')
            <small class="text-xs text-gray-600">Enter to save, Esc to cancel</small>
        @endif

        <div x-show="showError" class="text-red-500 text-sm">The name cannot contain slashes or underscores.</div>
    </div>
</div>