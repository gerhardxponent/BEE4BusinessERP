<button {{ $attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-sky-500 hover:bg-sky-400 active:bg-sky-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cloud-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1"></path>
        <polyline points="9 15 12 12 15 15"></polyline>
        <line x1="12" y1="12" x2="12" y2="21"></line>
     </svg>
    <span class="font-bold">{{ $slot }}</span>
</button>