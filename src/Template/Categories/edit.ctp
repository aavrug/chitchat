<!-- File: src/Template/Categories/edit.ctp -->

<h1>Update Category</h1>
<?php
	echo $this->Form->create($category);
	echo $this->Form->input('name');
	echo $this->Form->button('Update');
	echo $this->Form->end();
?>