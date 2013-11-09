<?php 
    $this->Helpers->load('GtwRequire.GtwRequire');
    echo $this->GtwRequire->req('users/reset_password');
?>

<?php 
    echo $this->Form->create('User', array(
        'inputDefaults' => array(
            'div' => 'form-group',
            'wrapInput' => false,
            'class' => 'form-control'
        ),
    ));
?>

<div class="row">
    <div class="col-md-12">
        <h1><?php echo $this->request->data['User']['first'].' '.$this->request->data['User']['last']?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <img src="http://i.imgur.com/dCVa3ik.jpg" class="img-responsive img-thumbnail" alt="Responsive image">
    </div>
    <div class="col-md-8">
        <fieldset>
            <?php echo $this->Form->input('email', array(
                'label' => 'Email',
            )); ?>
            <?php echo $this->Form->input('password', array(
                'label' => 'Password',
                'type' => 'hidden'
            )); ?>
            <div class="form-group">
                <label for="decoy-password">Password</label>
                <input type="password" name="decoy-password" class="form-control" value="DefaultPassword" id="decoy-password">
            </div>
            <?php echo $this->Form->input('first', array(
                'label' => 'First Name',
            )); ?>
            <?php echo $this->Form->input('last', array(
                'label' => 'Last Name',
            )); ?>
            <?php echo $this->Form->submit('Save', array(
                'div' => false,
                'class' => 'btn btn-default'
            )); ?>
        </fieldset>
    </div>
</div>

<?php echo $this->Form->end(); ?>