<!-- File: src/Template/Categories/add.ctp -->

<h1>Add a new Category</h1>
<?php
	echo $this->Form->create($category);
	echo $this->Form->input('name');
	echo $this->Form->button('Save');
	echo $this->Form->end();
?>