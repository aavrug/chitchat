<?php

// src/Model/Table/TagsTable.php

namespace App\Model\Table;

use Cake\ORM\Table;

class TagsTable extends Table {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');
	}

}