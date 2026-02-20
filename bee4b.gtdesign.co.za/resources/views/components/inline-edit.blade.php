@props([
    'original' => '',
    'originalPlaceholder' => '',
    'model' => '',
    'entityId' => '',
    'field' => '',
    'name' => '',
    'type' => 'text',
    'id' => 'test',
    'options' => null,
    'initial' => []
])

<div 
    wire:ignore
    @if($type == 'date')
    x-init="() => {
        let inputEl = flatpickr(
            $('#{{ $id }}'),
        );

        $('.document').ready(function() {
            Livewire.on('clear_flatpickr', function() {
                inputEl.clear();
            })
        });
    }"
    @endif

    @if($type == 'select2')
    x-init="() => {
        select2 = $('#{{ $id }}')
            .not('.select2-hidden-accessible')
            .select2({
                width: '100%',
            });

        select2.val(@json($initial)).trigger('change');
    }"
    @endif
    x-data="{ 
        editing: false,
        focus() {
            this.editing = true;
            setTimeout(() => $refs.input.select(), 120);
        },
        save() {
            Livewire.emit('update:{{ $name }}', $refs.input.value, '{{ $model }}', '{{ $entityId }}', '{{ $field }}');
            $refs.original.innerHTML = $refs.input.value;
            this.editing = false;
        },
        cancel() {
            this.editing = false;
            $refs.input.value = '{{ $original }}';
        },
        test() {
            console.log(@json($initial));
        }
    }"
    >

    <div 
        x-show="!editing"
        x-on:click="focus"
        x-ref="original" 
        class="hover:underline cursor-pointer"
        >
        {{ $originalPlaceholder != '' ? $originalPlaceholder : $original }}
    </div>

    <div x-show="editing" class="flex gap-2">
        @switch($type)
            @case('date')
                {{-- <x-jet-input 
                    type="date" 
                    value="{{ $original }}" 
                    x-ref="input" 
                    id="{{ $id }}"
                    x-on:keydown.enter="save"
                    x-on:keydown.escape="cancel"
                /> --}}
                <input 
                    class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                    id="{{ $id }}"
                    x-ref="input"
                    type="text"
                    value="{{ $original }}"
                    placeholder="Select date"
                    x-on:keydown.enter="save"
                    x-on:keydown.escape="cancel"
                />
                @break
            
            @case('select2')
                <select x-ref="input" id="{{ $id }}" multiple>
                    @foreach($options as $option)
                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </select>
                @break
        
            @default
                <x-jet-input 
                    type="text" 
                    value="{{ $original }}" 
                    x-ref="input" 
                    x-on:keydown.enter="save"
                    x-on:keydown.escape="cancel"
                />
        @endswitch

        {{-- <x-button x-on:click="test()">TEST BUTTON</x-button> --}}

        <div class="flex gap-2 items-center">
            <button 
                x-on:click="save" 
                class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer"
                >
                <x-icons.check />
            </button>
            <button 
                x-on:click="cancel"
                class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer"
                >
                <x-icons.close />
            </button>
        </div>
    </div>
</div>