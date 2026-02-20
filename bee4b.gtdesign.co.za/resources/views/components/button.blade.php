@props([
    'colour' => 'indigo'
])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-'.$colour.'-600 hover:bg-'.$colour.'-400 active:bg-'.$colour.'-700 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    <span class="font-bold">{{ $slot }}</span>
</button>