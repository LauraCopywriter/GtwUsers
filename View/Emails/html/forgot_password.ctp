<h1><?php echo __d('gtw_users', 'Forgot Password Email'); ?></h1>
<p>
    <?php echo __d('gtw_users', 'Please visit the following link to reset your password.'); ?><br>
    <?php echo __d('gtw_users', 'This link will expire in 24 Hours.'); ?>  <br>
    <a href="<?php echo FULL_BASE_URL; ?>/gtw_users/users/reset_password/<?php echo $userId . '/' . $token;?>">
        <?php echo FULL_BASE_URL; ?>/gtw_users/users/reset_password/<?php echo $userId . '/' . $token;?>
    </a>
</p>