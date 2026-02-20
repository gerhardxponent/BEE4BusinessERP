<div class="md:flex md:flex-row w-full justify-between items-center">

    <div class="md:flex md:flex-row w-full">

        <div>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'livewire-powergrid::components.actions-header','data' => ['theme' => $theme,'actions' => $this->headers]]); ?>
<?php $component->withName('livewire-powergrid::actions-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['theme' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($theme),'actions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($this->headers)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </div>

        <div class="flex flex-row justify-center items-center text-sm">
            <?php if($exportActive): ?>
                <div class="mr-2 mt-2 sm:mt-0 flex flex-row space-x-1">
                    <?php echo $__env->make(powerGridThemeRoot().'.export', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php if(isset($emailFiles)): ?>
                        <?php if($emailFiles): ?>
                        <?php echo $__env->make(powerGridThemeRoot().'.email-files', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($__env->exists(powerGridThemeRoot().'.toggle-columns')) echo $__env->make(powerGridThemeRoot().'.toggle-columns', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>

        <!-- LOADING -->
        <?php echo $__env->make(powerGridThemeRoot().'.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <div class="flex gap-2 w-full justify-end items-center">
        <?php echo $__env->make(powerGridThemeRoot(). '.archive', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div>
            <?php echo $__env->make(powerGridThemeRoot().'.search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>

</div>

<?php echo $__env->make(powerGridThemeRoot().'.batch-exporting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make(powerGridThemeRoot().'.enabled-filters', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/vendor/livewire-powergrid/components/frameworks/tailwind/header.blade.php ENDPATH**/ ?>