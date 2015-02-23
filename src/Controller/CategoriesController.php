<?php

// src/Controller/CategoriesController.php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class CategoriesController extends AppController {

	public function isAuthorized($user) {
		if (in_array($this->request->action, ['add', 'edit', 'delete'])) {
				return true;
		}
	}

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index']);
	}

	public function index() {
		$categories = $this->Categories->find('all');

		if (empty($categories->toArray())) {
			$this->Flash->alert(__('Sorry, There are no categories.'));
			return $this->redirect(['controller' => 'Categories', 'action' => 'add']);
		}

		$this->set(compact('categories'));
	}

	public function add() {
		$category = $this->Categories->newEntity($this->request->data);

		if ($this->request->is('post')) {
			$category = $this->Categories->patchEntity($category, $this->request->data);

			if ($this->Categories->save($category)) {
				$this->Flash->success(__('Your category has been saved.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('Unable to save your category.'));
		}
		$this->set('category', $category);
	}

	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__("Invalid Category"));
		}
		
		$category = $this->Categories->get($id);
		if ($this->request->is(['post', 'put'])) {
			$this->Categories->patchEntity($category, $this->request->data);

			if ($this->Categories->save($category)) {
				$this->Flash->success(__('Category has been updated.'));
				return $this->redirect(['action' => 'index']);
			}

			$this->Flash->error(__('Unable to update the post.'));
		}

		$this->set('category', $category);
	}

	public function delete($id) {
		$this->request->allowMethod(['post', 'delete']);

		$category = $this->Categories->get($id);
		if ($this->Categories->delete($category)) {
			$this->Flash->success(__('The category with id {0} has been deleted.', $id));
			return $this->redirect(['action' => 'index']);
		}
	}

}