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

<button <?php echo e($attributes->merge(['type' => 'submit', 'class' => 'space-x-1 bg-'.$colour.'-600 hover:bg-'.$colour.'-400 active:bg-'.$colour.'-700 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition'])); ?>>
    <span class="font-bold"><?php echo e($slot); ?></span>
</button><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/button.blade.php ENDPATH**/ ?>