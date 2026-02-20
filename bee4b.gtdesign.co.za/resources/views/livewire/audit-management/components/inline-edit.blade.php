<div
    x-data="
        {
            isEditing: false,
            isName: false,
            focus: function() {
                const textInput = this.$refs.textInput;
                textInput.focus();
                textInput.select();
            }
        }
    "
    x-cloak
    >
    <div x-show="!isEditing"> 
        <div 
            class="cursor-pointer underline"
            x-bind:class="{ 'font-bold':isName }"
            @if ($permission === '')
                x-on:click="isEditing = true;"
            @else
                @can($permission)
                    x-on:click="isEditing = true;"
                @endcan
            @endif
            >
            @if($auditFile->attributesToArray()[$field])
            {{-- {{ dd(Carbon\Carbon::parse($auditFile->attributesToArray()[$field])->format('d M y')) }} --}}
            <div>{{ Str::limit($auditFile->attributesToArray()[$field], 30) }}</div>
            {{-- <div>{{ Carbon\Carbon::parse($auditFile->attributesToArray()[$field])->format('d M y') }}</div> --}}
            @else
            <div>Set...</div>
            @endif
        </div>
    </div>

    <div x-show="isEditing" >
        @if($type != 'textarea')
        <x-jet-input 
            x-ref="fieldInput"
            wire:model.defer="auditFile.{{ $field }}" 
            type="{{ $type }}" 
            {{-- x-ref="textInput"  --}}
            x-on:keydown.enter="isEditing = false" 
            x-on:keydown.escape="isEditing = false" 
        />
        @else
        <x-textarea
            wire:model.defer="auditFile.{{ $field }}" 
            {{-- x-ref="textInput"  --}}
            x-on:keydown.enter="isEditing = false" 
            x-on:keydown.escape="isEditing = false" 
            >
        </x-textarea>
        @endif

        <div>
            <button x-on:click="isEditing = false" wire:click="save">
            <x-icons.check />
        </button>

        <button 
            x-on:click="
                (() => {
                    let value = $refs.fieldInput?.value;
                    if (value && confirm('Apply this date to all other files in the section?')) {
                        $wire.applyDueDatesToOthers({{ $auditFile->id }}, { {{ $field }}: value }).then(() => {
                            window.location.reload();
                        });
                    }
                })()
            "
            type="button" 
            title="Apply to others" 
            class="ml-2 text-sm text-blue-600 underline"
        >
            Apply to others
        </button>

        </div>
    </div>
</div>
