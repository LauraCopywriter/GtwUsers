<h1>Users</h1>

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
            <td><a href="/gtw_users/users/view/<?php echo $user['User']['id'];?>"><?php echo $user['User']['email'] ?></a></td>
            <td><?php echo  $user['User']['last']. ', ' . $user['User']['first']; ?></td>
            <td><?php echo $user['User']['modified']; ?></td>
            <td>
                <a href="/gtw_users/users/edit/<?php echo $user['User']['id']?>"><i class="icon-edit"></i></a>
                <a href="/gtw_users/users/edit/<?php echo $user['User']['id']?>"><i class="icon-envelope-alt"></i></a>
                <a href="/gtw_users/users/delete/<?php echo $user['User']['id']?>"><i class="icon-remove"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
