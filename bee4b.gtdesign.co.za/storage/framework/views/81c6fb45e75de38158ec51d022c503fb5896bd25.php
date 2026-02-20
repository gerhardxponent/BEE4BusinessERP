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
    'class' => 'space-x-1 hover:bg-'.$colour.'-100 active:bg-'.$colour.'-200 inline-flex p-2 items-center border border-transparent rounded-md font-semibold text-xs text-'.$colour.'-600 uppercase tracking-widest disabled:opacity-25 transition'
    ])); ?>>
    <div><?php echo e($slot ?? ''); ?></div>
    

    <div class="hover:bg-indigo-100 active:bg-indigo-200 hidden"></div>
</button><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/buttons/icon.blade.php ENDPATH**/ ?>