<?php echo $this->Html->link('Add User', ['action' => 'add']); ?>

<?php echo $this->element('check_login'); ?>
<table>
	<tr>
		<th>Image</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Url</th>
		<th>Action</th>
	</tr>
	<?php foreach ($users as $user) { ?>
	<?php //debug($user->toArray()); ?>
	<tr>
		<?php $img_path = DS.'webroot'.DS.'images'.DS.$user->profile_image; ?>
		<td><?php echo empty($user->profile_image)?'':$this->Image->resize($img_path); ?></td>
		<td><?php echo $user->first_name; ?></td>
		<td><?php echo $user->last_name; ?></td>
		<td><?php echo $user->email; ?></td>
		<td><?php echo $user->url; ?></td>
		<td>
			<?php 
				echo $this->Html->link('View ', ['action' => 'view', $user->id]); 
				echo $this->Html->link('Edit ', ['action' => 'edit', $user->id]);
				echo $this->Form->postLink('Delete', ['action' => 'delete', $user->id], ['confirm' => 'Are you sure?']); ?></td>
	</tr>
	<?php } ?>
</table>