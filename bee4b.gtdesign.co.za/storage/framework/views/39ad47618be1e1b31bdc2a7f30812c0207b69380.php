<div class="main-content space-y-4 relative">
    <div class="header grid grid-cols-2">
        <div>
            <div class="profile-header flex flex-row space-x-4">
                <div class="profile-image rounded-md">
                    <div style="width:100px; height:100px;" class="<?php echo e($bgColor ?? 'bg-indigo-500'); ?> text-white rounded-md flex justify-center items-center">
                        <span class="text-4xl uppercase"><?php echo e($initials ?? ''); ?></span>
                    </div>
                </div>
                <div class="profile-header-details flex flex-col align-middle justify-center">
                    
                    <?php echo e($headerDetails); ?>

                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 content-center justify-items-end align-middle h-full">
            <div class="button-container gap-1 flex items-center">
                
                <?php echo e($headerButtons ?? ''); ?>

            </div>
        </div>
    </div>

    
    <?php echo e($sential ?? ''); ?>


    <?php if(isset($tabs)): ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.tabs.tab-layout','data' => []]); ?>
<?php $component->withName('tabs.tab-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
            <?php echo e($tabs ?? ''); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>

    

    <div class="w-full grid grid-cols-1 detail-section mt-4">
        <?php echo $__env->yieldContent('fullWidth'); ?>
    </div>

    <?php if(isset($leftColum) || isset($rightColumn)): ?>
    <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-4 detail-section">
        <div class="left-column space-y-4">
            <?php echo e($leftColumn ?? ''); ?>

        </div>

        <div class="right-column space-y-4">
            <?php echo e($rightColumn ?? ''); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php if(isset($column1) || isset($column2) || isset($column3)): ?>
    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 detail-section">
        <div class="space-y-4">
            <?php echo e($column1 ?? ''); ?>

        </div>

        <div class="space-y-4">
            <?php echo e($column2 ?? ''); ?>

        </div>

        <div class="space-y-4">
            <?php echo e($column3 ?? ''); ?>

        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /Applications/MAMP/htdocs/app.bee4business.co.za/resources/views/components/details.blade.php ENDPATH**/ ?>