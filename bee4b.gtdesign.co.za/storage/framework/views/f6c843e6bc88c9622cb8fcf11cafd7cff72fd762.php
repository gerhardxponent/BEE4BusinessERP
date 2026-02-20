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

<svg fill="currentColor" width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path d="M10 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8ZM4 8a6 6 0 1 1 12 0A6 6 0 0 1 4 8Zm12.828-4.243a1 1 0 0 1 1.415 0 6 6 0 0 1 0 8.486 1 1 0 0 1-1.415-1.415 4 4 0 0 0 0-5.656 1 1 0 0 1 0-1.415Zm.702 13a1 1 0 0 1 1.212-.727c1.328.332 2.169 1.18 2.652 2.148.468.935.606 1.98.606 2.822a1 1 0 0 1-2 0c0-.657-.112-1.363-.394-1.928-.267-.533-.677-.934-1.349-1.102a1 1 0 0 1-.727-1.212v-.001ZM6.5 18C5.24 18 4 19.213 4 21a1 1 0 1 1-2 0c0-2.632 1.893-5 4.5-5h7c2.607 0 4.5 2.368 4.5 5a1 1 0 0 1-2 0c0-1.787-1.24-3-2.5-3h-7Z"></path>
</svg><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/icons/consultation.blade.php ENDPATH**/ ?>