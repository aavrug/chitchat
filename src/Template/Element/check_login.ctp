<?php

	echo $this->Html->css(['custom']);
	echo $this->Html->script('jquery-1.11.2');
	echo $this->Html->script('custom-script');

	if (!$this->Session->read('Auth.User') && empty($this->Session->read('Auth.User'))) {
		echo $this->Html->link(' Login', ['controller' => 'Users', 'action' => 'login'], ['class' => 'right']);
	} else {
		$user = $this->Session->read('Auth.User');
		// $username = $user['username'];
		// echo $this->Html->link($username, ['controller' => 'Users', 'action' => 'logout'], ['class' => 'right']);
		$list = [
		    $this->Html->link($user['username'], [], ['class' => 'link']),
	        $this->Html->link('Profile', ['controller' => 'Users', 'action' => 'view', $user['id'], 'plugin' => false], ['class' => 'sub-links']),
	        $this->Html->link('Comments', ['plugin' => 'CommentManager', 'controller' => 'Comments', 'action' => 'index'], ['class' => 'sub-links']),
	        $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout', 'plugin' => false], ['class' => 'sub-links']),
		    ];
		echo $this->Html->nestedList($list, ['class' => 'right admin-menu']);
	}
?>