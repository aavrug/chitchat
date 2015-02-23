<?php

// src/Model/CategoriesTable.php

namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriesTable extends Table {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp');

		// $this->addAssociations([
  //           'belongsToMany' => ['Posts']
  //           ]);
	}

}