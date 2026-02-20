<?php $attributes = $attributes->exceptProps([
    'width' => '24',
    'height' => '24',
    'size' => null
]); ?>
<?php foreach (array_filter(([
    'width' => '24',
    'height' => '24',
    'size' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<svg xmlns="http://www.w3.org/2000/svg" width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <line x1="5" y1="12" x2="19" y2="12"></line>
    <line x1="13" y1="18" x2="19" y2="12"></line>
    <line x1="13" y1="6" x2="19" y2="12"></line>
</svg><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/components/icons/right-arrow.blade.php ENDPATH**/ ?>