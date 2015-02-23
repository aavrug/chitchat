<?php

// src/Model/Table/PostsTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;
use App\Model\Entity\Post;
use ArrayObject;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class PostsTable extends Table
{
	public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('Uploader', ['field_name' => 'image']);
        $this->addBehavior('Slug', ['title_field' => 'title', 'slug_field' => 'slug', 'replacement' => '_', 'unique' => true]);
        $this->addBehavior('CounterCache', ['Users' => ['post_count']]);

        $this->addAssociations([
            'belongsTo' => [
                'Users' => ['foreignKey' => 'user_id']
                ],
            'hasMany'   => ['comments'],
            'belongsToMany' => ['Categories', 'Tags'],
            ]);
    }

    public function validationDefault(Validator $validator) {
        return $validator
            ->notEmpty('title', 'A title is required.')
            // ->requirePresence('categories._ids')
            ->notEmpty('category', 'Atleast select one category')
            // ->add('title', ['unique' => ['rule' => 'validateUnique', 'message' => 'Title should be unique.', 'provider' => 'table']])
            ->notEmpty('body', 'Body contents required.');
    }

    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);
    }

    public function beforeSave(Event $event, Entity $entity)
    {
        // $posts = TableRegistry::get('Posts');
        // $post = $posts->findBySlug($entity->slug);
        // debug($post);exit;
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }
    }

    protected function _buildTags($tagString)
    {
        $new = array_unique(array_map('trim', explode(',', $tagString)));
        $out = [];
        $query = $this->Tags->find()
            ->where(['Tags.name IN' => $new]);

        // Remove existing tags from the list of new tags.
        foreach ($query->extract('name') as $existing) {
            $index = array_search($existing, $new);
            if ($index !== false) {
                unset($new[$index]);
            }
        }
        // Add existing tags.
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        // Add new tags.
        foreach ($new as $tag) {
            $out[] = $this->Tags->newEntity(['name' => $tag]);
        }

        return $out;
    }

}