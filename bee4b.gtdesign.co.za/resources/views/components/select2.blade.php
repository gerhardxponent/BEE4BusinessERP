@props([
    'defaultName' => 'Select Option',
    'options' => [],
    'id' => 'select2',
    'initial' => ''
])

<div
    x-data
    wire:ignore
    x-init = "() => {
        $('#{{ $id }}').select2();

        $('#{{ $id }}').on('change', function() {
            var data = $('#{{ $id }}').select2('val');
            @this.set('{{ $attributes['wire:model'] }}', data);
        });

        $('#{{ $id }}').val({{ $initial }}).trigger('change');
    }"
    >

    <style>
        .select2-container--default .select2-selection--single{
            border: 1px solid var(--color-gray-300);
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            border-radius: 0.375rem;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-left: 2px;
            height: 42px;
            font-size: 1em;  
            position: relative;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            color: #fff;
            font-size: 1.3em;
            padding: 4px 12px;
            position: absolute;
            top: 6px;
            bottom: 0;
            right: 0px;
            width: 20px;
        }

        /* .select2-dropdown {
            z-index: 1;
        } */

        .select2-dropdown.select2-dropdown--below {
            z-index: 99999 !important;
        }
    </style>

    <select id="{{ $id }}" style="width: 100%;" x-ref="select">
        <option value="">{{ $defaultName }}</option>
        @foreach($options as $index => $option)
        <option value="{{ $option->id }}">
            @if(isset($option->name))
            {{ $option->name }}
            @else
            {{ $option->firstname . ' ' . $option->lastname }}
            @endif
        </option>
        @endforeach
    </select>
</div>