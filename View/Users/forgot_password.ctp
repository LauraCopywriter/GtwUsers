<?php echo $this->Html->css('/css/theme'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Forgot your password?</h1>
            <div class="account-wall">            
                <?php echo $this->Html->image('logo.png',array('class'=>'profile-img'))?>
                <?php echo $this->Form->create('User', array(
                        'action' => 'forgot_password',
                        'class' => 'form-signin'
                ));?>
                    <?php echo $this->Session->flash(); ?>
                    <div class='form-group'>
                    	<input name="data[User][email]" type="email" class="form-control" autofocus placeholder="Email" parsley-trigger="change" required>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
                    <span class="clearfix"></span>
                </form>
            </div>
            <?php echo $this->Html->link('Already have an account?',
                array(
                    'plugin' => 'gtw_users',
                    'controller' => 'users',
                    'action' => 'signin'
                ),
                array(
                    'class' => 'text-center new-account'
                ));
             ?>
        </div>
    </div>
</div>