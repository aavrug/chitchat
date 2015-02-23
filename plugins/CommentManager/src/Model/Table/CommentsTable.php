<?php

// plugins/CommentManager/src/Model/Table/CommentsTable.php

namespace CommentManager\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table {

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
		$this->addAssociations([
            'belongsTo' => [
                'Users' => ['foreignKey' => 'user_id'],
                'Posts' => ['foreignKey' => 'post_id']
                ],
        ]);
	}

	public function validationDefault(Validator $validator) {
        return $validator
            ->notEmpty('body', 'Body contents required.')
            ->notEmpty('email', 'An email is required.')
            ->add('email', ['format' => ['rule' => ['custom', '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'], 'message' => 'Enter a valid email.']]);
    }
}