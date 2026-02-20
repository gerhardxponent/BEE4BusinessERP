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
    <path d="M3.304 4.123a2.4 2.4 0 0 0-.843 1.343l9.54 5.83 9.54-5.83A2.4 2.4 0 0 0 19.2 3.6H4.8a2.4 2.4 0 0 0-1.497.523Z"></path>
    <path d="M2.4 15.36V6.837l6.964 4.255-6.964 4.27Z"></path>
    <path d="m2.63 16.627 7.884-4.83 1.487.906 1.487-.908.44.27A5.389 5.389 0 0 0 12 16.2a5.383 5.383 0 0 0 .307 1.8H4.8a2.4 2.4 0 0 1-2.171-1.373Z"></path>
    <path d="M21.6 12.805v-5.97l-6.963 4.256.405.248a5.39 5.39 0 0 1 2.358-.54 5.39 5.39 0 0 1 4.2 2.006Z"></path>
    <path fill-rule="evenodd" d="M20.37 19.17a4.2 4.2 0 1 0-5.94-5.94 4.2 4.2 0 0 0 5.94 5.94Zm-3.394-5.194A.6.6 0 0 1 18 14.4v1.2h1.2a.6.6 0 1 1 0 1.2H18V18a.6.6 0 1 1-1.2 0v-1.2h-1.2a.6.6 0 1 1 0-1.2h1.2v-1.2a.6.6 0 0 1 .176-.424Z" clip-rule="evenodd"></path>
</svg><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/icons/mail-solid.blade.php ENDPATH**/ ?>