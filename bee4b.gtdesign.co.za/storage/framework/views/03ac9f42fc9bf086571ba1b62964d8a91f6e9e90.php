<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-sky-500 hover:bg-sky-400 active:bg-sky-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-telegram" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4"></path>
     </svg>
    <span class="font-bold"><?php echo e($slot); ?></span>
</button><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/buttons/send.blade.php ENDPATH**/ ?>