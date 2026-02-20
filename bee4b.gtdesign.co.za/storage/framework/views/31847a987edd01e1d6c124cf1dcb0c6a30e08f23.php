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

<svg width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" stroke="currentColor" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path d="M12 20.75a8.75 8.75 0 1 1 0-17.5 8.75 8.75 0 0 1 0 17.5ZM12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"></path>
    <path d="m13.162 10.235-2.862.359-.103.475.563.103c.367.088.44.22.36.587l-.923 4.335c-.242 1.121.132 1.648 1.01 1.648.682 0 1.473-.315 1.832-.747l.11-.52c-.25.22-.615.307-.858.307-.344 0-.469-.24-.38-.666l1.251-5.881Zm.088-2.61a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0Z"></path>
</svg><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/components/icons/info2.blade.php ENDPATH**/ ?>