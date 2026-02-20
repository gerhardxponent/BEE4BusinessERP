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

<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-clockwise-2" width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <path d="M9 4.55a8 8 0 0 1 6 14.9m0 -4.45v5h5"></path>
    <line x1="5.63" y1="7.16" x2="5.63" y2="7.17"></line>
    <line x1="4.06" y1="11" x2="4.06" y2="11.01"></line>
    <line x1="4.63" y1="15.1" x2="4.63" y2="15.11"></line>
    <line x1="7.16" y1="18.37" x2="7.16" y2="18.38"></line>
    <line x1="11" y1="19.94" x2="11" y2="19.95"></line>
</svg><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/icons/pending.blade.php ENDPATH**/ ?>