<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'space-x-1 bg-transparent-500 hover:bg-transparent-400 active:bg-transparent-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) 
    }}>
    <div class="text-black">{{ $icon ?? '' }}</div>
    <span class="font-bold text-black">{{ $slot ?? '' }}</span>
    <div class="text-black">{{ $trailingIcon ?? '' }}</div>
</button>