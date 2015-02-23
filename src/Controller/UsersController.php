<?php

// src/Controller/UsersController.php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Email\Email;
use Cake\Utility\Text;
use Cake\Core\Configure;
use Cake\Utility\Security;

class UsersController extends AppController {

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);

		$this->Auth->allow(['add', 'logout', 'activateUser']);
	}

	public function isAuthorized($user) {

		if (in_array($this->request->action, ['edit', 'delete'])) {
			$userId = (int)$this->request->params['pass'][0];
			if ($this->Users->isCreator($userId, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

	public function index() {
		$users = $this->Users->find('all');		
		if (empty($users->toArray())) {
			return $this->redirect(['controller' => 'Users', 'action' => 'add']);
		}
		
		$this->set(compact('users'));
	}

	public function add() {

		if ($this->Auth->user()) {
			$this->Flash->alert(__('You are already registered, here is your profile.'));
			return $this->redirect(['controller' => 'Users', 'action' => 'view', $this->Auth->user('id')]);
		}

		$user = $this->Users->newEntity($this->request->data());
		$key  = Configure::read('key');

		$new_data = ['activation_key' => Text::uuid()];
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $new_data);
			if ($this->Users->save($user)) {
				$email = new Email("templated");

				$username = Security::encrypt($user->username, $key);
				$email->template('welcome')
					->emailFormat('html')
					->from(['gaurav@sanisoft.com' => 'ChitChat'])
				    ->to($user->email)
				    ->subject('Welcome to our world.')
				    ->viewVars(['user' => $username, 'hash' => $user->activation_key])
				    ->send();
				$this->Flash->success(__('You have successfully registered.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Sorry, something went wrong.'));
		}

		$this->set('user', $user);
	}

	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid User'));
		}

		$user = $this->Users->get($id);
		if ($this->request->is(['post', 'put'])) {
			$this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success(__('Your information has been updated.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('Unable to update your information.'));
		}
		$this->set('user', $user);
	}

	public function delete($id) {
		$this->request->allowMethod(['post', 'delete']);

		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('The user with id: {0} has been deleted.', $id));
			return $this->redirect(['action' => 'logout']);
		}
	}

	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid User'));
		}

		$user = $this->Users->get($id);
		$this->set(compact('user'));
	}

	public function login() {
		if ($this->Auth->user()) {
			$this->Flash->alert(__('You are already logged in.'));
			return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
		}

		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid Username or Password, try again.'));
		}
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function activateUser($username = null, $activation_key = null) {

		$key  	  = Configure::read('key');
		$username = Security::decrypt($username, $key);

		if (!$this->Users->checkKey($username, $activation_key)) {
			$this->Flash->error(__('Invalid activation link.'));
			return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
		}

		$this->Flash->success(__('Successsfully activated, please login to continue.'));
		return $this->redirect(['action' => 'login']);
	}	
}