<?php if(count($perPageValues) > 1): ?>
<div class="<?php if($perPageInput): ?> justify-between <?php else: ?> justify-end <?php endif; ?> md:flex md:flex-row w-full items-center pt-3 overflow-y-auto pl-2 pr-2 pb-1  dark:bg-gray-700">

    <?php if($perPageInput && count($perPageValues) > 1): ?>
        <div class="flex flex-row justify-center md:justify-start mb-2 md:mb-0">
            <div class="h-10">
                <select wire:model.lazy="perPage"
                        class="block appearance-none bg-gray-50 border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:bg-gray-500 dark:text-gray-200 dark:placeholder-gray-200 dark:border-gray-500">
                    <?php $__currentLoopData = $perPageValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>">
                            <?php if($value == 0): ?>
                                <?php echo e(trans('livewire-powergrid::datatable.labels.all')); ?>

                            <?php else: ?>
                                <?php echo e($value); ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.icons.down','data' => ['class' => 'w-4 h-4']]); ?>
<?php $component->withName('livewire-powergrid::icons.down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            </div>
            <div class="pl-4 hidden sm:block md:block lg:block w-full" style="padding-top: 6px;">
            </div>
        </div>
    <?php endif; ?>

    <?php if(filled($data)): ?>
        <div>
            <?php if(method_exists($data, 'links')): ?>
                <?php echo $data->links(powerGridThemeRoot().'.pagination', ['recordCount' => $recordCount]); ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/footer.blade.php ENDPATH**/ ?>