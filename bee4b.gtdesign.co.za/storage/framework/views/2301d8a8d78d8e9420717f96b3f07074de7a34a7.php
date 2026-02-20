<?php if($queues && $showExporting): ?>

    <?php if($batchExporting && !$batchFinished): ?>
        <div wire:poll="updateExportProgress"
             class="w-full my-3 px-4 rounded py-3 bg-gray-50 shadow-sm dark:bg-gray-500 text-center">
            <div class="dark:text-gray-300"><?php echo e($batchProgress); ?>%</div>
            <div class="dark:text-gray-300"><?php echo e(trans('livewire-powergrid::datatable.export.exporting')); ?></div>
        </div>
    <?php endif; ?>

    <?php if($batchFinished): ?>
        <div class="w-full my-3 dark:bg-gray-800">
            <div x-data={show:true} class="rounded-top">
                <div class="px-4 py-3 rounded-md cursor-pointer bg-gray-50 shadow dark:bg-gray-500"
                     @click="show=!show">
                    <div class="flex justify-between">
                        <button
                            class="appearance-none text-left text-base font-medium text-gray-500 focus:outline-none dark:text-gray-300"
                            type="button">
                            ⚡ <?php echo e(trans('livewire-powergrid::datatable.export.completed')); ?>

                        </button>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.icons.chevron-double-down','data' => ['class' => 'w-5 dark:text-gray-200']]); ?>
<?php $component->withName('livewire-powergrid::icons.chevron-double-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-5 dark:text-gray-200']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                </div>
                <div x-show="show"
                     class="border-l border-b border-r border-gray-200 dark:border-gray-600 px-2 py-4 dark:border-0 dark:bg-gray-700">
                    <?php $__currentLoopData = $exportedFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex w-full p-2">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.icons.download','data' => ['class' => 'w-5 text-gray-700 dark:text-gray-300 mr-3']]); ?>
<?php $component->withName('livewire-powergrid::icons.download'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-5 text-gray-700 dark:text-gray-300 mr-3']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <a class="cursor-pointer text-gray-600 dark:text-gray-300"
                               wire:click="downloadExport('<?php echo e($file); ?>')">
                                <?php echo e($file); ?>

                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/batch-exporting.blade.php ENDPATH**/ ?>