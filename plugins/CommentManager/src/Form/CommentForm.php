<?php

// src/Form/CommentForm.php

namespace CommentManager\Form;

use Cake\Form\Form;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class CommentForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('body', ['type' => 'text'])
            ->addField('email', ['type' => 'email']);
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator
        ->notEmpty('body','please enter body.')
        ->notEmpty('email','please enter email.')
        ->add('email', 'format', [
                'rule' => 'email',
                'message' => 'A valid email address is required',
            ]);
    }

    protected function _execute(array $data)
    {
        $Comments = TableRegistry::get('comments');
        
        $Comments->addBehavior('Timestamp'); 

        $ccomment = $Comments->newEntity($data);

        if ($Comments->save($ccomment)) {
            return true;
        } else {
            return false;
        }
    }
}