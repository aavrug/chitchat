<?php

// src/Controller/TagsController.php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

class TagsController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['index']);
	}

	public function isAuthorized($user) {
		if (in_array($this->request->action, ['add', 'edit', 'delete'])) {
				return true;
		}
	}

	public function index() {
		$tags = $this->Tags->find('all');

		if (empty($tags->toArray())) {
			$this->Flash->alert(__('Sorry, There are no tags.'));
			return $this->redirect(['Controller' => 'posts', 'action' => 'index']);
		}

		$this->set(compact('tags'));
	}

	public function delete($id) {
		$this->request->allowMethod(['post', 'delete']);

		$post = $this->Tags->get($id);
		if ($this->Tags->delete($post)) {
			$this->Flash->success(__('The tag with {0} has been deleted.', $id));
			return $this->redirect(['action' => 'index']);
		}
	}

}
