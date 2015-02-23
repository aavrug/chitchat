<?php
	echo $this->Form->create($ccomment,['role' => 'form', 0 => 'novalidate']);
	echo $this->Form->input('body');
	echo $this->Form->input('email');
	echo $this->Form->button('Submit');
	echo $this->Form->end();
?>