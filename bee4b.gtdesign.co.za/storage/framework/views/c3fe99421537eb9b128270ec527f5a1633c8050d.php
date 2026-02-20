<div>
    <div class="pr-6 border-r border-gray-200 flex flex-col gap-1">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div 
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'p-2 rounded-md cursor-pointer',
                    'bg-indigo-100 text-indigo-900 font-bold' => $currentSection == $section,
                    'hover:bg-gray-200 active:bg-gray-300' => $currentSection != $section,
                ]) ?>"
                wire:click="changeSection('<?php echo e($section); ?>')"
                >
                <?php echo e(ucfirst($section)); ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/livewire/settings/components/sections.blade.php ENDPATH**/ ?>