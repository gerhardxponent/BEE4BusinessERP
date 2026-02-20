<p>Hi <?php echo e($user->name); ?>,</p>

<p>You’ve been assigned to the audit <strong><?php echo e($audit->name); ?></strong>. Below is a list of files you still need to upload:</p>

<ul>
    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($file->file_name); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<p>Please log in to the system and upload the outstanding files at your earliest convenience.</p>

<p>Regards,<br/>BEE4Business</p>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/emails/audit-upload-reminder.blade.php ENDPATH**/ ?>