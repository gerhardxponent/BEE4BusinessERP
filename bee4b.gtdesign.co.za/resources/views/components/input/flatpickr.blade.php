@props([
    'options' => [],
    'id' => 'flatpickr',
    'tabindex' => null
])

@php
    $options = 
        array_merge([
            'dateFormat' => 'Y-m-d',
            'enableTime' => false,
            'altFormat' =>  'j F Y',
            'altInput' => true
        ], $options);
@endphp

<div
    wire:ignore
    x-init="() => {
        let inputEl = flatpickr(
            $('#{{ $id }}'),
            {{ json_encode((object)$options) }}
        );

        $('.document').ready(function() {
            Livewire.on('clear_flatpickr', function() {
                inputEl.clear();
            })
        });
    }"
    >
    <input 
        class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
        id="{{ $id }}"
        x-ref="input"
        type="text"
        wire:model.defer="{{ $attributes['wire:model.defer'] }}"
        placeholder="Select date"
        tabindex="{{ $tabindex }}"
    />
</div>