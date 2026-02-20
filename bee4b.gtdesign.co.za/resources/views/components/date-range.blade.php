@props(['options' => []])

@php
    $options = 
        array_merge([
            'dateFormat' => 'Y-m-d',
            'enableTime' => false,
            'altFormat' =>  'j F Y',
            'altInput' => true
        ], $options);
@endphp

<div wire:ignore>
    <style>
        .flatpickr-date {
            background-color: #F4F4F4;
        }
    </style>

    <input 
        class="flatpickr-date w-full py-3 border-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-xl shadow-sm"
        x-data="{
                init() {
                    let inputEl = flatpickr(
                        this.$refs.input, 
                        {{ json_encode((object)$options) }}
                    );

                    $('.document').ready(function() {
                        Livewire.on('clear_flatpickr', function() {
                            inputEl.clear();
                        })
                    });
                }
            }"
            x-ref="input"
            type="text"
            wire:model.lazy="{{ $attributes['wire:model.lazy'] }}"
            placeholder="Select date"
        {{-- {{ $attributes->merge(['class' => 'form-input w-full rounded-md shadow-sm']) }} --}}
    />
</div>