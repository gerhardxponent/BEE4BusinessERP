@props([
    'placeholder' => 'Search'
])

<div 
    class="relative"
    x-data="{
        searchString: @entangle($attributes->wire('model')),
    }"
    >
    {{-- <x-jet-input class="bg-gray-200" type="text" placeholder="{{ $placeholder }}" wire:model.delay.500ms="searchString" /> --}}
    
    <input 
        type="text" 
        class="w-full px-6 py-3 border-none placeholder-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
        style="background-color: #E7E7E7;"
        placeholder="{{ $placeholder }}"
        wire:model.delay.500ms="searchString"
    />

    <button 
        class="bg-gray-600 hover:bg-gray-700 active:bg-gray-800 font-bold p-1 text-white rounded-full absolute right-6 top-1/2 -translate-y-1/2" 
        x-on:click="searchString = ''"
        x-show="searchString != ''"
        >
        <x-icons.close width="15" height="15" />
    </button>

    <div 
        class="text-gray-600 absolute right-6 top-1/2 -translate-y-1/2" 
        x-on:click="searchString = ''"
        x-show="searchString == ''"
        >
        <x-icons.search size="20" />
    </div>
</div>