<?php
// src/Model/Entity/Post.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Post extends Entity
{
// 	// Make all fields mass assignable for now.
    protected $_accessible = ['*' => true];

	protected function _getTagString()
	{

	    if (isset($this->_properties['tag_string'])) {
	        return $this->_properties['tag_string'];
	    }
	    if (empty($this->tags)) {
	        return '';
	    }
	    $tags = new Collection($this->tags);
	    $str = $tags->reduce(function ($string, $tag) {
	        return $string . $tag->name . ', ';
	    }, '');

	    return trim($str, ', ');
	}
}