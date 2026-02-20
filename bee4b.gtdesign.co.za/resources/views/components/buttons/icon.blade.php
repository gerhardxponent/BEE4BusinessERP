@props([
    'colour' => 'indigo'
])

<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'space-x-1 hover:bg-'.$colour.'-100 active:bg-'.$colour.'-200 inline-flex p-2 items-center border border-transparent rounded-md font-semibold text-xs text-'.$colour.'-600 uppercase tracking-widest disabled:opacity-25 transition'
    ]) }}>
    <div>{{ $slot ?? '' }}</div>
    {{-- <span class="font-bold">{{ $slot ?? '' }}</span>
    <div>{{ $trailingIcon ?? '' }}</div> --}}

    <div class="hover:bg-indigo-100 active:bg-indigo-200 hidden"></div>
</button>