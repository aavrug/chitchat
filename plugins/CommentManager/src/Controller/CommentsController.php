<?php

// plugins/CommentManager/src/Controller/CommentsController.php

namespace CommentManager\Controller;

use CommentManager\Controller\AppController;
use Cake\Core\Configure;

class CommentsController extends AppController {

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add']);
    }

    public function index()
    {
        $comment = new CommentForm();
        if ($this->request->is('post')) {
            if ($comment->execute($this->request->data)) {
                $this->Flash->success('We will get back to you soon.');
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }
        $this->set('comment', $comment);
    }



    // public function index() {
    //     $comments = $this->Comments->find('all');
    //     $this->set(compact('comments'));
    // }

	public function add()
    {
        $ccomment = $this->Comments->newEntity($this->request->data);
        if ($this->request->is('post')) {
            $userId = null;
            if ($this->Auth->user()) {
                $userId = $this->Auth->user('id');
            }
            $newData = ['post_id' => $this->request->params['pass'][0], 'user_id' => $userId];
            $ccomment = $this->Comments->patchEntity($ccomment, $newData);
            if ($this->Comments->save($ccomment)) {
                $this->Flash->success('The comment has been saved.');
                return $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->Flash->error('The comment could not be saved. Please, try again.');
                $session = $this->request->session();
                $session->write('ccomment', $ccomment);
            }
        }
        // $this->set(compact('comment'));        
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

}