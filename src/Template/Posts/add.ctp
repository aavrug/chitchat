<!-- File: src/Template/Posts/add.ctp -->
<?php echo $this->Html->link('Back', ['action' => 'index']) ?>
<?php echo $this->element('check_login'); ?>
<h1>Add a new Post</h1>
<?php
	echo $this->Form->create($post, ['type' => 'file']);
	echo $this->Form->input('title');
	echo $this->Form->input('body');
	echo $this->Form->file('image', ['type' => 'file']);
	echo $this->Form->input('categories._ids', ['options' => $categories, 'multiple' => 'checkbox'
	]);
	echo $this->Form->input('tag_string', ['type' => 'text']);
	echo $this->Form->button('Save');
	echo $this->Form->end();
?>
<script type="text/javascript">
	CKEDITOR.replace( 'body' );
</script>