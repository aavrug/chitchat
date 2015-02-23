<!-- File: src/Template/Categories/index.ctp -->
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Html->link('Add Category', ['action' => 'add']); ?>
<?php echo $this->element('check_login'); ?>
<table>
	<tr>
		<th>Name</th>
		<th>Slug</th>
		<th>Published On</th>
		<th>Action</th>
	</tr>
	<?php foreach ($categories as $category) { ?>
<?php //debug($categories->toArray()); ?>
	<tr>
		<td><?php echo $category->name; ?></td>
		<td><?php echo $category->slug; ?></td>
		<td><?php echo $category->created; ?></td>
		<td><?php echo $this->Html->link('Edit ', ['action' => 'edit', $category->id]);
				  echo $this->Form->postLink('Delete', ['action' => 'delete', $category->id], ['confirm' => 'Are you sure?']); ?></td>
	</tr>
	<?php } ?>
</table>