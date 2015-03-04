<?php

namespace App\View\Cell;

use Cake\View\Cell;

class PostCell extends Cell
{

    public function display($id)
    {
    	$this->loadModel('Posts');
        $post = $this->Posts->get($id);
        $this->set('post', $post);
    }

}