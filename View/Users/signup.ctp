<?php echo $this->Html->css('/css/theme'); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign up</h1>
            <div class="account-wall">
            
                <img class="profile-img" src="/img/logo.png" alt="">
                <?php echo $this->Form->create('User', array(
                        'action' => 'signup',
                        'class' => 'form-signin',
                        'parsley-validate'
                ));?>
            
                    <div class="form-group">
                        <label for="signup-first">First Name</label>
                        <input id="signup-first" name="data[User][first]" type="name" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-last">Last Name</label>
                        <input id="signup-last" name="data[User][last]" type="name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email address</label>
                        <input id="signup-email" name="data[User][email]" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" parsley-trigger="change" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input id="signup-password" name="data[User][password]" type="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
                    
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
                )
            );?>
        </div>
    </div>
</div>

    <?php echo Router::url( $this->here, true ); ?> http://localhost/gtw_users/users/signup 
    <br>
    <?php echo $this->here; ?> /gtw_users/users/signup
    <br>
    <?php echo $_SERVER[ 'REQUEST_URI' ]; ?> /gtw_users/users/signup  
    <br>
    <?php echo $this->Html->url( null, true ); ?> http://localhost/gtw_users/users/signup
    <br>
    <?php debug(FULL_BASE_URL); ?>
    