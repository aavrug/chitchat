<?php

// src/Model/Behavior/UploaderBehavior.php

namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;

class UploaderBehavior extends Behavior {

	public function type(Entity $entity) {
		$config 	= $this->config();
		$match 		= false;
		$file_types = ['jpeg', 'png', 'jpg', 'bmp'];

		if (isset($entity->{$config['field_name']}) && !empty($entity->{$config['field_name']})) {
			$extension = pathinfo($entity->{$config['field_name']}['name'], PATHINFO_EXTENSION);
			foreach ($file_types as $file_type) {
				if ($extension == $file_type) {
					$match = true;
					break;
				}	
			}

			$this->_checkMethod($entity, $match);
		}

	}

    private function _checkMethod(Entity $entity, $match = false) {

        $config = $this->config();

        if ($entity->isNew()) {
            $this->upload($entity, $match);
        } else {
            $value = $this->_table->get($entity->id);

            if (!empty($value->{$config['field_name']}) && empty($entity->{$config['field_name']}['name'])) {
                $entity->{$config['field_name']} = $value->{$config['field_name']};
            } else {
                $this->upload($entity, $match);
            }
        }
    }
	public function upload(Entity $entity, $match = false) {
        
        $config = $this->config();
        $target = WWW_ROOT.'images';  
        $scan   = is_dir($target);
        if (!$scan) {
            mkdir($target, 0777, true);
            chmod($target, 0777);
        }

        $dir_path = WWW_ROOT.'images';
        if ($entity->{$config['field_name']}['error'] === 4 || !$match) {
            $entity->{$config['field_name']} = NULL;
        } else {
            move_uploaded_file($entity->{$config['field_name']}['tmp_name'] , $dir_path.'/'.$entity->{$config['field_name']}['name']);
            $entity->{$config['field_name']} = $entity->{$config['field_name']}['name'];
        }
        return true;
	}

	public function beforeSave(Event $event, Entity $entity)
    {
    	$this->type($entity); 
    }

    public function afterDelete(Event $event, Entity $entity) {
        $image = $entity->image;
        if (!$image) {
            return;
        }

        $image_path = WWW_ROOT.'images'.'/'.$entity->image;
        $file_exist = file_exists($image_path);
        
        if ($file_exist) {
            unlink($image_path);
        }
    }
}