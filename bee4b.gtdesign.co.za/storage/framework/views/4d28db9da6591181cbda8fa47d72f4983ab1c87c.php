<?php $attributes = $attributes->exceptProps([
    'makeFilters' => null,
    'checkbox' => null,
    'columns' => null,
    'actions' => null,
    'theme' => null,
    'enabledFilters' => null,
    'inputTextOptions' => [],
    'tableName' => null,
    'filters' => [],
]); ?>
<?php foreach (array_filter(([
    'makeFilters' => null,
    'checkbox' => null,
    'columns' => null,
    'actions' => null,
    'theme' => null,
    'enabledFilters' => null,
    'inputTextOptions' => [],
    'tableName' => null,
    'filters' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <?php if(config('livewire-powergrid.filter') === 'inline'): ?>
        <tr class="<?php echo e($theme->table->trClass); ?> <?php echo e($theme->table->trFiltersClass); ?>" class="<?php echo e($theme->table->trStyle); ?> <?php echo e($theme->table->trFiltersStyle); ?>">
            <?php if(count($makeFilters)): ?>
                <?php if($checkbox): ?>
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>" style="<?php echo e($theme->table->tdBodyStyle); ?>"></td>
                <?php endif; ?>

                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td class="<?php echo e($theme->table->tdBodyClass); ?>"
                        style="<?php echo e($column->hidden === true ? 'display:none': ''); ?>; <?php echo e($theme->table->tdBodyStyle); ?>">
                        <?php $__currentLoopData = data_get($makeFilters, 'date_picker', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($date, 'field') === $column->field): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.filters.date-picker','data' => ['date' => $date,'inline' => true,'column' => $column,'tableName' => $tableName,'theme' => $theme->filterDatePicker]]); ?>
<?php $component->withName('livewire-powergrid::filters.date-picker'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($date),'inline' => true,'column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableName),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->filterDatePicker)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = data_get($makeFilters, 'select', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $select): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($select, 'field') === $column->field): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.filters.select','data' => ['column' => $column,'select' => $select,'inline' => true,'theme' => $theme->filterSelect]]); ?>
<?php $component->withName('livewire-powergrid::filters.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'select' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($select),'inline' => true,'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->filterSelect)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = data_get($makeFilters, 'multi_select', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $multiSelect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($multiSelect, 'field') === $column->field): ?>
                                <?php if ($__env->exists($theme->filterMultiSelect->view, [
                                        'inline' => true,
                                        'column' => $column,
                                        'selected' => $filters['multi_select'] ?? [],
                                        'tableName' => $tableName,
                                ])) echo $__env->make($theme->filterMultiSelect->view, [
                                        'inline' => true,
                                        'column' => $column,
                                        'selected' => $filters['multi_select'] ?? [],
                                        'tableName' => $tableName,
                                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = data_get($makeFilters, 'number', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($number, 'field') === $column->field): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.filters.number','data' => ['number' => $number,'column' => $column,'inline' => true,'theme' => $theme->filterNumber]]); ?>
<?php $component->withName('livewire-powergrid::filters.number'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($number),'column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'inline' => true,'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->filterNumber)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = data_get($makeFilters, 'input_text', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $inputText): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($inputText, 'field') === $column->field): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.filters.input-text','data' => ['inputText' => $inputText,'enabledFilters' => $enabledFilters,'inputTextOptions' => $inputTextOptions,'column' => $column,'inline' => true,'theme' => $theme->filterInputText]]); ?>
<?php $component->withName('livewire-powergrid::filters.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['inputText' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputText),'enabledFilters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($enabledFilters),'inputTextOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputTextOptions),'column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'inline' => true,'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->filterInputText)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = data_get($makeFilters, 'boolean_filter', []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booleanFilter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(data_get($booleanFilter, 'field') === $column->field): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.filters.boolean-filter','data' => ['column' => $column,'booleanFilter' => $booleanFilter,'inline' => true,'theme' => $theme->filterBoolean]]); ?>
<?php $component->withName('livewire-powergrid::filters.boolean-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['column' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($column),'booleanFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($booleanFilter),'inline' => true,'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme->filterBoolean)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($actions) && count($actions)): ?>
                    <td colspan="<?php echo e(count($actions)); ?>"></td>
                <?php endif; ?>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/inline-filters.blade.php ENDPATH**/ ?>