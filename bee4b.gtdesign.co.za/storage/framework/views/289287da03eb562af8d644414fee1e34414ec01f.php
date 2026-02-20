<?php $helperClass = app('PowerComponents\LivewirePowerGrid\Helpers\Helpers'); ?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.table-base','data' => ['theme' => $theme->table]]); ?>
<?php $component->withName('livewire-powergrid::table-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->table)]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <tr class="<?php echo e($theme->table->trClass); ?>" style="<?php echo e($theme->table->trStyle); ?>">
            <?php if($checkbox): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.checkbox-all','data' => ['checkbox' => $checkbox,'theme' => $theme->checkbox]]); ?>
<?php $component->withName('livewire-powergrid::checkbox-all'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['checkbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkbox),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->checkbox)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.cols','data' => ['column' => $column,'theme' => $theme,'sortField' => $sortField,'sortDirection' => $sortDirection,'enabledFilters' => $enabledFilters]]); ?>
<?php $component->withName('livewire-powergrid::cols'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'sortField' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sortField),'sortDirection' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sortDirection),'enabledFilters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enabledFilters)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(isset($actions) && count($actions)): ?>
                <th class="sticky top-0 left-0 <?php echo e($theme->table->thClass .' '. $column->headerClass); ?>" scope="col"
                    style="<?php echo e($theme->table->thStyle); ?>" colspan="<?php echo e(count($actions )); ?>"
                    wire:key="<?php echo e(md5('actions')); ?>">
                    <?php echo e(trans('livewire-powergrid::datatable.labels.action')); ?>

                </th>
            <?php endif; ?>
        </tr>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('rows', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.inline-filters','data' => ['makeFilters' => $makeFilters,'checkbox' => $checkbox,'actions' => $actions,'columns' => $columns,'theme' => $theme,'filters' => $filters,'enabledFilters' => $enabledFilters,'inputTextOptions' => $inputTextOptions,'tableName' => $tableName]]); ?>
<?php $component->withName('livewire-powergrid::inline-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['makeFilters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($makeFilters),'checkbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkbox),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'enabledFilters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enabledFilters),'inputTextOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputTextOptions),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableName)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if(is_null($data) || count($data) === 0): ?>
            <th>
                <tr class="<?php echo e($theme->table->trBodyClass); ?>" style="<?php echo e($theme->table->trBodyStyle); ?>">
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>" style="<?php echo e($theme->table->tdBodyStyle); ?>" colspan="<?php echo e((($checkbox) ? 1:0)
                                    + ((isset($actions)) ? 1: 0)
                                    + (count($columns))); ?>">
                        <span><?php echo e(trans('livewire-powergrid::datatable.labels.no_data')); ?></span>
                    </td>
                </tr>
            </th>
        <?php else: ?>
            <?php if($headerTotalColumn): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.table-header','data' => ['currentTable' => $currentTable,'primaryKey' => $primaryKey,'theme' => $theme,'columns' => $columns,'checkbox' => $checkbox,'data' => $data,'actions' => $actions,'withoutPaginatedData' => $withoutPaginatedData]]); ?>
<?php $component->withName('livewire-powergrid::table-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentTable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTable),'primaryKey' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryKey),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'checkbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkbox),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'withoutPaginatedData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($withoutPaginatedData)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $class            = $theme->table->trBodyClass;
                    $rules            = $helperClass->makeActionRules('pg:rows', $row);

                    $ruleSetAttribute = data_get($rules, 'setAttribute');

                    if (filled($ruleSetAttribute)) {
                        foreach ($ruleSetAttribute as $attribute) {
                           if (isset($attribute['attribute'])) {
                              $class .= ' '.$attribute['value'];
                           }
                        }
                    }
                ?>
                <tr class="<?php echo e($class); ?>"
                    style="<?php echo e($theme->table->trBodyStyle); ?>"
                    wire:key="<?php echo e(md5($row->{$primaryKey} ?? $loop->index)); ?>">
                    <?php if($checkbox): ?>
                        <?php
                            $rules            = $helperClass->makeActionRules('pg:checkbox', $row);
                            $ruleHide         = data_get($rules, 'hide');
                            $ruleDisable      = data_get($rules, 'disable');
                            $ruleSetAttribute = data_get($rules, 'setAttribute');
                        ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.checkbox-row','data' => ['theme' => $theme->checkbox,'ruleHide' => $ruleHide,'ruleDisable' => $ruleDisable,'ruleSetAttribute' => $ruleSetAttribute[0] ?? [],'attribute' => $row->{$checkboxAttribute},'checkbox' => $checkbox]]); ?>
<?php $component->withName('livewire-powergrid::checkbox-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->checkbox),'ruleHide' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ruleHide),'ruleDisable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ruleDisable),'ruleSetAttribute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ruleSetAttribute[0] ?? []),'attribute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row->{$checkboxAttribute}),'checkbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkbox)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.row','data' => ['tableName' => $tableName,'currentTable' => $currentTable,'primaryKey' => $primaryKey,'theme' => $theme,'row' => $row,'columns' => $columns]]); ?>
<?php $component->withName('livewire-powergrid::row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableName),'currentTable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTable),'primaryKey' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryKey),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'row' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.actions','data' => ['primaryKey' => $primaryKey,'theme' => $theme,'row' => $row,'actions' => $actions]]); ?>
<?php $component->withName('livewire-powergrid::actions'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['primary-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryKey),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'row' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($row),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($footerTotalColumn): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.table-footer','data' => ['currentTable' => $currentTable,'primaryKey' => $primaryKey,'theme' => $theme,'columns' => $columns,'checkbox' => $checkbox,'data' => $data,'actions' => $actions,'withoutPaginatedData' => $withoutPaginatedData]]); ?>
<?php $component->withName('livewire-powergrid::table-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['currentTable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentTable),'primaryKey' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryKey),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columns),'checkbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkbox),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($data),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($actions),'withoutPaginatedData' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($withoutPaginatedData)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/table.blade.php ENDPATH**/ ?>