<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>
    <div>
        <div style="margin-bottom: 20px;"><?php echo $data; ?></div>

        <?php if($link != ''): ?>
        <a href="<?php echo e($link); ?>">View in system</a>
        <?php endif; ?>
    </div>
</body>
</html><?php /**PATH /home/appbee4businessc/public_html/resources/views/mail.blade.php ENDPATH**/ ?>