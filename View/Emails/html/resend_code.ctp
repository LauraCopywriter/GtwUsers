<?php echo __d('gtw_users','Hello %s',$user['first'])?>

<h1><?php echo __d('gtw_users','Account Activation Code'); ?></h1>
<p>
   <?php echo __d('gtw_users','Please visit the following link to confirm your account'); ?>  <br>
	
	<a href="<?php echo FULL_BASE_URL; ?>/gtw_users/users/confirmation/<?php echo $userId . '/' . $token;?>">
        <?php echo FULL_BASE_URL; ?>/gtw_users/users/confirmation/<?php echo $userId . '/' . $token;?>
    </a>
</p>