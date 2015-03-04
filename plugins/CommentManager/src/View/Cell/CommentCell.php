<?php

namespace CommentManager\View\Cell;

use Cake\View\Cell;

class CommentCell extends Cell
{

    public function display()
    {
    	$this->loadModel('CommentManager.Comments');
        $ccomment = $this->Comments->newEntity();
        $this->set('ccomment', $ccomment);
    }

}