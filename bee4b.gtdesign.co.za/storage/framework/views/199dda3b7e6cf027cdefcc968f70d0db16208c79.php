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

<svg width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M17.572 20.16c1.603 0 2.828-1.386 2.828-3v-9H3.6v9c0 1.614 1.226 3 2.829 3h11.143ZM9 10.56h6a.6.6 0 1 1 0 1.2H9a.6.6 0 1 1 0-1.2Zm-5.64-7.2a.96.96 0 0 0-.96.96v1.44a.96.96 0 0 0 .96.96h17.28a.96.96 0 0 0 .96-.96V4.32a.96.96 0 0 0-.96-.96H3.36Z"></path>
</svg><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/icons/archive-filled.blade.php ENDPATH**/ ?>