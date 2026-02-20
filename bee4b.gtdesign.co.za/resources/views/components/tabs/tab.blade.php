@props([
    'current' => false,
    'click' => ''
])

<div 
    {{  
        $attributes->class([
            'bg-indigo-500 hover:bg-indigo-500 text-white active:bg-indigo-500' => $current, 
            'text-gray-500 hover:bg-gray-300 active:bg-gray-400' => !$current,
            'transition-colors text-gray-500 rounded-md px-5 py-1 font-bold cursor-pointer'
        ])
    }}
    wire:click="{{ $click }}"
    >
    <span class="text-sm">{{ $slot }}</span>
</div>