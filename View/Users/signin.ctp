<?php
/*
    Needs parsleyjs or some kind of client side validation
*/
?>

<div class="row">
    <div class="col-md-5">
        <form class="form-horizontal" action='/gtw_users/users/signin' method='post'>
            <h2 class="form-signin-heading">Please sign in</h2>
            <hr/>
             <div class="form-group">
                <label for="signin-email" class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
                    <input id="signin-email" name="data[User][email]" type="email" class="form-control" placeholder="Email address">
                </div>
            </div>
            <div class="form-group">
                <label for="signin-password" class="col-md-2 control-label">Password</label>
                <div class="col-md-10">
                    <input id="signin-password" name="data[User][password]" type="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button class="btn btn-primary" type="submit">Sign in</button>
                </div>
                <div class="col-md-8">
                    <label class="checkbox">
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
            </div>
        </form>
    </div>
    
    <div class="col-md-6 col-md-offset-1">
        <form class="form-horizontal" action='/gtw_users/users/signup' method='post'>
            <h2 class="form-signin-heading">Don't have an account? Sign up</h2>
            <hr/>
             <div class="form-group">
                <label class="col-md-2 control-label">Name</label>
                <div class="col-md-5">
                    <label for="signup-first" class='sr-only'>First</label>
                    <input id="signup-first" name="data[User][first]" type="name" class="form-control" placeholder="First">
                </div>
                <div class="col-md-5">
                    <label for="signup-last" class='sr-only'>Last</label>
                    <input id="signup-last" name="data[User][last]" type="name" class="form-control" placeholder="Last">
                </div>
            </div>
            <div class="form-group">
                <label for="signup-email" class="col-md-2 control-label">Email</label>
                <div class="col-md-10">
                    <input id="signup-email" name="data[User][email]" type="email" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="signup-password" class="col-md-2 control-label">Password</label>
                <div class="col-md-10">
                    <input id="signup-password" name="data[User][password]" type="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="signup-pwdconfirm" class="sr-only">Password Confirmation</label>
                <div class="col-md-10 col-md-offset-2">
                    <input id="signup-pwdconfirm" type="password" class="form-control" placeholder="Password Confirmation">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </div>
                <div class="col-md-8">
                    <label class="checkbox">
                        <input type="checkbox"> Remember me
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>