<?php $attributes = $attributes->exceptProps(['options' => []]); ?>
<?php foreach (array_filter((['options' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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

<div wire:ignore>
    <style>
        .flatpickr-date {
            background-color: #F4F4F4;
        }
    </style>

    <input 
        class="flatpickr-date w-full py-3 border-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-xl shadow-sm"
        x-data="{
                init() {
                    let inputEl = flatpickr(
                        this.$refs.input, 
                        <?php echo e(json_encode((object)$options)); ?>

                    );

                    $('.document').ready(function() {
                        Livewire.on('clear_flatpickr', function() {
                            inputEl.clear();
                        })
                    });
                }
            }"
            x-ref="input"
            type="text"
            wire:model.lazy="<?php echo e($attributes['wire:model.lazy']); ?>"
            placeholder="Select date"
        
    />
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/date-range.blade.php ENDPATH**/ ?>