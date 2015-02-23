<?php

// src/Model/Table/UsersTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
class UsersTable extends Table
{
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Uploader', ['field_name' => 'profile_image']);
        
        $this->addAssociations([
            'hasMany' => [
                'Posts' => [
                    'dependent' => true
                ],
                'comments'
            ]
        ]);
        // $this->hasMany('Posts');
    }

    public function validationDefault(Validator $validator)
    {
    	return $validator
    		->notEmpty('username', 'A username is required')
            // ->add('username', ['alpha' => ['rule' => ['custom', '[a-zA-Z]'], 'message' => 'Only letters allowed',]])
    		->notEmpty('password', 'A password is required')
    		->notEmpty('email', 'A email is required.')
            ->add('email', ['format' => ['rule' => ['custom', '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'], 'message' => 'Enter a valid email.']])
    		->add('email', ['unique' => ['rule' => 'validateUnique', 'provider' => 'table']]);
    }

    public function isCreator($creatorId, $userId)
    {
        return ($creatorId === $userId);
    }


    public function checkKey($username, $activationKey) {

        if (!$this->exists(['username' => $username, 'activation_key' => $activationKey])) {
            return false;
        }

        $user = $this->find('all')->where(['username' => $username, 'activation_key' => $activationKey])->first();

        $user->activation_key = 1;
        $this->save($user);

        return true;
    }
}