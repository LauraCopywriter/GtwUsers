<?php echo $this->Html->css('/css/theme'); ?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign up</h1>
            <div class="account-wall">
            
                <img class="profile-img" src="/img/logo.png" alt="">
                <?php echo $this->Form->create('User', array(
                        'action' => 'signup',
                        'class' => 'form-signin',
                        'parsley-validate',
                        'id'=>'UserSignupForm'
                ));?>
            
                    <?php echo $this->Form->input('first',array('type'=>"name",'placeholder'=>"First Name",'class'=>"form-control",'label'=>'First Name','div'=>array('class'=>'form-group')))?>
                    <?php echo $this->Form->input('last',array('type'=>"name",'placeholder'=>"Last Name",'class'=>"form-control",'label'=>'Last Name','div'=>array('class'=>'form-group')))?>
                    <?php echo $this->Form->input('email',array('type'=>"email",'placeholder'=>"Email address",'class'=>"form-control",'label'=>'Email address','div'=>array('class'=>'form-group')))?>
                    <?php echo $this->Form->input('password',array('type'=>"password",'placeholder'=>"Password",'class'=>"form-control",'label'=>'Password','div'=>array('class'=>'form-group')))?>
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
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#UserSignupForm').validate({
		errorClass: "error",
		rules:{
			"data[User][first]":{
				required: true
			},
			"data[User][last]":{
				required: true
			},
			"data[User][email]":{
				required: true,
				email: true
			},
			"data[User][password]":{
				required: true
			}
		},
		messages:{
			"data[User][first]":{
				required: "Please enter firstname"
			},
			"data[User][last]":{
				required: "Please enter lastname"
			},
			"data[User][email]":{
				required: "Please enter Email Address",
				email: "Please enter valid Email Address"
			},
			"data[User][password]":{
				required: "Please enter Password"
			}
		}
	});
});
</script>
