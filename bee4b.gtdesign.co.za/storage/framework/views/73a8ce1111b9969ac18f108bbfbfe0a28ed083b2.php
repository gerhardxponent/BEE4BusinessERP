<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Activity Type</th>
            <th>Path</th>
            <th>Date</th>
            <th>Files</th>
            <th>Comment</th>
        </tr>
    </thead>

    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->user->name); ?></td>
                <td><?php echo e($item->activity_type); ?></td>
                <td><?php echo e(strip_tags($item->path)); ?></td>
                <td><?php echo e($item->created_at); ?></td>
                <td>
                    <?php if($item->activity_type === 'file upload'): ?>
                        <?php echo e(preg_replace('/&nbsp;/', ' ', strip_tags($item->body))); ?>

                        
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($item->activity_type === 'comment'): ?>
                        <?php echo e(preg_replace('/&nbsp;/', ' ', strip_tags($item->body))); ?>

                    <?php endif; ?> 
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/exports/activities.blade.php ENDPATH**/ ?>