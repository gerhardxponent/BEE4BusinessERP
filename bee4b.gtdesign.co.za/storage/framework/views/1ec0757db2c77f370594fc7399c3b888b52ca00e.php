<?php $attributes = $attributes->exceptProps([
    'theme' => null
]); ?>
<?php foreach (array_filter(([
    'theme' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div class="tbl-fixed">
        <table class="table power-grid-table bg-white <?php echo e($theme->tableClass); ?>"
                style="<?php echo e($theme->tableStyle); ?>">
        <thead class="bg-gray-200 <?php echo e($theme->theadClass); ?>"
                style="<?php echo e($theme->theadStyle); ?>">
                <?php echo e($header); ?>

        </thead>
        <tbody class="<?php echo e($theme->tbodyClass); ?> tbl-body"
                style="<?php echo e($theme->tbodyStyle); ?>">
                <?php echo e($rows); ?>

        </tbody>
        </table>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/table-base.blade.php ENDPATH**/ ?>