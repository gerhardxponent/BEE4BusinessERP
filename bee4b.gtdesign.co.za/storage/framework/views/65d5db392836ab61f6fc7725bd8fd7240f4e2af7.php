<?php $attributes = $attributes->exceptProps([
    'breadcrumbs' => []
]); ?>
<?php foreach (array_filter(([
    'breadcrumbs' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="flex items-start justify-between pb-4 space-y-4 lg:items-center lg:space-y-0 lg:flex-row">
    <div class="w-full text-2xl font-semibold whitespace-nowrap flex justify-between items-center">
        <?php if(isset($title)): ?>
        <span class="mr-4"><?php echo e($title ?? ''); ?></span>
        <?php endif; ?>
        <div class="flex flex-row items-center justify-start space-x-2">
            <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $bc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="flex flex-row items-center justify-start space-x-2">
                <?php if($index != 0): ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <polyline points="9 6 15 12 9 18"></polyline>
                </svg>
                <?php endif; ?>

                <?php if($index != count($breadcrumbs)-1): ?>
                <a 
                    class="text-blue-700 hover:underline"
                    href="../<?php echo e(lcfirst($bc)); ?>"
                    >
                    <?php echo e($bc); ?>

                </a>
                <?php else: ?>
                <span class="font-bold"><?php echo e($bc); ?></span>
                <?php endif; ?>
            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php echo e($button ?? ''); ?>

    </div>
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/header.blade.php ENDPATH**/ ?>