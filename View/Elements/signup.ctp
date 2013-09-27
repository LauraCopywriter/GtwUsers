<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */
 ?>

<h2>Sign up</h2>
<hr/>
<form role="form">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-2 control-label" for="registerFirstName">Name</label>
            <div class="col-md-5">
                <label for="signup-first" class='sr-only'>First</label>
                <input type="name" class="form-control" id="signup-first" placeholder="First">
            </div>
            <div class="col-md-5">
                <label for="signup-last" class='sr-only'>Last</label>
                <input type="name" class="form-control" id="signup-last" placeholder="Last">
            </div>
        </div>
        <div class="form-group">
            <label for="signup-email" class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
                <input type="email" class="form-control" id="signup-email" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="signup-password" class="col-md-2 control-label">Password</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="signup-password" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <label for="signup-pwdconfirm" class="sr-only">Password Confirmation</label>
            <div class="col-md-10 col-md-offset-2">
                <input type="password" class="form-control" id="signup-pwdconfirm" placeholder="Password Confirmation">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-2">
                <button id='signup-submit' type="button" class="btn btn-primary">Sign up</button>
            </div>
            <div class="col-md-8">
                <label class="checkbox">
                    <input id='signup-rememberme' type="checkbox"> Remember me
                </label>
            </div>
        </div>
    </div>
</form>

<?php echo $this->GtwHtml->js_module('../../GtwUsers/signup'); ?>