<!-- File: src/Template/Categories/index.ctp -->
<?php echo $this->Flash->render('auth'); ?>

<?php echo $this->element('check_login'); ?>
<table>
	<tr>
		<th>Name</th>
		<th>Slug</th>
		<th>Published On</th>
		<th>Action</th>
	</tr>
	<?php foreach ($tags as $tag) { ?>
	<tr>
		<td><?php echo $tag->name; ?></td>
		<td><?php echo $tag->slug; ?></td>
		<td><?php echo $tag->created; ?></td>
		<td><?php echo $this->Form->postLink('Delete', ['action' => 'delete', $tag->id], ['confirm' => 'Are you sure?']); ?></td>
	</tr>
	<?php } ?>
</table>