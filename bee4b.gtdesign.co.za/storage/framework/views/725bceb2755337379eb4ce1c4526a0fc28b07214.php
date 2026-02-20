<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
        <path d="M12 11v6"></path>
        <path d="M9.5 13.5l2.5 -2.5l2.5 2.5"></path>
     </svg>
    <span class="font-bold"><?php echo e($slot); ?></span>
</button><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/buttons/upload.blade.php ENDPATH**/ ?>