<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-8"><h3 style='margin-top:0px'>Add User</h3></div>
			<div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply',' Back','index');?></div>
		</div>
	</div>
	<div class="panel-body">
		<?php 
			$this->Helpers->load('GtwRequire.GtwRequire');
		?>
		<?php echo $this->Form->create('User', array('inputDefaults' => array('div' => 'col-md-12 form-group','class' => 'form-control'),'class' => 'form-horizontal','id'=>'CompanyAddForm', 'novalidate'=>'novalidate')); ?>
		<div class="row">
			<div class="col-md-12">				
				<?php echo $this->Form->input('first', array(
					'label' => 'First Name',
				)); ?>
				<?php echo $this->Form->input('last', array(
					'label' => 'Last Name',
				)); ?>
				<?php echo $this->Form->input('email', array(
					'label' => 'Email',
				)); ?>
				<?php echo $this->Form->input('password'); ?>

				<?php echo $this->Form->submit('Create User', array(
					'div' => false,
					'class' => 'btn btn-primary'
				)); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
