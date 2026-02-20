<button
    wire:click="toggle"
    class="inline-flex items-center justify-center rounded p-2 transition active:scale-95"
    title="{{ $flagged ? 'Clear red flag' : 'Mark as red flagged' }}"
    aria-pressed="{{ $flagged ? 'true' : 'false' }}"
>
  {{-- simple flag icon (SVG) --}}
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
       class="h-6 w-6"
       fill="{{ $flagged ? '#EF4444' : 'none' }}"
       stroke="{{ $flagged ? '#EF4444' : '#9CA3AF' }}"
       stroke-width="1.5">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M3.5 3.5v13m0-11.5c2.5-1.5 4.5-1.5 7 0s4.5 1.5 7 0v9c-2.5 1.5-4.5 1.5-7 0s-4.5-1.5-7 0V2z"/>
  </svg>
</button>
