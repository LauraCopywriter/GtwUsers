<?php 
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

$this->Helpers->load('GtwRequire.GtwRequire');
$this->GtwRequire->req("ui/datatables");
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-8"><h3 style='margin-top:0px'>Users</h3></div>
			<div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-plus',' Add User','add',array(),'btn-primary');?></div>
		</div>
	</div>
	<table class="table table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>				
				<th>Last Updated</th>
				<th class='text-center'>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if(empty($users)){?>
				<tr>
					<td colspan='7' class='text-warning'>No record found.</td>
				</tr>
			<?php }else{?>			
				 <?php foreach ($users as $user): ?>
					<tr>
						<td>
							<?php echo $user['User']['id']; ?>
						</td>
						<td>
							<?php echo $user['User']['first']; ?>
						</td>
						<td>
							<?php echo $user['User']['last']; ?>
						</td>
						<td>
							<?php echo $user['User']['email']; ?>
						</td>
						<td>
							<?php echo $user['User']['modified']; ?>
						</td>
						<td class="text-center">
							<span class="text-center">
								<?php echo $this->Html->actionIcon('fa fa-pencil', 'edit', $user['User']['id']);?>
								&nbsp;
								<?php 
                                                                //if($this->Session->read('Auth.User.role')!='admin'){
                                                                if($user['User']['role'] != 'admin'){
                                                                echo $this->Html->link('<i class="fa fa-trash-o"> </i>',array('controller'=>'users','action'=>'delete',$user['User']['id']),array('role'=>'button','escape'=>false,'title'=>'Delete this user'),'Are you sure? You want to delete this user.');
                                                                }
                                                                        ?>
							</span>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php }?>
		</tbody>
	</table>	
</div>