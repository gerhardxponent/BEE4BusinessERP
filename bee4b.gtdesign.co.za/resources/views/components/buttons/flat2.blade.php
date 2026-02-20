<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'flex justify-start items-center text-gray-700 hover:bg-gray-200 active:bg-gray-300 p-2 rounded-lg cursor-pointer'
    ]) }}>
    <div>{{ $icon ?? '' }}</div>
    <span class="font-bold">{{ $slot ?? '' }}</span>
    <div>{{ $trailingIcon ?? '' }}</div>
</button>