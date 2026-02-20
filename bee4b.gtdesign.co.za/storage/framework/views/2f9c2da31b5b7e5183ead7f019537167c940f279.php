<?php $attributes = $attributes->exceptProps([
    'field' => '',
    'customMessage' => null
]); ?>
<?php foreach (array_filter(([
    'field' => '',
    'customMessage' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<span>
    <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
        <span class="text-red-500 text-sm"><?php echo e(isset($customMessage) ? $customMessage : $message); ?></span> 
    <?php else: ?>
        <div class="text-sm text-gray-500">Required</div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</span><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/validation-error.blade.php ENDPATH**/ ?>