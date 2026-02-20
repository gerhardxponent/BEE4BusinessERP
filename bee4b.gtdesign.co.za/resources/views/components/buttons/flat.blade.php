@props([
    'colour' => 'indigo'
])

<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'space-x-1 bg-'.$colour.'-50 hover:bg-'.$colour.'-100 active:bg-'.$colour.'-300 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-'.$colour.'-900 uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'
    ]) }}>
    <div>{{ $icon ?? '' }}</div>
    <span class="font-bold">{{ $slot ?? '' }}</span>
    <div>{{ $trailingIcon ?? '' }}</div>
</button>