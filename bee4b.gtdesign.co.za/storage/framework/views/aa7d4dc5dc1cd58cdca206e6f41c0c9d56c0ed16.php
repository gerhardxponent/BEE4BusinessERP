<!DOCTYPE html>
<html>
<head>
    <title>Folder Assignment Notification</title>
</head>
<body>
    <p>Hi <?php echo e($userName); ?>,</p>
    
    <p>You have been assigned as the responsible person for all items in the folder <strong><?php echo e($folderName); ?></strong> under the audit <strong><?php echo e($auditName); ?></strong>.</p>
    <p>
        Click here to view the audit:  
        <a href="<?php echo e($auditUrl); ?>"><a href="<?php echo e($auditUrl); ?>">BEE4Business | <?php echo e($clientName); ?> | <?php echo e($auditName); ?></a></a>
    </p>

    <p>Please review your assigned items at your earliest convenience.</p>

    <p>Best regards,</p>
    <p>The BEE4Business Team</p>
</body>
</html>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/emails/folder-assigned.blade.php ENDPATH**/ ?>