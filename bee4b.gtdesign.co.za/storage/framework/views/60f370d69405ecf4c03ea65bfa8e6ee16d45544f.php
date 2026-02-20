<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" >
        <div class="py-2 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8">

            <?php echo $__env->make($theme->layout->header, [
                'enabledFilters' => $enabledFilters
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php if(config('livewire-powergrid.filter') === 'outside'): ?>
                <?php if(count($makeFilters) > 0): ?>
                    <div>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.frameworks.tailwind.filter','data' => ['makeFilters' => $makeFilters,'inputTextOptions' => $inputTextOptions,'tableName' => $tableName,'filters' => $filters,'theme' => $theme]]); ?>
<?php $component->withName('livewire-powergrid::frameworks.tailwind.filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['makeFilters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($makeFilters),'inputTextOptions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inputTextOptions),'tableName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tableName),'filters' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filters),'theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="my-3">
                <?php echo $__env->make($theme->layout->message, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            

            <div class="rounded-lg tbl-container <?php echo e($tableName2 ?? ''); ?>">
                <?php echo $__env->make($table, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <?php echo $__env->make($theme->footer->view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/table-base.blade.php ENDPATH**/ ?>