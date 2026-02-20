<?php $attributes = $attributes->exceptProps([
    'theme' => '',
    'inline' => null,
    'number' => null,
    'column' => '',
]); ?>
<?php foreach (array_filter(([
    'theme' => '',
    'inline' => null,
    'number' => null,
    'column' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    <?php if(filled($number)): ?>
        <div class="<?php if(!$inline): ?> pt-2 p-2 <?php endif; ?>">
            <?php if(!$inline): ?>
                <label class="text-gray-700 dark:text-gray-300"><?php echo e(data_get($number, 'label')); ?></label>
            <?php endif; ?>
            <div class="<?php if($inline): ?> flex flex-col <?php else: ?>  flex flex-row justify-between <?php endif; ?>">
                <div class="<?php if(!$inline): ?> pl-0 pt-1 pr-3 <?php endif; ?>">
                    <input
                        data-id="<?php echo e(data_get($number, 'field')); ?>"
                        wire:model.debounce.800ms="filters.number_start.<?php echo e(data_get($number, 'dataField')); ?>"
                        wire:input.debounce.800ms="filterNumberStart('<?php echo e(data_get($number, 'dataField')); ?>', $event.target.value,'<?php echo e(addslashes(data_get($number, 'thousands'))); ?>','<?php echo e(addslashes(data_get($number, 'decimal'))); ?>','<?php echo e(data_get($number, 'label')); ?>')"
                        <?php if($inline): ?> style="<?php echo e($theme->inputStyle); ?> <?php echo e(data_get($column, 'headerStyle')); ?>" <?php endif; ?>
                        type="text"
                        class="px-2 py-1 w-1/2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        placeholder="Min">
                </div>
                <div class="mt-1">
                    <input
                        data-id="<?php echo e($number['field']); ?>"
                        wire:model.debounce.800ms="filters.number_end.<?php echo e(data_get($number, 'dataField')); ?>"
                        wire:input.debounce.800ms="filterNumberEnd('<?php echo e(data_get($number, 'dataField')); ?>',$event.target.value,'<?php echo e(addslashes(data_get($number, 'thousands'))); ?>','<?php echo e(addslashes(data_get($number, 'decimal'))); ?>', '<?php echo e(data_get($number, 'label')); ?>')"
                        <?php if($inline): ?> style="<?php echo e($theme->inputStyle); ?> <?php echo e(data_get($column, 'headerStyle')); ?>" <?php endif; ?>
                        type="text"
                        class="px-2 py-1 w-1/2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        placeholder="Max">
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/filters/number.blade.php ENDPATH**/ ?>