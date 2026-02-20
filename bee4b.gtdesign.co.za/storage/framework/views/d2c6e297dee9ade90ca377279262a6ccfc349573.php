<!DOCTYPE html>
<html>
<head>
    <title>Folder Assignment Notification</title>
</head>
<body>
    <p>Hi <?php echo e($userName); ?>,</p>
    
    <p>You have been assigned as the responsible person for all items in the folder <strong><?php echo e($folderName); ?></strong> under the audit <strong><?php echo e($auditName); ?></strong>.</p>

    <p>Please review your assigned items at your earliest convenience.</p>

    <p>Best regards,</p>
    <p>The BEE4Business Team</p>
</body>
</html>
<?php /**PATH /home/appbee4businessc/public_html/resources/views/emails/folder-assigned.blade.php ENDPATH**/ ?>