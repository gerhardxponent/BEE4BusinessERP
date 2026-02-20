@inject('helperClass','PowerComponents\LivewirePowerGrid\Helpers\Helpers')
@props([
    'primaryKey' => null,
    'row' => null,
    'field' => null,
    'theme' => null,
    'currentTable' => null,
    'tableName' => null,
    'type' => null,
    'dropdownOptions' => null,
])

<div 
    x-cloak
    {{-- x-data="
        pgEditable({
            tableName: '{{ $tableName }}',
            id: '{{ $row->{$primaryKey} }}',
            dataField: '{{ $field }}',
            content: '{{ $helperClass->resolveContent($currentTable, $field, $row) }}'
        })" --}}

    @if ($type == 'date')
    x-init="flatpickr($($refs.editable))"
    @endif

    x-data="{
        ...pgEditable({
            tableName: '{{ $tableName }}',
            id: '{{ $row->{$primaryKey} }}',
            dataField: '{{ $field }}',
            content: '{{ $helperClass->resolveContent($currentTable, $field, $row) }}'
        }),
        saveFunc(newContent, val = $refs.editable.value) {
            if ($refs.editable == '' || val == '') {
                this.content = '';

                this.$wire.emit('pg:editable-' + this.tableName, {
                    id: this.id,
                    value: null,
                    field: this.dataField
                });

                this.editable = false;
                return;
            }

            document.getElementsByClassName('message')[0].style.display = 'none';

            this.$wire.emit('pg:editable-' + this.tableName, {
                id: this.id,
                value: val,
                field: this.dataField
            });

            this.editable = false;
            this.content = newContent;
        },
    }"
    >
    @switch($type)
            @case('select')
                <div 
                    x-show="editable" 
                    x-trap="editable"
                    class="flex gap-1 items-center"
                    >
                    <x-select
                        x-on:keydown.escape="editable = false"
                        x-on:keydown.enter="saveFunc($el.options[$el.selectedIndex].text)"
                        x-ref="editable"
                    >
                        <option value="" selected>Select Value</option>
                        @foreach ($dropdownOptions as $index => $value)
                            <option
                                value="{{ $index }}"
                                @if($helperClass->resolveContent($currentTable, $field, $row) == $value) selected @endif
                                >
                                {{ $value }}
                            </option>
                        @endforeach
                    </x-select>

                    <div class="flex gap-1">
                        <div class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer" x-on:click="saveFunc($refs.editable.options[$refs.editable.selectedIndex].text)">
                            <x-icons.check />
                        </div>
                        <div class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" x-on:click="editable = false;">
                            <x-icons.close />
                        </div>
                    </div>
                </div>
            @break
    
            @case('date')
                <div x-show="editable" x-trap="editable" class="flex items-center gap-1">
                    {{-- <input
                        type="date"
                        x-on:keydown.enter="() => {
                            saveFunc($el.value);
                        }"
                        x-on:keydown.escape="editable = false"
                        :class="{'cursor-pointer': !editable}"
                        class="{{ $theme->inputClass }} p-2"
                        x-ref="editable"
                        value="{{ $helperClass->resolveContent($currentTable, $field, $row) }}"
                    /> --}}

                    <input 
                        class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
                        x-ref="editable"
                        type="text"
                        value="{{ $helperClass->resolveContent($currentTable, $field, $row) }}"
                        placeholder="Select date"
                        x-on:keydown.enter="saveFunc($el.value)"
                        x-on:keydown.escape="editable = false"
                    />

                    <div class="flex gap-1">
                        <div x-on:click="saveFunc($refs.editable.value)" class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer">
                            <x-icons.check />
                        </div>
                        <div x-on:click="editable = false;" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" >
                            <x-icons.close />
                        </div>
                    </div>
                </div>
            @break

            @case('month')
                <div 
                    x-show="editable" 
                    x-trap="editable"
                    class="flex gap-1 items-center"
                    >
                    <input
                        type="month"
                        x-on:keydown.enter="saveFunc(
                            new Date(Date.parse($el.value)).toLocaleDateString('en-us', { year: 'numeric', month: 'short' }), 
                            $refs.editable.value != '' ? $refs.editable.value + '-01' : ''
                        )"
                        x-on:keydown.escape="editable = false"
                        :class="{'cursor-pointer': !editable}"
                        class="{{ $theme->inputClass }} p-2"
                        x-ref="editable"
                        x-text="content"
                        value="2022-12"
                    />

                    <div class="flex gap-1">
                        <div 
                            x-on:click="saveFunc(
                                new Date(Date.parse($refs.editable.value)).toLocaleDateString('en-us', { year: 'numeric', month: 'short' }), 
                                $refs.editable.value != '' ? $refs.editable.value + '-01' : ''
                            )" 
                            class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer"
                            >
                            <x-icons.check />
                        </div>
                        <div x-on:click="editable = false;" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer">
                            <x-icons.close />
                        </div>
                    </div>
                </div>
            @break

            @default
                <div 
                    x-show="editable"
                    class="flex gap-1 items-center"
                    >
                    <input
                        type="text"
                        x-on:keydown.enter="saveFunc($refs.editable.value)"
                        x-on:keydown.escape="editable = false"
                        :class="{'cursor-pointer': !editable}"
                        class="{{ $theme->inputClass }} p-2"
                        x-ref="editable"
                        value="{{ $helperClass->resolveContent($currentTable, $field, $row) }}"
                    />

                    <div class="flex gap-1">
                        <div x-on:click="saveFunc($refs.editable.value)" class="p-1 rounded-md bg-green-100 hover:bg-green-200 active:bg-green-300 text-green-900 cursor-pointer">
                            <x-icons.check />
                        </div>
                        <div x-on:click="() => { editable = false; $refs.editable.value = content; }" class="p-1 rounded-md bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-900 cursor-pointer" >
                            <x-icons.close />
                        </div>
                    </div>
                </div>
    @endswitch

    <div
        x-on:click="editable = true; setTimeout(() => { $refs.editable.focus(); }, 120);" 
        x-show="content == '' && !editable"
        class="cursor-pointer text-gray-400"
        >
        Set...
    </div>

    <div 
        x-html="content"
        x-ref="testRef"
        class="border-b border-gray-400 cursor-pointer"
        x-show="!editable"
        x-on:click="() => {
            editable = true;
            setTimeout(() => $refs.editable.nodeName == 'SELECT' ? $refs.editable.focus() : $refs.editable.select(), 120);
        }"
    >
    </div>

    <div x-show="editable" class="text-xs text-gray-500">
        Press Enter to save and Esc to cancel
    </div>

    {{-- <div x-show="editable">
        <input
            type="text"
            x-on:keydown.enter="save()"
            :class="{'cursor-pointer': !editable}"
            class="{{ $theme->inputClass }} p-2"
            x-ref="editable"
            x-text="content"
            :value="$root.firstElementChild.innerText">
    </div> --}}
</div>
