<h1>Users</h1>

<?php 
    $this->Helpers->load('GtwUsers.GtwUser');
?>

<?php echo $this->Html->datatable('userlist');?>
<table id='userlist' class="table table-hover table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>modified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <?php echo $this->GtwUser->viewLnk($user['User']['id'], $user['User']['email']); ?>
            </td>
            <td><?php echo $user['User']['last']. ', ' . $user['User']['first']; ?></td>
            <td><?php echo $user['User']['modified']; ?></td>
            <td>
                <?php 
                    echo $this->GtwUser->editLnk($user['User']['id']);
                    echo $this->GtwUser->messageLnk($user['User']['id']);
                    echo $this->GtwUser->deleteLnk($user['User']['id']); 
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>