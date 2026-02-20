<div class="header grid grid-cols-2">
    <div>
        <div class="profile-header flex flex-row space-x-4">
            <div class="profile-image rounded-md">
                <div style="width:100px; height:100px;" class="<?php echo e($bgColor ?? 'bg-indigo-500'); ?> initials-block text-white rounded-md flex justify-center items-center">
                    <span class="text-4xl uppercase"><?php echo e($initials ?? ''); ?></span>
                </div>
            </div>
            <div class="profile-header-details flex flex-col align-middle justify-center">
                
                <?php echo e($headerDetails); ?>

            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 content-center justify-items-end align-middle h-full">
        <div class="button-container gap-1 flex flex-col md:flex-row">
            
            <?php echo e($headerButtons ?? ''); ?>

        </div>
    </div>
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/details-header.blade.php ENDPATH**/ ?>