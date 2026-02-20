<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-transparent-500 hover:bg-transparent-400 active:bg-transparent-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" stroke-opacity="0" class="icon icon-tabler icon-tabler-x" width="0" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke-opacity="0" stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <line stroke-opacity="0" x1="18" y1="6" x2="6" y2="18"></line>
        <line stroke-opacity="0" x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
    
    <span class="font-bold text-gray-800"><?php echo e($slot); ?></span>
</button><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/buttons/cancel-button.blade.php ENDPATH**/ ?>