<!-- File: src/Template/Posts/index.ctp -->
<?php echo $this->Flash->render('auth'); ?>
<?php echo $this->Html->link('Add Post', ['action' => 'add']); ?>
<?php echo $this->element('check_login'); ?>
<table>
	<tr>
		<th>Title</th>
		<th>Slug</th>
		<th>Body</th>
		<th>Image</th>
		<th>User Id</th>
		<th>Published On</th>
		<th>Action</th>
	</tr>
	<?php foreach ($posts as $post) { ?>
	<tr>
		<td><?php echo $this->Html->link($post->title, ['action' => 'slugView', $post->slug]); ?></td>
		<!-- <td><?php //echo $post->title; ?></td> -->
		<td><?php echo $post->slug; ?></td>
		<td><?php echo $post->body; ?></td>
		<?php $img_path = DS.'webroot'.DS.'images'.DS.$post->image; ?>
		<!-- <td><?php echo empty($post->image)?'':$this->Html->image($img_path); ?></td> -->
		<td><?php echo empty($post->image)?'':$this->Image->resize($img_path); ?></td>
		<td><?php echo $post->user_id; ?></td>
		<td><?php echo $post->created; ?></td>
		<td><?php echo $this->Html->link('View ', ['action' => 'view', $post->id]);
				  echo $this->Html->link('Edit ', ['action' => 'edit', $post->id]);
				  echo $this->Form->postLink('Delete', ['action' => 'delete', $post->id], ['confirm' => 'Are you sure?']); ?></td>
	</tr>
	<?php } ?>
</table>
<ul class="pagination">
<?php echo $this->Paginator->numbers(); ?>
<?php echo $this->Paginator->prev('« Previous'); ?>
<?php echo $this->Paginator->next('Next »'); ?>
</ul>
