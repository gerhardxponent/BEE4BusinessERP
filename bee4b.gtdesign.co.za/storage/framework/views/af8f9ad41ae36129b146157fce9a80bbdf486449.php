<!DOCTYPE html>
<html>
<head>
    <title>Folder Assignment Notification</title>
</head>
<body>
<div style="margin-bottom:10px;">
    <strong><?php echo e($commenterName); ?></strong> mentioned you in a comment<?php echo e($location ? ' on: ' . $location : ''); ?>.
</div>

<div style="margin-bottom:20px;">
    <a href="<?php echo e($link); ?>">Go to comment</a>
</div>
</body>
</html>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/emails/comment-mention.blade.php ENDPATH**/ ?>