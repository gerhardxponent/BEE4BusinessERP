<?php $attributes = $attributes->exceptProps([
    'colour' => 'indigo'
]); ?>
<?php foreach (array_filter(([
    'colour' => 'indigo'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<button <?php echo e($attributes->merge([
    'type' => 'submit', 
    'class' => 'space-x-1 bg-'.$colour.'-50 hover:bg-'.$colour.'-100 active:bg-'.$colour.'-300 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-'.$colour.'-900 uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'
    ])); ?>>
    <div><?php echo e($icon ?? ''); ?></div>
    <span class="font-bold"><?php echo e($slot ?? ''); ?></span>
    <div><?php echo e($trailingIcon ?? ''); ?></div>
</button><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/components/buttons/flat.blade.php ENDPATH**/ ?>