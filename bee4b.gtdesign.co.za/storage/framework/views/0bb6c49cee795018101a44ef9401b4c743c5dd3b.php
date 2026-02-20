<div class="flex flex-col gap-4 justify-center items-center bg-white px-8 py-6 w-full lg:w-1/2 rounded-xl">
    <div class="font-bold text-2xl"><?php echo e($title); ?></div>

    <?php if($editing ?? ''): ?>
    <div>
        <?php echo e($editing ?? ''); ?>

    </div>
    <?php else: ?>
    <div class="w-20 h-20 flex justify-center items-center bg-gray-200 rounded-full">
        <span class="font-bold text-2xl"><?php echo e($initials ?? ''); ?></span>
    </div>

    <div>
        <table class="table-auto">
            <tr>
                <td class="font-bold">Name</td>
                <td class="pl-4"><?php echo e($userName ?? ''); ?></td>
            </tr>
            <tr>
                <td class="font-bold">Email</td>
                <td class="pl-4 break-words"><?php echo e($userEmail ?? ''); ?></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>
</div><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/components/user-block.blade.php ENDPATH**/ ?>