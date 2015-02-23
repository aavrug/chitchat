<!-- File: src/Template/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
	echo $this->Form->create($user, ['type' => 'file']);
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('date_of_birth', [
							    'label' => 'Date of birth',
							    'minYear' => date('Y') - 70,
							    'maxYear' => date('Y') - 18,
							]);
	echo $this->Form->input('first_name');
	echo $this->Form->input('last_name');
	echo $this->Form->input('email');
	echo $this->Form->input('url');
	echo $this->Form->file('profile_image', ['type' => 'file']);
	echo $this->Form->button(__('Save'));
	echo $this->Form->end();
?>