<button
    wire:click="toggle"
    class="inline-flex items-center justify-center rounded p-2 transition active:scale-95"
    title="<?php echo e($flagged ? 'Clear red flag' : 'Mark as red flagged'); ?>"
    aria-pressed="<?php echo e($flagged ? 'true' : 'false'); ?>"
>
  
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
       class="h-6 w-6"
       fill="<?php echo e($flagged ? '#EF4444' : 'none'); ?>"
       stroke="<?php echo e($flagged ? '#EF4444' : '#9CA3AF'); ?>"
       stroke-width="1.5">
    <path stroke-linecap="round" stroke-linejoin="round"
          d="M3.5 3.5v13m0-11.5c2.5-1.5 4.5-1.5 7 0s4.5 1.5 7 0v9c-2.5 1.5-4.5 1.5-7 0s-4.5-1.5-7 0V2z"/>
  </svg>
</button>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/boards/red-flag.blade.php ENDPATH**/ ?>