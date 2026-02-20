<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="12" y1="5" x2="12" y2="19" />
        <line x1="5" y1="12" x2="19" y2="12" />
    </svg>
    <span class="font-bold"><?php echo e($slot); ?></span>
</button><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/create-button.blade.php ENDPATH**/ ?>