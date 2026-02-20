<?php $attributes = $attributes->exceptProps([
    'link' => './',
    'title' => '',
]); ?>
<?php foreach (array_filter(([
    'link' => './',
    'title' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div>
    <div class="grid grid-cols-2 text-indigo-600 w-full items-center">
        <a href="<?php echo e($link); ?>" class="flex justify-start items-center cursor-pointer gap-1 hover:underline">
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.left-arrow','data' => []]); ?>
<?php $component->withName('icons.left-arrow'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <span class="font-bold text-lg">Back to <?php echo e($slot); ?></span>
        </a>
        <span class="back-title text-xl font-bold text-black max-w-max -translate-x-1/2"><?php echo e($title); ?></span>
    </div>
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/back.blade.php ENDPATH**/ ?>