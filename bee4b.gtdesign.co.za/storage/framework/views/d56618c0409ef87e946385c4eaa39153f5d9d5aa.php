<?php $attributes = $attributes->exceptProps([
    'options' => [],
    'id' => 'flatpickr',
    'tabindex' => null
]); ?>
<?php foreach (array_filter(([
    'options' => [],
    'id' => 'flatpickr',
    'tabindex' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $options = 
        array_merge([
            'dateFormat' => 'Y-m-d',
            'enableTime' => false,
            'altFormat' =>  'j F Y',
            'altInput' => true
        ], $options);
?>

<div
    wire:ignore
    x-init="() => {
        let inputEl = flatpickr(
            $('#<?php echo e($id); ?>'),
            <?php echo e(json_encode((object)$options)); ?>

        );

        $('.document').ready(function() {
            Livewire.on('clear_flatpickr', function() {
                inputEl.clear();
            })
        });
    }"
    >
    <input 
        class="flatpickr-date w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md"
        id="<?php echo e($id); ?>"
        x-ref="input"
        type="text"
        wire:model.defer="<?php echo e($attributes['wire:model.defer']); ?>"
        placeholder="Select date"
        tabindex="<?php echo e($tabindex); ?>"
    />
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/input/flatpickr.blade.php ENDPATH**/ ?>