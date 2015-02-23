<?php

// src/View/Helper/ImageHelper.php

namespace App\View\Helper;

use Cake\View\Helper;

class ImageHelper extends Helper {
	
	public $helpers = ['Html'];

	public function resize($image = null) {

		return $this->Html->image($image, ['width' => '25%']);
	}
}