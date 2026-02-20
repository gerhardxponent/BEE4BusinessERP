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
  <path d="M9 2a1 1 0 0 1 1 1v1h4V3a1 1 0 0 1 2 0v1h3a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3V3a1 1 0 0 1 1-1ZM8 6H5v3h14V6h-3v1a1 1 0 0 1-2 0V6h-4v1a1 1 0 0 1-2 0V6Zm11 5H5v8h14v-8Z"></path>
</svg><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/icons/calendar.blade.php ENDPATH**/ ?>