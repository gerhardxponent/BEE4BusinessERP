<?php $attributes = $attributes->exceptProps([
    'defaultName' => 'Select Option',
    'options' => [],
    'id' => 'select2',
    'initial' => ''
]); ?>
<?php foreach (array_filter(([
    'defaultName' => 'Select Option',
    'options' => [],
    'id' => 'select2',
    'initial' => ''
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    x-data
    wire:ignore
    x-init = "() => {
        $('#<?php echo e($id); ?>').select2();

        $('#<?php echo e($id); ?>').on('change', function() {
            var data = $('#<?php echo e($id); ?>').select2('val');
            window.livewire.find('<?php echo e($_instance->id); ?>').set('<?php echo e($attributes['wire:model']); ?>', data);
        });

        $('#<?php echo e($id); ?>').val(<?php echo e($initial); ?>).trigger('change');
    }"
    >

    <style>
        .select2-container--default .select2-selection--single{
            border: 1px solid var(--color-gray-300);
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            border-radius: 0.375rem;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-left: 2px;
            height: 42px;
            font-size: 1em;  
            position: relative;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            color: #fff;
            font-size: 1.3em;
            padding: 4px 12px;
            position: absolute;
            top: 6px;
            bottom: 0;
            right: 0px;
            width: 20px;
        }

        /* .select2-dropdown {
            z-index: 1;
        } */

        .select2-dropdown.select2-dropdown--below {
            z-index: 99999 !important;
        }
    </style>

    <select id="<?php echo e($id); ?>" style="width: 100%;" x-ref="select">
        <option value=""><?php echo e($defaultName); ?></option>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($option->id); ?>">
            <?php if(isset($option->name)): ?>
            <?php echo e($option->name); ?>

            <?php else: ?>
            <?php echo e($option->firstname . ' ' . $option->lastname); ?>

            <?php endif; ?>
        </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/select2.blade.php ENDPATH**/ ?>