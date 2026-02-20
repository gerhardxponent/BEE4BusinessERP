<?php $attributes = $attributes->exceptProps([
    'width' => '24',
    'height' => '24',
]); ?>
<?php foreach (array_filter(([
    'width' => '24',
    'height' => '24',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<svg width="<?php echo e($width); ?>" height="<?php echo e($height); ?>" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M3.5 5.5 5 7l2.5-2.5"></path>
  <path d="M3.5 11.5 5 13l2.5-2.5"></path>
  <path d="M3.5 17.5 5 19l2.5-2.5"></path>
  <path d="M11 6h9"></path>
  <path d="M11 12h9"></path>
  <path d="M11 18h9"></path>
</svg><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/icons/audit.blade.php ENDPATH**/ ?>