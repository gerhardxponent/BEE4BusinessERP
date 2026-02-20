<button <?php echo e($attributes->merge([
    'type' => 'submit', 
    'class' => 'flex justify-start items-center text-gray-700 hover:bg-gray-200 active:bg-gray-300 p-2 rounded-lg cursor-pointer'
    ])); ?>>
    <div><?php echo e($icon ?? ''); ?></div>
    <span class="font-bold"><?php echo e($slot ?? ''); ?></span>
    <div><?php echo e($trailingIcon ?? ''); ?></div>
</button><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/buttons/flat2.blade.php ENDPATH**/ ?>