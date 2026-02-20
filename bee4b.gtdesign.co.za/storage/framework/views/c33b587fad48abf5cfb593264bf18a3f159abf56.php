<?php $attributes = $attributes->exceptProps(['active' => null, 'colour' => 'lime']); ?>
<?php foreach (array_filter((['active' => null, 'colour' => 'lime']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$classes = ($active)
            ? "flex items-center h-10 px-3 text-white bg-b4bgreen-normal rounded-lg transition-colors duration-150 ease-in-out focus:outline-none focus:shadow-outline"
            : "flex items-center h-10 px-3 hover:bg-b4bgreen-normal hover:bg-opacity-25 rounded-lg transition-colors duration-150 ease-in-out focus:outline-none focus:shadow-outline";
?>

<a 
    href="<?php echo e($route); ?>"
    <?php echo e($attributes->merge(['class' => $classes])); ?>

    >
    
    <span class="module-icon">
        <?php echo e($icon); ?>

    </span>
    <span 
        class="ml-2 duration-300 ease-in-out"
        :class="isSidebarExpanded ? 'opacity-100' : 'opacity-0'"
    >
        <?php echo e($name); ?>

    </span>
</a><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/nav-link-hover.blade.php ENDPATH**/ ?>