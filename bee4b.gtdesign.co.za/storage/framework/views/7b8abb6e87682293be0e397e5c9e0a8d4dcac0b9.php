<?php $helperClass = app('PowerComponents\LivewirePowerGrid\Helpers\Helpers'); ?>
<?php $attributes = $attributes->exceptProps([
    'actions' => null,
    'theme' => null,
]); ?>
<?php foreach (array_filter(([
    'actions' => null,
    'theme' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="w-full md:w-auto">
    <div class="sm:flex sm:flex-row">
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="sm:mr-2 w-auto">
                <?php
                    if($action->singleParam) {
                        $parameters = $helperClass->makeActionParameter($action->param);
                    } else {
                        $parameters = $helperClass->makeActionParameters($action->param);
                    }
                ?>
                <?php if($action->event !== '' && $action->to === ''): ?>
                    <a wire:click='$emit("<?php echo e($action->event); ?>", <?php echo json_encode($parameters, 15, 512) ?>)'
                       target="<?php echo e($action->target); ?>"
                       title="<?php echo e($action->tooltip); ?>"
                       class="<?php echo e(filled($action->class) ? $action->class : $theme->actions->headerBtnClass); ?>">
                        <?php echo $action->caption; ?>

                    </a>
                <?php elseif($action->event !== '' && $action->to !== ''): ?>
                    <a wire:click='$emitTo("<?php echo e($action->to); ?>", "<?php echo e($action->event); ?>", <?php echo json_encode($parameters, 15, 512) ?>)'
                       target="<?php echo e($action->target); ?>"
                       title="<?php echo e($action->tooltip); ?>"
                       class="<?php echo e(filled($action->class) ? $action->class : $theme->actions->headerBtnClass); ?>">
                        <?php echo $action->caption; ?>

                    </a>
                <?php elseif($action->view !== ''): ?>
                    <a wire:click='$emit("openModal", "<?php echo e($action->view); ?>", <?php echo json_encode($parameters, 15, 512) ?>)'
                       target="<?php echo e($action->target); ?>"
                       title="<?php echo e($action->tooltip); ?>"
                       class="<?php echo e(filled($action->class) ? $action->class : $theme->actions->headerBtnClass); ?>">
                        <?php echo $action->caption; ?>

                    </a>
                <?php else: ?>
                    <?php if(strtolower($action->method) !== 'get'): ?>
                        <form target="<?php echo e($action->target); ?>"
                              action="<?php echo e(route($action->route, $parameters)); ?>"
                              method="<?php echo e($action->method); ?>">
                            <?php echo method_field($action->method); ?>
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    title="<?php echo e($action->tooltip); ?>"
                                    class="<?php echo e(filled( $action->class) ? $action->class : $theme->actions->headerBtnClass); ?>">
                                <?php echo $action->caption ?? ''; ?>

                            </button>
                        </form>
                    <?php else: ?>
                        <a href="<?php echo e(route($action->route, $parameters)); ?>"
                           title="<?php echo e($action->tooltip); ?>"
                           target="<?php echo e($action->target); ?>"
                           class="<?php echo e(filled($action->class) ? $action->class : $theme->actions->headerBtnClass); ?>">
                            <?php echo $action->caption; ?>

                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/actions-header.blade.php ENDPATH**/ ?>