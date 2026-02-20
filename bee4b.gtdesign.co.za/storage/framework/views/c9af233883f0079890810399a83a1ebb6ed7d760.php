<?php $attributes = $attributes->exceptProps([
    'userNames' => [],
    'max' => 20,
]); ?>
<?php foreach (array_filter(([
    'userNames' => [],
    'max' => 20,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $userInitials = [];
    $count = 1;

    foreach ($userNames as $key => $name) {
        if($name != '') {
            $nameExplode = explode(" ", $name);
            $initials = '';
            $initials .= $nameExplode[0][0];
            $initials .= end($nameExplode)[0];

            array_push($userInitials, $initials);
        }
    }
?>

<div class="flex gap-1">
    <?php $__currentLoopData = $userInitials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $initials): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($count <= $max): ?>
        <div class="avatar shadow-md border-2 border-white w-8 h-8 bg-violet-200 text-base rounded-full flex items-center justify-center">
            <div class="font-bold text-black text-sm"><?php echo e($initials); ?></div>
        </div>
        <?php ++$count; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    

    <?php if(count($userNames) > $max && $max != 0): ?> 
        <div class="avatar shadow-md border-2 border-white w-8 h-8 bg-violet-200 text-base rounded-full flex items-center justify-center">
            <div class="font-bold text-black text-sm">+<?php echo e(count($userNames) - $max); ?></div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/appbee4businessc/public_html/resources/views/components/initials.blade.php ENDPATH**/ ?>