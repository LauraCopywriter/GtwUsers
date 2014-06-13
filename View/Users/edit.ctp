<?php 
    $this->Helpers->load('GtwRequire.GtwRequire');
    $this->GtwRequire->req('users/reset_password');
?>
<?php echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
)); ?>
<input id="user-id" type="hidden" value="<?php echo $this->request->data['User']['id'] ?>" />
        <?php echo $this->Form->input('first', array(
            'label' => 'First Name',
        )); ?>
        <?php echo $this->Form->input('last', array(
            'label' => 'Last Name',
        )); ?>
        <?php echo $this->Form->input('email', array(
            'label' => 'Email',
        )); ?>				
        <?php echo $this->Form->submit('Save', array(
            'div' => false,
            'class' => 'btn btn-primary'
        )); ?>
<?php echo $this->Form->end(); ?>
