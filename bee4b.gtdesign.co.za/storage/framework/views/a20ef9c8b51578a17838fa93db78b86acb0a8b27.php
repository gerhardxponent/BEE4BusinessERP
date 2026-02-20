<?php $helperClass = app('PowerComponents\LivewirePowerGrid\Helpers\Helpers'); ?>
<?php $attributes = $attributes->exceptProps([
    'actions' => null,
    'theme' => null,
    'row' => null,
]); ?>
<?php foreach (array_filter(([
    'actions' => null,
    'theme' => null,
    'row' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <?php if(isset($actions) && count($actions) && $row !== ''): ?>
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td class="pg-actions <?php echo e($theme->table->tdBodyClass); ?>"
                style="<?php echo e($theme->table->tdBodyStyle); ?>">
                <?php
                    $class            = filled($action->class) ? $action->class : $theme->actions->headerBtnClass;
                    $class            = $attributes->class($class);
                    if($action->singleParam) {
                        $actionParameters = $helperClass->makeActionParameter($action->param, $row);
                    } else {
                        $actionParameters = $helperClass->makeActionParameters($action->param, $row);
                    }

                    $rules            = $helperClass->makeActionRules($action, $row);

                    $ruleRedirect     = data_get($rules, 'redirect');
                    $ruleDisabled     = data_get($rules, 'disable');
                    $ruleHide         = data_get($rules, 'hide', false);
                    $ruleSetAttribute = data_get($rules, 'setAttribute');
                    $ruleEmit         = data_get($rules, 'emit');
                    $ruleEmitTo       = data_get($rules, 'emitTo');
                    $ruleCaption      = data_get($rules, 'caption');

                    $action->emit     = false;
                    $action->emitTo   = false;

                    if(isset($ruleSetAttribute['attribute'])) {
                         $class = $attributes->merge([$ruleSetAttribute['attribute'] => $ruleSetAttribute['value']])->class($class);
                    }

                    if (filled($ruleEmit)) {
                        $event['event']  = $ruleEmit['event'];
                        $event['params'] = $helperClass->makeActionParameters(data_get($ruleEmit, 'params', []), $row);
                        $action->emit = true;
                    } else if (filled($ruleEmitTo) ) {
                        $event['to']     = $ruleEmitTo['to'] ?? '';
                        $event['event']  = $ruleEmitTo['event'];
                        $event['params'] = $helperClass->makeActionParameters(data_get($ruleEmitTo, 'params', []), $row);
                        $action->emitTo = true;
                    } else {
                        if (filled($action->event)) {
                            $action->emit    = true;
                            $event['event']  = $action->event;
                            $event['params'] = $actionParameters;

                            if (filled($action->to)) {
                                $action->emit    = false;
                                $action->emitTo  = true;
                                $event['to']     = $action->to;
                            }
                        }
                     }
                ?>
                <div class="w-full md:w-auto"
                     style="display: <?php echo e($ruleHide ? 'none': 'block'); ?>"
                >
                    <?php if((filled($action->event) || isset($event['event']) || filled($action->view)) && is_null($ruleRedirect)): ?>
                        <button
                            <?php if($action->emit): ?>
                            wire:click='$emit("<?php echo e($event['event']); ?>", <?php echo json_encode($event['params'], 15, 512) ?>)'
                            <?php endif; ?>
                            <?php if($action->emitTo): ?>
                            wire:click='$emitTo("<?php echo e($event['to']); ?>", "<?php echo e($event['event']); ?>", <?php echo json_encode($event['params'], 15, 512) ?>)'
                            <?php endif; ?>
                            <?php if($action->view): ?>
                            wire:click='$emit("openModal", "<?php echo e($action->view); ?>", <?php echo json_encode($actionParameters, 15, 512) ?>)'
                            <?php endif; ?>

                            <?php if($ruleDisabled): ?> disabled <?php endif; ?>
                            title="<?php echo e($action->tooltip); ?>"
                            <?php echo e($class); ?>

                        >
                            <?php echo $ruleCaption ?? $action->caption; ?>

                        </button>
                    <?php endif; ?>

                    <?php if(filled($ruleRedirect)): ?>
                        <a <?php if($ruleDisabled): ?> disabled
                           <?php else: ?>
                           href="<?php echo e($ruleRedirect['url']); ?>" target="<?php echo e($ruleRedirect['target']); ?>"
                           <?php endif; ?>
                           title="<?php echo e($action->tooltip); ?>"
                           <?php echo e($class); ?>>
                            <?php echo $ruleCaption ?? $action->caption; ?>

                        </a>
                    <?php endif; ?>

                    <?php if(filled($action->route)): ?>
                        <?php if(strtolower($action->method) !== 'get'): ?>
                            <form target="<?php echo e($action->target); ?>"
                                  action="<?php echo e(route($action->route, $actionParameters)); ?>"
                                  method="post">
                                <?php echo method_field($action->method); ?>
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                        title="<?php echo e($action->tooltip); ?>"
                                        <?php if($ruleDisabled): ?> disabled <?php endif; ?> <?php echo e($class); ?>>
                                    <?php echo $ruleCaption ?? $action->caption; ?>

                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route($action->route, $actionParameters)); ?>"
                               target="<?php echo e($action->target); ?>"
                               title="<?php echo e($action->tooltip); ?>"
                               <?php echo e($class); ?>

                            >
                                <?php echo $ruleCaption ?? $action->caption; ?>

                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/actions.blade.php ENDPATH**/ ?>