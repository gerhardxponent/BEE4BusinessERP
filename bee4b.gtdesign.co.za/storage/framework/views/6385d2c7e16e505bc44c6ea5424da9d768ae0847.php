<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Assignment Notification</title>
</head>
<body>
    <p>Dear <?php echo e($userName); ?>,</p>

    <p>You have been assigned as the responsible person for the document <strong><?php echo e($documentName); ?></strong> in the audit <strong><?php echo e($auditName); ?></strong>.</p>
    <p>
        Click here to view the audit:  
        <a href="<?php echo e($auditUrl); ?>">BEE4Business | <?php echo e($clientName); ?> | <?php echo e($auditName); ?></a>
    </p>

    <p>Please ensure that the document is handled appropriately.</p>

    <p>Thank you,</p>
    <p>BEE4Business</p>
</body>
</html>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/emails/document-assigned.blade.php ENDPATH**/ ?>