<?php
	echo $this->Form->create($ccomment, ['url' => ['plugin' => 'CommentManager', 'controller' => 'Comments', 'action' => 'add', $this->request->params['pass'][0]]]);
	echo $this->Form->input('body', ['type' => 'textarea', 'rows' => '5', 'cols' => '5', 'class' => 'comment-field']);
	echo $this->Form->input('email', ['class' => 'comment-field']);
	echo $this->Form->button('Save');
	echo $this->Form->end();
?>