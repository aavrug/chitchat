<?php
	$post = $this->cell('Post::display', ['id' => $this->request->params['pass'][0]]); 
	echo $post;
?>

<?php echo $this->element('comments'); ?>

<?php
	echo $this->Form->create($ccomment);
	echo $this->Form->input('body', ['type' => 'textarea', 'rows' => '5', 'cols' => '5']);
	echo $this->Form->input('email');
	echo $this->Form->button('Save');
	echo $this->Form->end();
?>