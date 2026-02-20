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

<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box-seam" width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5"></path>
    <path d="M12 12l8 -4.5"></path>
    <path d="M8.2 9.8l7.6 -4.6"></path>
    <path d="M12 12v9"></path>
    <path d="M12 12l-8 -4.5"></path>
</svg><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/icons/box.blade.php ENDPATH**/ ?>