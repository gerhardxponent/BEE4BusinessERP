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

<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pinned-off" width="<?php echo e(isset($size) ? $size : $width); ?>" height="<?php echo e(isset($size) ? $size : $height); ?>" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
    <line x1="3" y1="3" x2="21" y2="21"></line>
    <path d="M15 4.5l-3.249 3.249m-2.57 1.433l-2.181 .818l-1.5 1.5l7 7l1.5 -1.5l.82 -2.186m1.43 -2.563l3.25 -3.251"></path>
    <line x1="9" y1="15" x2="4.5" y2="19.5"></line>
    <line x1="14.5" y1="4" x2="20" y2="9.5"></line>
</svg><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/icons/unpin.blade.php ENDPATH**/ ?>