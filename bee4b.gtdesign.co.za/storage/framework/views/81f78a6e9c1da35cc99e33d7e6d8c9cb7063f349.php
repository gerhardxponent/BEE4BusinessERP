<?php $attributes = $attributes->exceptProps([
    'current' => false,
    'click' => ''
]); ?>
<?php foreach (array_filter(([
    'current' => false,
    'click' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div 
    <?php echo e($attributes->class([
            'bg-indigo-500 hover:bg-indigo-500 text-white active:bg-indigo-500' => $current, 
            'text-gray-500 hover:bg-gray-300 active:bg-gray-400' => !$current,
            'transition-colors text-gray-500 rounded-md px-5 py-1 font-bold cursor-pointer'
        ])); ?>

    wire:click="<?php echo e($click); ?>"
    >
    <span class="text-sm"><?php echo e($slot); ?></span>
</div><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/components/tabs/tab.blade.php ENDPATH**/ ?>