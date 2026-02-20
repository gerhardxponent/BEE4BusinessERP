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

<svg width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M10.798 6.975a.172.172 0 0 1 .242.161V8.52a.6.6 0 0 0 .6.6c.8 0 2.416.006 3.96.986 1.181.749 2.388 2.112 3.114 4.651-1.224-1.18-2.621-1.819-3.845-2.159a10.486 10.486 0 0 0-2.306-.367 8.893 8.893 0 0 0-.957.01h-.016l-.006.001h-.001l.057.598-.06-.598a.6.6 0 0 0-.54.598v1.383c0 .13-.131.211-.242.161l-4.78-3.52a.63.63 0 0 0-.051-.033.176.176 0 0 1 0-.303.578.578 0 0 0 .05-.033l4.781-3.52Zm1.443 6.448c.081 0 .171.004.267.007a9.29 9.29 0 0 1 2.04.325c1.591.442 3.475 1.443 4.728 3.696a.6.6 0 0 0 1.12-.366c-.557-4.452-2.264-6.794-4.152-7.992-1.494-.948-3.033-1.13-4.003-1.165v-.792a1.374 1.374 0 0 0-2.121-1.152L5.327 9.512a1.377 1.377 0 0 0 0 2.335l4.793 3.528a1.372 1.372 0 0 0 2.12-1.152v-.8Z"></path>
</svg><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/icons/reply.blade.php ENDPATH**/ ?>