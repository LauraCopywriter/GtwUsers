<h2> Sign in </h2>
<hr/>
<form role="form">
    <div class="form-horizontal">
        <div class="form-group">
            <label for="signin-email" class="col-md-2 control-label">Email</label>
            <div class="col-md-10">
                <input type="email" class="form-control" id="signin-email" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="signin-password" class="col-md-2 control-label">Password</label>
            <div class="col-md-10">
                <input type="password" class="form-control" id="signin-password" placeholder="Password">
            </div>
        </div>
    
        <div class="form-group">
            <div class="col-md-offset-2 col-md-2">
                <button id='signin-submit' type="button" class="btn btn-primary">Sign in</button>
            </div>
            <div class="col-md-8">
                <label class="checkbox">
                    <input id='signin-rememberme' type="checkbox"> Remember me
                </label>
            </div>
        </div>
    </div>
</form>

<?php echo $this->GtwHtml->js_module('../../GtwUsers/signin'); ?>