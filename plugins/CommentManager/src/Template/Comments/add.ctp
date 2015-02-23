<?php
	echo $this->Form->create($comment, ['controller' => 'Comments', 'action' => 'add', $post->id]);
	echo $this->Form->input('body', ['type' => 'textarea', 'rows' => '5', 'cols' => '5']);
	echo $this->Form->input('email');
	echo $this->Form->button('Save');
	echo $this->Form->end();
?>