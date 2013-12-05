<?php 
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

$this->Helpers->load('GtwRequire.GtwRequire');
$this->GtwRequire->req("ui/datatables");
?>

<h1>Users</h1>

<table class="table table-hover table-striped datatable">
    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>modified</th>
            <th style="display:none"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <?php echo $this->Html->actionLink($user['User']['email'], 'view', $user['User']['id']); ?>
            </td>
            <td><?php echo $user['User']['last']. ', ' . $user['User']['first']; ?></td>
            <td><?php echo $user['User']['modified']; ?></td>
            <td>
                <span class="pull-right">
                    <?php 
                        echo $this->Html->actionIcon('icon-edit', 'edit', $user['User']['id']);
                        echo $this->Html->actionIcon('icon-envelope-alt', 'mesage', $user['User']['id']);
                        echo $this->Html->actionIcon('icon-remove', 'delete', $user['User']['id']); 
                    ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>