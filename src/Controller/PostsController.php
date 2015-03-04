<?php

// src/Controller/PostsController.php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
use CommentManager\Form\CommentForm;

class PostsController extends AppController {

	public $helpers = ['Image'];

	public $paginate = [
        'limit' => 10,
        'order' => [
            'Posts.title' => 'asc'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

	public function isAuthorized($user) {
		// All users can add posts
		if ($this->request->action === 'add') {
			return true;
		}

		if (in_array($this->request->action, ['edit', 'delete'])) {
			$postId = $this->request->params['pass'][0];

			if ($this->Posts->isOwnedBy($postId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index']);
	}

	public function index() {
		$posts = $this->Posts->find('all');

		if (empty($posts->toArray())) {
			return $this->redirect(['controller' => 'Posts', 'action' => 'add']);
		}

		$this->set('posts', $this->paginate());
		// $this->set(compact('posts'));
		// $this->set('_serialize', 'posts');
	}

	public function add() {
		$post = $this->Posts->newEntity($this->request->data, ['associated' => ['Categories' => ['validate' => 'notEmpty']]]);

		if ($this->request->is('post')) {
			$newData = ['user_id' => $this->Auth->user('id')];
			// $this->request->data['user_id'] = $this->Auth->user('id');
			$post = $this->Posts->patchEntity($post, $newData);
			// $post->user_id = $this->Auth->user('id');
			// debug($post);exit;
			if ($this->Posts->save($post)) {
				$this->Flash->success(__('Your post has been saved.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('Unable to save your post.'));
		}
		$categories = $this->Posts->Categories->find('list');
		$this->set('post', $post);
		$this->set(compact('post', 'categories'));
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__("Invalid Post"));
		}

		$comments = $this->Posts->Comments->findByPostId($id);
		$post = $this->Posts->get($id);
		$session = $this->request->session();
		// $ccomment = $session->consume('ccomment');
		// $ccomment = new CommentForm();

		if ($this->request->is('post')) {

			$data = $this->request->data; 
			if ($this->Auth->user()) {

				$data['user_id'] = $this->Auth->user('id');	
				
			}
			
			$data['post_id'] = $this->request->params['pass'][0];

			// if ( $ccomment->execute($data))
			// {
			// 	$this->Flash->success('Success');

			// 	return $this->redirect(['action' => 'view', $id]); 
				
			// } else {
			// 	$this->Flash->error('Error!');
			// }
		}

		// $ccomment = $this->loadModel('Comments.Comments');
		$this->set(compact('post', 'comments', 'ccomment'));
	}

	public function slugView($slug = null) {
		if (!$slug) {
			throw new NotFoundException(__("Invalid Post"));
		}

		$post =  $this->Posts->findBySlug($slug);
		$post = $post->toArray()[0];
		$this->set(compact('post'));
	}

	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Post'));
		}

		$post = $this->Posts->get($id, ['contain' => ['Categories', 'Tags' ,'Users']]);

		if ($this->request->is(['post', 'put'])) {
			$this->Posts->patchEntity($post, $this->request->data);

			if ($this->Posts->save($post)) {
				$this->Flash->success(__('Post has been updated.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('Unable to update the post.'));
		}
		$categories = $this->Posts->Categories->find('list');
		$tags 		= $this->Posts->Tags->find('list');
		
		$this->set('post', $post);
		$this->set(compact('post', 'categories', 'tags'));
	}

	public function delete($id) {
		$this->request->allowMethod(['post', 'delete']);

		$post = $this->Posts->get($id);
		if ($this->Posts->delete($post)) {
			$this->Flash->success(__('The post with {0} has been deleted.', $id));
			return $this->redirect(['action' => 'index']);
		}
	}
}