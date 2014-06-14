<?php 
 $this->Helpers->load('GtwRequire.GtwRequire');
echo $this->Require->req('users/login_validation'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="text-center login-title">Sign in to continue</h1>
            <div class="account-wall">
                <?php echo $this->Html->image("/GtwUsers/img/logo.png", array("class" => "img-responsive profile-img")); ?>
                <?php echo $this->Form->create('User', array(
                        'action' => 'signin',
                        'class' => 'form-signin',
                        'id'=>'UserLoginForm',
                        'novalidate'=>'novalidate'
                ));?>
                    <?php echo $this->Session->flash(); ?>
                    <p class="text-center">

                        <?php
                            echo $this->Html->link('Create an account',
                                array(
                                    'plugin' => 'gtw_users',
                                    'controller' => 'users',
                                    'action' => 'signup'
                                ),
                                array(
                                    'class' => 'text-center new-account',
                                    'style' => 'display:inline-block'
                                )
                            );
                        ?>
                    </p>
                    <input name="data[User][email]" type="text" class="form-control" placeholder="Email" required autofocus>
                    <input name="data[User][password]" type="password" class="form-control" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    <label class="checkbox pull-left col-xs-10">
                        <input name="data[User][remember]" type="checkbox" value="remember-me">
                        Remember me
                    </label>
                    <div class="clearfix"></div>
                    <div class="break-text">
                      <span> &nbsp;&nbsp; OR &nbsp;&nbsp; </span>
                    </div>
                    <p class="text-left">

                    
                    
                        <?php 
                            echo $this->Html->link('<button class="btn btn-lg btn-primary btn-block" ><i class="fa fa-google"></i> &nbsp; Sign in with Google</button>', 
                                array(
                                    'plugin' => 'gtw_users',
                                    'controller' => 'social_signup',
                                    'action' => 'google'
                                ),
                                array(        
                                    'escape' => false
                                )
                            );
                            echo "&nbsp;";
                            echo $this->Html->link('<button class="btn btn-lg btn-primary btn-block"><i class="fa fa-facebook"></i> &nbsp; Sign in with Facebook</button>',
                                array(
                                    'plugin' => 'gtw_users',
                                    'controller' => 'social_signup',
                                    'action' => 'facebook'
                                ),
                                array(                       
                                    'escape' => false
                                )
                            );
                        ?>            
                    </p>
                    
                </form>
                <div class="clearfix"></div>
            </div>
            <p class="text-center">
                <br>
                <?php echo $this->Html->link('Forgot your password?',
                    array(
                        'plugin' => 'gtw_users',
                        'controller' => 'users',
                        'action' => 'forgot_password'
                    )
                );?>
            </p>
        </div>
    </div>
</div>
