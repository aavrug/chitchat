<?php

// src/Model/Behavior/SlugBehavior.php

namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use \Exception;
use Cake\Utility\Inflector;

class SlugBehavior extends Behavior {

	public $i = 1;

	protected $_defaultConfig = [
			'title_field' => 'title',
			'slug_field'  => 'slug',
			'replacement' => '-',
			'unique'	  => true
		];

	private function _checkMethod(Entity $entity) {

		$config = $this->config();

		if ($entity->isNew()) {
			$this->unique($entity);
		} else {
			$properties = $entity->toArray();
			$new_title = $properties[$config['title_field']];
			$old_title = $entity->getOriginal($config['title_field']);
			debug($new_title);
			debug($old_title);
			if ($new_title !== $old_title) {
				// $properties_keys = array_keys($properties);
				// $original = $entity->extractOriginal($properties_keys);
				// debug($original[$config['slug_field']]);
				// debug($properties[$config['slug_field']]);exit;
				// $this->slugCreator($entity);
				// $original[$config['slug_field']] = $properties[$config['slug_field']];
				$this->unique($entity);
			}
			return true;
		}
	}

	public function unique(Entity $entity) {

		$config = $this->config();

		$value_exist = $this->_table->exists([$config['slug_field'] => $entity->{$config['slug_field']}]);

		if ($value_exist) {
			$new_slug = preg_replace('/_[0-9]{0,2}\z/', '', $entity->{$config['slug_field']});
			$new_slug = $new_slug.'_'.$this->i;
			$entity->{$config['slug_field']} = $new_slug;
			if ( $entity->getOriginal($config['slug_field']) === $new_slug) {
				$new_slug = $new_slug.'_'.$this->i;
				$entity->{$config['slug_field']} = $new_slug;
			}

			$this->i++;
			$this->unique($entity);
		} else {
			return true;
		}
	}

	public function slugCreator(Entity $entity) {
        $config = $this->config();
        
        if (!isset($entity->{$config['title_field']}) && !isset($entity->{$config['slug_field']})) {
			//throw new Exception(__('Sorry, seems the passed field name doesn\'t exist.'));
		}
         
        $entity->set($config['slug_field'], $this->_createSlug($config, $entity->get($config['title_field'])));
    }

    private function _createSlug($config, $title) {
        
        if (!empty($title)) {
			$modified_title = preg_replace('/\s+/', ' ',$title);
			$modified_title = trim(strtolower($modified_title));
			$slug 			= str_replace(' ', $config['replacement'], $modified_title);
			return $slug;
		}
    }

	public function beforeSave(Event $event, Entity $entity)
    {
    		$config = $this->config();

    		$this->slugCreator($entity);
    		
    		if ($config['unique']) {
    			$this->_checkMethod($entity);
    			// $this->unique($entity);
    		}
    }
}