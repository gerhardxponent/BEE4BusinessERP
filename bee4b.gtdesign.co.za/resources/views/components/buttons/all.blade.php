<button {{ $attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-blue-500 hover:bg-blue-400 active:bg-blue-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    <x-icons.eye size="20" />
    <span class="font-bold">{{ $slot }}</span>
</button>