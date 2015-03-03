<?php 
 $this->Helpers->load('GtwRequire.GtwRequire');
echo $this->Require->req('users/register_validation'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __d('gtw_users', 'Sign up'); ?></h1>
            <div class="account-wall">
            
                <?php echo $this->Html->image("/GtwUsers/img/logo.png", array("class" => "img-responsive profile-img")); ?>
                <?php echo $this->Form->create('User', array(
                        'action' => 'signup',
                        'class' => 'form-signin',
                        'parsley-validate',
                        'id'=>'UserSignupForm',
                        'novalidate'=>'novalidate'
                ));?>
            
                    <div class="form-group">
                        <label for="signup-first"><?php echo __d('gtw_users', 'First Name'); ?></label>
                        <input id="signup-first" name="data[User][first]" type="name" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-last"><?php echo __d('gtw_users', 'Last Name'); ?></label>
                        <input id="signup-last" name="data[User][last]" type="name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="signup-email"><?php echo __d('gtw_users', 'Email address'); ?></label>
                        <input id="signup-email" name="data[User][email]" type="email" class="form-control" placeholder="Email" parsley-trigger="change" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password"><?php echo __d('gtw_users', 'Password'); ?></label>
                        <input id="signup-password" name="data[User][password]" type="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo __d('gtw_users', 'Sign up'); ?></button>
                    
                </form>
            </div>
                <?php echo $this->Html->link(__d('gtw_users', 'Already have an account?'),
                array(
                    'plugin' => 'gtw_users',
                    'controller' => 'users',
                    'action' => 'signin'
                ),
                array(
                    'class' => 'text-center new-account'
                )
            );?>
        </div>
    </div>
</div>
