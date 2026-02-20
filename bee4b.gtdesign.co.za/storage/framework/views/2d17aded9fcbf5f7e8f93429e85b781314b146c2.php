<?php $attributes = $attributes->exceptProps([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'inputText' => null,
    'inputTextOptions' => [],
]); ?>
<?php foreach (array_filter(([
    'theme' => '',
    'enabledFilters' => [],
    'column' => null,
    'inline' => null,
    'inputText' => null,
    'inputTextOptions' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div wire:ignore.self
    style="min-width: 9.5rem">
    <?php
        $field = data_get($inputText, 'dataField') ?? data_get($inputText, 'field');
    ?>
    <?php if(filled($inputText)): ?>
        <div class="<?php if(!$inline): ?> pt-2 p-2 <?php endif; ?>">
            <?php if(!$inline): ?>
                <label class="text-gray-700 dark:text-gray-300"><?php echo e(data_get($inputText, 'label')); ?></label>
            <?php endif; ?>
            <div class="<?php if($inline): ?> flex flex-col <?php else: ?> flex flex-row justify-between <?php endif; ?>">
                
                <div class="mt-1">
                    <input
                        data-id="<?php echo e($field); ?>"
                        <?php if(isset($enabledFilters[$field]['disabled']) && boolval($enabledFilters[$field]['disabled']) === true): ?> disabled <?php else: ?>
                        wire:model.debounce.800ms="filters.input_text.<?php echo e($field); ?>"
                        wire:input.debounce.800ms="filterInputText('<?php echo e($field); ?>', $event.target.value, '<?php echo e(data_get($inputText, 'label')); ?>')"
                        <?php endif; ?>
                        type="text"
                        class="w-full px-2 py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        placeholder="<?php echo e(empty($column)?data_get($inputText, 'label'):($column->placeholder?:ucfirst(strtolower($column->title)))); ?>">
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/filters/input-text.blade.php ENDPATH**/ ?>