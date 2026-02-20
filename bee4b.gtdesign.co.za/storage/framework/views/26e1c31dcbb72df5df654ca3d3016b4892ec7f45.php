<!DOCTYPE html>
<html>
<head>
    <title>Welcome to BEE4B</title>
</head>
<body>
    <h1>Welcome, <?php echo e($name); ?>!</h1>
    <p>Thank you for joining our platform. Here are your login details:</p>
    <ul>
        <li><strong>Email:</strong> <?php echo e($email); ?></li>
        <li><strong>Password:</strong> <?php echo e($password); ?></li>
    </ul>
    <p>Please log in and update your password at your earliest convenience.</p>
    <p><a href="<?php echo e(url('/login')); ?>">Click here to log in</a></p>
</body>
</html>
<?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/emails/welcome.blade.php ENDPATH**/ ?>